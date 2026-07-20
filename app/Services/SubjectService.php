<?php

namespace App\Services;

use App\Data\SubjectData;
use App\Models\SubjectModel;
use RuntimeException;

class SubjectService extends BaseService
{
    public function __construct(protected ?SubjectModel $subjectModel = null)
    {
        parent::__construct();
        $this->subjectModel = $subjectModel ?? new SubjectModel();
    }

    protected function prepareCreateData(SubjectData $data): array
    {
        return [
            'name'        => $data->name,
            'slug'        => $this->generateSlug($data->name),
            'code'        => $data->code,
            'description' => $data->description,
            'status'      => $data->status,
            'sort_order'  => $data->sortOrder,
            'created_by'  => auth()->id(),
        ];
    }

    public function create(SubjectData $data): ServiceResult
    {
        return $this->transaction(function () use ($data) {
            $insertData = $this->prepareCreateData($data);

            $id = $this->subjectModel->insert($insertData, true);

            if (!$id) {
                return ServiceResult::failure('Failed to create subject.', $this->subjectModel->errors());
            }

            $subject = $this->subjectModel->find($id);

            return ServiceResult::success('Subject created successfully.', $subject);
        });
    }

    protected function prepareUpdateData(int $id, SubjectData $data): array
    {
        return [
            'name'        => $data->name,
            'slug'        => $this->generateSlug($data->name, $id),
            'code'        => $data->code,
            'description' => $data->description,
            'sort_order'  => $data->sortOrder,
            'status'      => $data->status,
            'updated_by'  => auth()->id(),
        ];
    }

    public function update(int $id, SubjectData $data): ServiceResult
    {
        return $this->transaction(function () use ($id, $data) {
            if (!$this->find($id)) {
                throw new RuntimeException('Subject not found.');
            }

            $updateData = $this->prepareUpdateData($id, $data);

            if (!$this->subjectModel->update($id, $updateData)) {
                return ServiceResult::failure('Failed to update subject.', $this->subjectModel->errors());
            }

            return ServiceResult::success('Subject updated successfully.', $this->find($id));
        });
    }

    public function delete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $subject = $this->find($id);

            if (!$subject) {
                throw new RuntimeException('Subject not found.');
            }

            $this->subjectModel->update($id, [
                'deleted_by' => auth()->id(),
            ]);

            $this->subjectModel->delete($id);

            return ServiceResult::success('Subject moved to trash.');
        });
    }

    public function restore(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $subject = $this->subjectModel->withDeleted()->find($id);

            if (!$subject) {
                throw new RuntimeException('Subject not found.');
            }

            $restored = $this->subjectModel->withDeleted()->update($id, [
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

            if (!$restored) {
                return ServiceResult::failure('Failed to restore subject.');
            }

            return ServiceResult::success('Subject restored successfully.');
        });
    }

    public function forceDelete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $subject = $this->subjectModel->withDeleted()->find($id);

            if (!$subject) {
                throw new RuntimeException('Subject not found.');
            }

            $this->subjectModel->delete($id, true);

            return ServiceResult::success('Subject permanently deleted.');
        });
    }

    public function find(int $id): ?array
    {
        return $this->subjectModel->find($id);
    }

    public function paginate(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->subjectModel
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('status', (int) $filters['status']);
        }

        return [
            'subjects' => $builder->paginate($perPage),
            'pager'    => $this->subjectModel->pager,
            'filters'  => $filters,
        ];
    }

    public function paginateDeleted(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->subjectModel
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
            'subjects' => $builder->paginate($perPage),
            'pager'    => $this->subjectModel->pager,
            'filters'  => $filters,
        ];
    }

    protected function generateSlug(string $name, ?int $ignoreId = null): string
    {
        helper('text');

        $slug     = url_title($name, '-', true);
        $original = $slug;
        $counter  = 1;

        while (true) {
            $builder = $this->subjectModel->where('slug', $slug);

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
        return $this->subjectModel->getNextSortOrder();
    }
}
