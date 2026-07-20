<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubjectModel;
use App\Services\SubjectService;

class SubjectController extends BaseController
{
    protected SubjectService $subjectService;

    public function __construct()
    {
        $this->subjectService = new SubjectService();
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 10);

        $filters = [
            'search'   => trim((string) ($this->request->getGet('search') ?? '')),
            'status'   => $this->request->getGet('status'),
            'per_page' => $perPage,
        ];

        $data = $this->subjectService->paginate($perPage, $filters);

        return view('admin/subjects/index', [
            'title'    => 'Subjects',
            'subjects' => $data['subjects'],
            'pager'    => $data['pager'],
            'filters'  => $data['filters'],
            'perPage'  => $perPage,
        ]);
    }

    public function trash(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 10);

        $filters = [
            'search'   => trim((string) ($this->request->getGet('search') ?? '')),
            'status'   => $this->request->getGet('status'),
            'per_page' => $perPage,
        ];

        $data = $this->subjectService->paginateDeleted($perPage, $filters);

        return view('admin/subjects/trash', [
            'title'    => 'Trashed Subjects',
            'subjects' => $data['subjects'],
            'pager'    => $data['pager'],
            'filters'  => $data['filters'],
            'perPage'  => $perPage,
        ]);
    }

    public function create(): string
    {
        $nextSortOrder = $this->subjectService->getNextSortOrder();

        return view('admin/subjects/create', [
            'title'   => 'Create Subject',
            'subject' => ['sort_order' => $nextSortOrder],
        ]);
    }

    public function store()
    {
        $result = $this->subjectService->create($this->request->getPost(), session()->get('user_id'));

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.subjects.index'))
            ->with('success', $result->getMessage());
    }

    public function edit(int $id): string
    {
        $subjectModel = new \App\Models\SubjectModel();
        $subject = $subjectModel->find($id);

        if (!$subject) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Subject not found.');
        }

        return view('admin/subjects/edit', [
            'title'   => 'Edit Subject',
            'subject' => $subject,
        ]);
    }

    public function update(int $id)
    {
        $result = $this->subjectService->update($id, $this->request->getPost(), session()->get('user_id'));

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.subjects.index'))
            ->with('success', $result->getMessage());
    }

    public function delete(int $id)
    {
        $result = $this->subjectService->delete($id, session()->get('user_id'));

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function restore(int $id)
    {
        $result = $this->subjectService->restore($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function forceDelete(int $id)
    {
        $result = $this->subjectService->forceDelete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }
}
