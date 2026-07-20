<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Data\CategoryData;
use App\Models\CategoryModel;
use App\Services\CategoryService;
use App\Validation\CategoryValidation;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class CategoryController extends BaseController
{
    protected CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService(new CategoryModel());
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 10);

        $filters = [
            'search'   => trim((string) ($this->request->getGet('search') ?? '')),
            'status'   => $this->request->getGet('status'),
            'per_page' => $perPage,
        ];

        $data = $this->categoryService->paginate($perPage, $filters);

        return view('admin/categories/index', [
            'title'      => 'Categories',
            'categories' => $data['categories'],
            'pager'      => $data['pager'],
            'filters'    => $data['filters'],
            'perPage'    => $perPage,
        ]);
    }

    public function create(): string
    {

        $nextSortOrder = $this->categoryService->getNextSortOrder();

        return view('admin/categories/create', [
            'title' => 'Create Category',
            'category' => ['sort_order' => $nextSortOrder],
        ]);
    }

    public function store(): ResponseInterface
    {
        if (!$this->validate(CategoryValidation::create(), CategoryValidation::messages())) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dto    = CategoryData::fromRequest($this->request);
        $result = $this->categoryService->create($dto);

        if ($result->isFailure()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $result->getMessage());
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', $result->getMessage());
    }

    public function edit(int $id): string
    {
        $category = $this->categoryService->find($id);

        if (!$category) {
            throw PageNotFoundException::forPageNotFound('Category not found.');
        }

        return view('admin/categories/edit', [
            'title'    => 'Edit Category',
            'category' => $category,
        ]);
    }

    public function update(int $id): ResponseInterface
    {
        if (!$this->validate(CategoryValidation::update($id), CategoryValidation::messages())) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dto    = CategoryData::fromRequest($this->request);
        $result = $this->categoryService->update($id, $dto);

        if ($result->isFailure()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $result->getMessage());
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', $result->getMessage());
    }

    public function delete(int $id): ResponseInterface
    {
        $result = $this->categoryService->delete($id);

        if ($result->isFailure()) {
            return redirect()
                ->back()
                ->with('error', $result->getMessage());
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', $result->getMessage());
    }

    public function trash(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);
        $filters = [
            'search' => trim((string) ($this->request->getGet('search') ?? '')),
            'status' => $this->request->getGet('status'),
            'per_page' => $perPage,
        ];

        $data = $this->categoryService->paginateDeleted($perPage, $filters);

        return view('admin/categories/trash', [
            'title'      => 'Trashed Categories',
            'categories' => $data['categories'],
            'pager'      => $data['pager'],
            'search'     => $filters['search'],
            'filters'    => $data['filters'],
            'perPage'    => $perPage,
        ]);
    }

    public function restore(int $id): ResponseInterface
    {
        $result = $this->categoryService->restore($id);

        if ($result->isFailure()) {
            return redirect()
                ->back()
                ->with('error', $result->getMessage());
        }

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', $result->getMessage());
    }

    public function forceDelete(int $id): ResponseInterface
    {
        $result = $this->categoryService->forceDelete($id);

        if ($result->isFailure()) {
            return redirect()
                ->back()
                ->with('error', $result->getMessage());
        }

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', $result->getMessage());
    }
}
