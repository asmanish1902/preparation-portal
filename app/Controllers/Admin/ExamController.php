<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Data\ExamData;
use App\Models\CategoryModel;
use App\Models\SubjectModel;
use App\Services\ExamService;

class ExamController extends BaseController
{
    protected ExamService $examService;
    protected CategoryModel $categoryModel;
    protected SubjectModel $subjectModel;

    public function __construct()
    {
        $this->examService   = new ExamService();
        $this->categoryModel = new CategoryModel();
        $this->subjectModel  = new SubjectModel();
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 10);

        $filters = [
            'search'      => trim((string) ($this->request->getGet('search') ?? '')),
            'status'      => $this->request->getGet('status'),
            'category_id' => $this->request->getGet('category_id'),
            'subject_id'  => $this->request->getGet('subject_id'),
            'per_page'    => $perPage,
        ];

        $data = $this->examService->paginate($perPage, $filters);

        return view('admin/exams/index', [
            'title'      => 'Exams',
            'exams'      => $data['exams'],
            'pager'      => $data['pager'],
            'filters'    => $data['filters'],
            'perPage'    => $perPage,
            'categories' => $this->categoryModel->findAll(),
            'subjects'   => $this->subjectModel->findAll(),
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

        $data = $this->examService->paginateDeleted($perPage, $filters);

        return view('admin/exams/trash', [
            'title'   => 'Trashed Exams',
            'exams'   => $data['exams'],
            'pager'   => $data['pager'],
            'filters' => $data['filters'],
            'perPage' => $perPage,
        ]);
    }

    public function create(): string
    {
        return view('admin/exams/create', [
            'title'      => 'Create Exam',
            'exam'       => null,
            'categories' => $this->categoryModel->where('status', 1)->findAll(),
            'subjects'   => $this->subjectModel->where('status', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $dto    = ExamData::fromRequest($this->request->getPost());
        $result = $this->examService->create($dto);

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.exams.index'))
            ->with('success', $result->getMessage());
    }

    public function edit(int $id): string
    {
        $exam = $this->examService->find($id);

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Exam not found.');
        }

        return view('admin/exams/edit', [
            'title'      => 'Edit Exam',
            'exam'       => $exam,
            'categories' => $this->categoryModel->where('status', 1)->findAll(),
            'subjects'   => $this->subjectModel->where('status', 1)->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $dto    = ExamData::fromRequest($this->request->getPost());
        $result = $this->examService->update($id, $dto);

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.exams.index'))
            ->with('success', $result->getMessage());
    }

    public function delete(int $id)
    {
        $result = $this->examService->delete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function restore(int $id)
    {
        $result = $this->examService->restore($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function forceDelete(int $id)
    {
        $result = $this->examService->forceDelete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }
}
