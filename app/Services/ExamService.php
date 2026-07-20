<?php

namespace App\Services;

use App\Data\ExamData;
use App\Models\ExamModel;
use RuntimeException;

class ExamService extends BaseService
{
    public function __construct(protected ?ExamModel $examModel = null)
    {
        parent::__construct();
        $this->examModel = $examModel ?? new ExamModel();
    }

    protected function prepareCreateData(ExamData $data): array
    {
        return [
            'category_id'      => $data->categoryId,
            'subject_id'       => $data->subjectId,
            'title'            => $data->title,
            'slug'             => $this->generateSlug($data->title),
            'description'      => $data->description,
            'duration_minutes' => $data->durationMinutes,
            'pass_mark'        => $data->passMark,
            'total_marks'      => $data->totalMarks,
            'status'           => $data->status,
            'created_by'       => auth()->id(),
        ];
    }

    public function create(ExamData $data): ServiceResult
    {
        return $this->transaction(function () use ($data) {
            $insertData = $this->prepareCreateData($data);

            $id = $this->examModel->insert($insertData, true);

            if (!$id) {
                return ServiceResult::failure('Failed to create exam.', $this->examModel->errors());
            }

            return ServiceResult::success('Exam created successfully.', $this->find($id));
        });
    }

    protected function prepareUpdateData(int $id, ExamData $data): array
    {
        return [
            'category_id'      => $data->categoryId,
            'subject_id'       => $data->subjectId,
            'title'            => $data->title,
            'slug'             => $this->generateSlug($data->title, $id),
            'description'      => $data->description,
            'duration_minutes' => $data->durationMinutes,
            'pass_mark'        => $data->passMark,
            'total_marks'      => $data->totalMarks,
            'status'           => $data->status,
            'updated_by'       => auth()->id(),
        ];
    }

    public function update(int $id, ExamData $data): ServiceResult
    {
        return $this->transaction(function () use ($id, $data) {
            if (!$this->find($id)) {
                throw new RuntimeException('Exam not found.');
            }

            $updateData = $this->prepareUpdateData($id, $data);

            if (!$this->examModel->update($id, $updateData)) {
                return ServiceResult::failure('Failed to update exam.', $this->examModel->errors());
            }

            return ServiceResult::success('Exam updated successfully.', $this->find($id));
        });
    }

    public function delete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            if (!$this->find($id)) {
                throw new RuntimeException('Exam not found.');
            }

            $this->examModel->update($id, ['deleted_by' => auth()->id()]);
            $this->examModel->delete($id);

            return ServiceResult::success('Exam moved to trash.');
        });
    }

    public function restore(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $exam = $this->examModel->withDeleted()->find($id);

            if (!$exam) {
                throw new RuntimeException('Exam not found.');
            }

            $restored = $this->examModel->withDeleted()->update($id, [
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

            if (!$restored) {
                return ServiceResult::failure('Failed to restore exam.');
            }

            return ServiceResult::success('Exam restored successfully.');
        });
    }

    public function forceDelete(int $id): ServiceResult
    {
        return $this->transaction(function () use ($id) {
            $exam = $this->examModel->withDeleted()->find($id);

            if (!$exam) {
                throw new RuntimeException('Exam not found.');
            }

            $this->examModel->delete($id, true);

            return ServiceResult::success('Exam permanently deleted.');
        });
    }

    public function find(int $id): ?array
    {
        return $this->examModel->getWithRelations()->find($id);
    }

    public function paginate(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->examModel
            ->getWithRelations()
            ->orderBy('exams.id', 'DESC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('exams.status', (int) $filters['status']);
        }

        if (isset($filters['category_id']) && $filters['category_id'] !== '') {
            $builder->where('exams.category_id', (int) $filters['category_id']);
        }

        if (isset($filters['subject_id']) && $filters['subject_id'] !== '') {
            $builder->where('exams.subject_id', (int) $filters['subject_id']);
        }

        return [
            'exams'   => $builder->paginate($perPage),
            'pager'   => $this->examModel->pager,
            'filters' => $filters,
        ];
    }

    public function paginateDeleted(int $perPage = 10, array $filters = []): array
    {
        $builder = $this->examModel
            ->getWithRelations()
            ->onlyDeleted()
            ->orderBy('exams.deleted_at', 'DESC');

        if (!empty($filters['search'])) {
            $builder->search($filters['search']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('exams.status', (int) $filters['status']);
        }

        return [
            'exams'   => $builder->paginate($perPage),
            'pager'   => $this->examModel->pager,
            'filters' => $filters,
        ];
    }

    protected function generateSlug(string $title, ?int $ignoreId = null): string
    {
        helper('text');

        $slug     = url_title($title, '-', true);
        $original = $slug;
        $counter  = 1;

        while (true) {
            $builder = $this->examModel->where('slug', $slug);

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
}
