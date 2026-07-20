<?php

namespace App\Services;

use App\Data\QuestionData;
use App\Models\QuestionModel;
use RuntimeException;

class QuestionService extends BaseService
{
    public function __construct(
        protected ?QuestionModel $questionModel = null
    ) {
        parent::__construct();
        $this->questionModel = $questionModel ?? new QuestionModel();
    }

    protected function prepareCreateData(QuestionData $data): array
    {
        return [
            'exam_id'       => $data->examId,
            'question_text' => $data->questionText,
            'question_type' => $data->questionType,
            'marks'         => $data->marks,
            'explanation'   => $data->explanation,
            'status'        => $data->status,
            'created_by'    => auth()->id(),
        ];
    }

    public function create(QuestionData $data): ServiceResult
    {
        return $this->transaction(function () use ($data) {
            $insertData = $this->prepareCreateData($data);

            $id = $this->questionModel->insert($insertData, true);

            if (!$id) {
                return ServiceResult::failure('Failed to create question.', $this->questionModel->errors());
            }

            return ServiceResult::success('Question created successfully.', $this->find($id));
        });
    }

    protected function prepareUpdateData(int $id, QuestionData $data): array
    {
        return [
            'exam_id'       => $data->examId,
            'question_text' => $data->questionText,
            'question_type' => $data->questionType,
            'marks'         => $data->marks,
            'explanation'   => $data->explanation,
            'status'        => $data->status,
            'updated_by'    => auth()->id(),
        ];
    }

    public function update(int $id, QuestionData $data): ServiceResult
    {
        return $this->transaction(function () use ($id, $data) {
            if (!$this->find($id)) {
                throw new RuntimeException('Question not found.');
            }

            $updateData = $this->prepareUpdateData($id, $data);

            if (!$this->questionModel->update($id, $updateData)) {
                return ServiceResult::failure('Failed to update question.', $this->questionModel->errors());
            }

            return ServiceResult::success('Question updated successfully.', $this->find($id));
        });
    }

    public function delete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            if (!$this->find($id)) {
                throw new RuntimeException('Question not found.');
            }

            $this->questionModel->update($id, ['deleted_by' => auth()->id()]);
            $this->questionModel->delete($id);

            return ServiceResult::success('Question moved to trash.');
        });
    }

    public function restore(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $question = $this->questionModel->withDeleted()->find($id);

            if (!$question) {
                throw new RuntimeException('Question not found.');
            }

            $restored = $this->questionModel->withDeleted()->update($id, [
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

            if (!$restored) {
                return ServiceResult::failure('Failed to restore question.');
            }

            return ServiceResult::success('Question restored successfully.');
        });
    }

    public function forceDelete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $question = $this->questionModel->withDeleted()->find($id);

            if (!$question) {
                throw new RuntimeException('Question not found.');
            }

            $this->questionModel->delete($id, true);

            return ServiceResult::success('Question permanently deleted.');
        });
    }

    public function find(int $id): ?array
    {
        return $this->questionModel->getWithRelations()->find($id);
    }

    public function paginate(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->questionModel
            ->getWithRelations()
            ->orderBy('questions.id', 'DESC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('questions.status', (int) $filters['status']);
        }

        if (isset($filters['exam_id']) && $filters['exam_id'] !== '') {
            $builder->where('questions.exam_id', (int) $filters['exam_id']);
        }

        return [
            'questions' => $builder->paginate($perPage),
            'pager'     => $this->questionModel->pager,
            'filters'   => $filters,
        ];
    }

    public function paginateDeleted(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->questionModel
            ->getWithRelations()
            ->onlyDeleted()
            ->orderBy('questions.deleted_at', 'DESC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('questions.status', (int) $filters['status']);
        }

        return [
            'questions' => $builder->paginate($perPage),
            'pager'     => $this->questionModel->pager,
            'filters'   => $filters,
        ];
    }
}
