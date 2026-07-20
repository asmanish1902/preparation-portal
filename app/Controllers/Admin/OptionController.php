<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Data\OptionData;
use App\Models\QuestionModel;
use App\Services\OptionService;
use App\Validation\OptionsValidation;

class OptionController extends BaseController
{
    protected OptionService $optionService;
    protected QuestionModel $questionModel;

    public function __construct()
    {
        helper('text');
        $this->optionService = new OptionService();
        $this->questionModel = new QuestionModel();
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 10);

        $filters = [
            'search'      => trim((string) ($this->request->getGet('search') ?? '')),
            'status'      => $this->request->getGet('status'),
            'question_id' => $this->request->getGet('question_id'),
            'is_correct'  => $this->request->getGet('is_correct'),
            'per_page'    => $perPage,
        ];

        $data = $this->optionService->paginate($perPage, $filters);

        return view('admin/options/index', [
            'title'     => 'Question Options',
            'options'   => $data['options'],
            'pager'     => $data['pager'],
            'filters'   => $data['filters'],
            'perPage'   => $perPage,
            'questions' => $this->questionModel->where('status', 1)->findAll(),
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

        $data = $this->optionService->paginateDeleted($perPage, $filters);

        return view('admin/options/trash', [
            'title'   => 'Trashed Options',
            'options' => $data['options'],
            'pager'   => $data['pager'],
            'filters' => $data['filters'],
            'perPage' => $perPage,
        ]);
    }

    // Default Creation UI (Batch Mode)
    public function create(): string
    {
        return view('admin/options/create', [
            'title'     => 'Create Options',
            'option'    => null,
            'isSingle'  => false,
            'questions' => $this->questionModel->where('status', 1)->findAll(),
        ]);
    }

    // Quick Single Option Creation UI
    public function createSingle(): string
    {
        return view('admin/options/create_single', [
            'title'     => 'Create Single Option',
            'option'    => null,
            'isSingle'  => true,
            'questions' => $this->questionModel->where('status', 1)->findAll(),
        ]);
    }

    public function store()
    {
        // Detect whether submission is single or batch based on 'mode' hidden field
        $mode = $this->request->getPost('mode') ?? 'batch';

        if ($mode === 'single') {
            if (!$this->validate(OptionsValidation::singleRules())) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors())
                    ->with('error', 'Validation failed. Please review form entries.');
            }

            $dto    = OptionData::fromRequest($this->request->getPost());
            $result = $this->optionService->create($dto);
        } else {
            if (!$this->validate(OptionsValidation::batchRules())) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors())
                    ->with('error', 'Validation failed. Please review option entries.');
            }

            $questionId  = (int) $this->request->getPost('question_id');
            $status      = (int) ($this->request->getPost('status') ?? 1);
            $optionsData = $this->request->getPost('options') ?? [];

            $result = $this->optionService->createBatch($questionId, $optionsData, $status);
        }

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.options.index'))
            ->with('success', $result->getMessage());
    }


    public function editSingle(int $id): string
    {
        $option = $this->optionService->find($id);

        if (!$option) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Option not found.');
        }

        return view('admin/options/edit_single', [
            'title'     => 'Edit Option #' . $option['id'],
            'option'    => $option,
            'questions' => $this->questionModel->where('status', 1)->findAll(),
        ]);
    }

    // public function edit(int $id): string
    // {
    //     $option = $this->optionService->find($id);

    //     if (!$option) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Option not found.');
    //     }

    //     return view('admin/options/edit_single', [
    //         'title'     => 'Edit Option #' . $option['id'],
    //         'option'    => $option,
    //         'questions' => $this->questionModel->where('status', 1)->findAll(),
    //     ]);
    // }

    public function update(int $id)
    {
        if (!$this->validate(OptionsValidation::singleRules())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Validation failed. Please review option entries.');
        }

        $dto    = OptionData::fromRequest($this->request->getPost());
        $result = $this->optionService->update($id, $dto);

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.options.index'))
            ->with('success', $result->getMessage());
    }


    public function editBatch(int $questionId): string
    {
        $question = $this->questionModel->find($questionId);

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Question not found.');
        }

        // 🟢 Fetch options via OptionService
        $options = $this->optionService->getByQuestionId($questionId);

        return view('admin/options/edit_batch', [
            'title'      => 'Manage Options for Question #' . $questionId,
            'question'   => $question,
            'oldOptions' => $options,
            'questions'  => $this->questionModel->where('status', 1)->findAll(),
        ]);
    }

    public function updateBatch(int $questionId)
    {
        $postData = $this->request->getPost();

        if (!$this->validateData($postData, OptionsValidation::batchRules())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Validation failed. Please check option entries.');
        }

        $status      = (int) ($postData['status'] ?? 1);
        $optionsData = $postData['options'] ?? [];

        $result = $this->optionService->updateQuestionOptions($questionId, $optionsData, $status);

        if (!$result->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result->getErrors())
                ->with('error', $result->getMessage());
        }

        return redirect()->to(route_to('admin.options.index'))
            ->with('success', $result->getMessage());
    }

    public function delete(int $id)
    {
        $result = $this->optionService->delete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function restore(int $id)
    {
        $result = $this->optionService->restore($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }

    public function forceDelete(int $id)
    {
        $result = $this->optionService->forceDelete($id);

        return redirect()->back()
            ->with($result->isSuccess() ? 'success' : 'error', $result->getMessage());
    }
}
