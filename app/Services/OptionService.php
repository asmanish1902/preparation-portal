<?php

namespace App\Services;

use App\Data\OptionData;
use App\Models\OptionModel;
use RuntimeException;

class OptionService extends BaseService
{
    public function __construct(
        protected ?OptionModel $optionModel = null
    ) {
        parent::__construct();
        $this->optionModel = $optionModel ?? new OptionModel();
    }

    /* -----------------------------------------------------------------
     * SINGLE OPTION OPERATIONS
     * ----------------------------------------------------------------- */

    public function create(OptionData $data): ServiceResult
    {
        return $this->transaction(function () use ($data) {
            $insertData = [
                'question_id' => $data->questionId,
                'option_text' => $data->optionText,
                'is_correct'  => $data->isCorrect,
                'explanation' => $data->explanation,
                'status'      => $data->status,
                'created_by'  => auth()->id(),
            ];

            $id = $this->optionModel->insert($insertData, true);

            if (!$id) {
                return ServiceResult::failure('Failed to create option.', $this->optionModel->errors());
            }

            return ServiceResult::success('Option created successfully.', $this->find($id));
        });
    }

    public function update(int $id, OptionData $data): ServiceResult
    {
        return $this->transaction(function () use ($id, $data) {
            if (!$this->find($id)) {
                throw new RuntimeException('Option not found.');
            }

            $updateData = [
                'question_id' => $data->questionId,
                'option_text' => $data->optionText,
                'is_correct'  => $data->isCorrect,
                'explanation' => $data->explanation,
                'status'      => $data->status,
                'updated_by'  => auth()->id(),
            ];

            if (!$this->optionModel->update($id, $updateData)) {
                return ServiceResult::failure('Failed to update option.', $this->optionModel->errors());
            }

            return ServiceResult::success('Option updated successfully.', $this->find($id));
        });
    }

    /* -----------------------------------------------------------------
     * BATCH OPTION OPERATIONS
     * ----------------------------------------------------------------- */

    public function createBatch(int $questionId, array $optionsData, int $status = 1): ServiceResult
    {
        return $this->transaction(function () use ($questionId, $optionsData, $status) {
            $userId = auth()->id();
            $batch  = [];

            foreach ($optionsData as $row) {
                if (empty(trim($row['option_text'] ?? ''))) {
                    continue;
                }

                $batch[] = [
                    'question_id' => $questionId,
                    'option_text' => trim($row['option_text']),
                    'is_correct'  => isset($row['is_correct']) ? (int) $row['is_correct'] : 0,
                    'explanation' => !empty($row['explanation']) ? trim($row['explanation']) : null,
                    'status'      => $status,
                    'created_by'  => $userId,
                    'updated_by'  => $userId,
                ];
            }

            if (empty($batch)) {
                return ServiceResult::failure('No valid options provided to save.');
            }

            $inserted = $this->optionModel->insertBatch($batch);

            if (!$inserted) {
                return ServiceResult::failure('Failed to insert options.', $this->optionModel->errors());
            }

            return ServiceResult::success(count($batch) . ' options created successfully.');
        });
    }

    /**
     * Synchronize and update all options for a specific question
     */
    /**
     * Synchronize and update all options for a specific question
     */
    public function updateQuestionOptions(int $questionId, array $optionsData, int $status = 1): ServiceResult
    {
        return $this->transaction(function () use ($questionId, $optionsData, $status) {
            $userId       = auth()->id();
            $submittedIds = [];

            foreach ($optionsData as $row) {
                $optionText = trim($row['option_text'] ?? '');

                // Skip completely empty inputs
                if ($optionText === '') {
                    continue;
                }

                $optionId = !empty($row['id']) ? (int) $row['id'] : null;

                $data = [
                    'question_id' => $questionId,
                    'option_text' => $optionText,
                    'is_correct'  => isset($row['is_correct']) ? (int) $row['is_correct'] : 0,
                    'explanation' => !empty($row['explanation']) ? trim($row['explanation']) : null,
                    'status'      => $status,
                    'updated_by'  => $userId,
                ];

                if ($optionId && $this->optionModel->find($optionId)) {
                    // Update existing record
                    $this->optionModel->update($optionId, $data);
                    $submittedIds[] = $optionId;
                } else {
                    // Insert newly added row
                    $data['created_by'] = $userId;
                    $newId = $this->optionModel->insert($data, true);
                    if ($newId) {
                        $submittedIds[] = (int) $newId;
                    }
                }
            }

            // 🟢 FIX: Fetch current active options for this question
            $existingOptions = $this->optionModel
                ->where('question_id', $questionId)
                ->where('deleted_at', null)
                ->findAll();

            foreach ($existingOptions as $existing) {
                $existingId = (int) $existing['id'];

                // Soft-delete only if the ID was present previously but removed in this submission
                if (!in_array($existingId, $submittedIds, true)) {
                    $this->optionModel->update($existingId, ['deleted_by' => $userId]);
                    $this->optionModel->delete($existingId);
                }
            }

            return ServiceResult::success('Question options synchronized successfully.');
        });
    }

    /* -----------------------------------------------------------------
     * COMMON FIND & DELETE OPERATIONS
     * ----------------------------------------------------------------- */

    public function delete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            if (!$this->find($id)) {
                throw new RuntimeException('Option not found.');
            }

            $this->optionModel->update($id, ['deleted_by' => auth()->id()]);
            $this->optionModel->delete($id);

            return ServiceResult::success('Option moved to trash.');
        });
    }

    public function restore(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $option = $this->optionModel->withDeleted()->find($id);

            if (!$option) {
                throw new RuntimeException('Option not found.');
            }

            $restored = $this->optionModel->withDeleted()->update($id, [
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

            if (!$restored) {
                return ServiceResult::failure('Failed to restore option.');
            }

            return ServiceResult::success('Option restored successfully.');
        });
    }

    public function forceDelete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $option = $this->optionModel->withDeleted()->find($id);

            if (!$option) {
                throw new RuntimeException('Option not found.');
            }

            $this->optionModel->delete($id, true);

            return ServiceResult::success('Option permanently deleted.');
        });
    }

    public function find(int $id): ?array
    {
        return $this->optionModel->getWithRelations()->find($id);
    }

    public function paginate(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->optionModel
            ->getWithRelations()
            ->orderBy('options.id', 'DESC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('options.status', (int) $filters['status']);
        }

        if (isset($filters['question_id']) && $filters['question_id'] !== '') {
            $builder->where('options.question_id', (int) $filters['question_id']);
        }

        if (isset($filters['is_correct']) && $filters['is_correct'] !== '') {
            $builder->where('options.is_correct', (int) $filters['is_correct']);
        }

        return [
            'options' => $builder->paginate($perPage),
            'pager'   => $this->optionModel->pager,
            'filters' => $filters,
        ];
    }

    public function paginateDeleted(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->optionModel
            ->getWithRelations()
            ->onlyDeleted()
            ->orderBy('options.deleted_at', 'DESC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('options.status', (int) $filters['status']);
        }

        return [
            'options' => $builder->paginate($perPage),
            'pager'   => $this->optionModel->pager,
            'filters' => $filters,
        ];
    }


    public function getByQuestionId(int $questionId): array
    {
        return $this->optionModel
            ->where('question_id', $questionId)
            ->where('status', 1)
            ->findAll();
    }
}
