<?php

namespace App\Services;

use App\Data\CategoryData;
use App\Models\CategoryModel;
use RuntimeException;

class CategoryService extends BaseService
{
    public function __construct(protected CategoryModel $categoryModel)
    {
        parent::__construct();
    }

    protected function prepareCreateData(CategoryData $data): array
    {
        return [
            'name'        => $data->name,
            'slug'        => $this->generateSlug($data->name),
            'description' => $data->description,
            'status'      => $data->status,
            'sort_order'  => $data->sortOrder,
            'created_by'  => auth()->id(),
        ];
    }

    public function create(CategoryData $data): ServiceResult
    {
        return $this->transaction(function () use ($data) {
            $insertData = $this->prepareCreateData($data);

            $id = $this->categoryModel->insert($insertData, true);

            if (!$id) {
                return ServiceResult::failure('Failed to create category.', $this->categoryModel->errors());
            }

            $category = $this->categoryModel->find($id);

            return ServiceResult::success('Category created successfully.', $category);
        });
    }

    protected function prepareUpdateData(int $id, CategoryData $data): array
    {
        return [
            'name'        => $data->name,
            'slug'        => $this->generateSlug($data->name, $id),
            'description' => $data->description,
            'sort_order'  => $data->sortOrder,
            'status'      => $data->status,
            'updated_by'  => auth()->id(),
        ];
    }

    public function update(int $id, CategoryData $data): ServiceResult
    {
        return $this->transaction(function () use ($id, $data) {
            if (!$this->find($id)) {
                throw new RuntimeException('Category not found.');
            }

            $updateData = $this->prepareUpdateData($id, $data);

            if (!$this->categoryModel->update($id, $updateData)) {
                return ServiceResult::failure('Failed to update category.', $this->categoryModel->errors());
            }

            return ServiceResult::success('Category updated successfully.', $this->find($id));
        });
    }

    public function delete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $category = $this->find($id);

            if (!$category) {
                throw new RuntimeException('Category not found.');
            }

            $this->categoryModel->update($id, [
                'deleted_by' => auth()->id(),
            ]);

            $this->categoryModel->delete($id);

            return ServiceResult::success('Category moved to trash.');
        });
    }

    public function restore(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $category = $this->categoryModel->withDeleted()->find($id);

            if (!$category) {
                throw new RuntimeException('Category not found.');
            }

            // 🟢 Chaining withDeleted() removes the "WHERE deleted_at IS NULL" restriction
            $restored = $this->categoryModel->withDeleted()->update($id, [
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

            if (!$restored) {
                return ServiceResult::failure('Failed to restore category.');
            }

            return ServiceResult::success('Category restored successfully.');
        });
    }

    public function forceDelete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $category = $this->categoryModel->withDeleted()->find($id);

            if (!$category) {
                throw new RuntimeException('Category not found.');
            }

            $this->categoryModel->delete($id, true);

            return ServiceResult::success('Category permanently deleted.');
        });
    }

    public function find(int $id): ?array
    {
        return $this->categoryModel->find($id);
    }

    public function paginate(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->categoryModel
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC');

        // 1. Apply Search Filter
        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        // 2. Apply Status Filter (Handles '0' correctly using strict check)
        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('status', (int) $filters['status']);
        }

        return [
            'categories' => $builder->paginate($perPage),
            'pager'      => $this->categoryModel->pager,
            'filters'    => $filters,
        ];
    }

    public function paginateDeleted(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->categoryModel
            ->onlyDeleted()
            ->orderBy('deleted_at', 'DESC')
            ->orderBy('name', 'ASC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('status', (int) $filters['status']);
        }

        return [
            'categories' => $builder->paginate($perPage),
            'pager'      => $this->categoryModel->pager,
            'filters'    => $filters,
        ];
    }

    protected function generateSlug(string $name, ?int $ignoreId = null): string
    {
        helper('text');

        $slug     = url_title($name, '-', true);
        $original = $slug;
        $counter  = 1;

        while (true) {
            $builder = $this->categoryModel->where('slug', $slug);

            if ($ignoreId !== null) {
                $builder->where('id !=', $ignoreId);
            }

            if (!$builder->first()) {
                break;
            }

            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }


    public function getNextSortOrder(): int
    {
        return $this->categoryModel->getNextSortOrder();
    }
}
