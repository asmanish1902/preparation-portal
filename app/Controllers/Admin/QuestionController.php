<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Data\QuestionData;
use App\Models\ExamModel;
use App\Services\QuestionService;

class QuestionController extends BaseController
{
    protected QuestionService $questionService;
    protected ExamModel $examModel;

    public function __construct()
    {
        $this->questionService = new QuestionService();
        $this->examModel       = new ExamModel();
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 10);

        $filters = [
            'search'   => trim((string) ($this->request->getGet('search') ?? '')),
            'status'   => $this->request->getGet('status'),
            'exam_id'  => $this->request->getGet('exam_id'),
            'per_page' => $perPage,
        ];

        $data = $this->questionService->paginate($perPage, $filters);

        return view('admin/questions/index', [
            'title'     => 'Question Bank',
            'questions' => $data['questions'],
            'pager'     => $data['pager'],
            'filters'   => $data['filters'],
            'perPage'   => $perPage,
            'exams'     => $this->examModel->where('status', 1)->findAll(),
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

        $data = $this->questionService->paginateDeleted($perPage, $filters);

        return view('admin/questions/trash', [
            'title'     => 'Trashed Questions',
            'questions' => $data['questions'],
            'pager'     => $data['pager'],
            'filters'   => $data['filters'],
            'perPage'   => $perPage,
        ]);
    }

    public function create(): string
    {
        return view('admin/questions/create', [
            'title'    => 'Create Question',
            'question' => null,
            'exams'    => $this->examModel->where('status', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $dto    = QuestionData::fromRequest($this->request->getPost());
        $result = $this->questionService->create($dto);

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.questions.index'))
            ->with('success', $result->getMessage());
    }

    public function edit(int $id): string
    {
        $question = $this->questionService->find($id);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Question not found.');
        }

        return view('admin/questions/edit', [
            'title'    => 'Edit Question',
            'question' => $question,
            'exams'    => $this->examModel->where('status', 1)->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $dto    = QuestionData::fromRequest($this->request->getPost());
        $result = $this->questionService->update($id, $dto);

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.questions.index'))
            ->with('success', $result->getMessage());
    }

    public function delete(int $id)
    {
        $result = $this->questionService->delete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function restore(int $id)
    {
        $result = $this->questionService->restore($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function forceDelete(int $id)
    {
        $result = $this->questionService->forceDelete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }
}
