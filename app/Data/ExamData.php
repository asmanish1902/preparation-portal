<?php

namespace App\Data;

class ExamData
{
    public function __construct(
        public readonly int $categoryId,
        public readonly int $subjectId,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly int $durationMinutes = 60,
        public readonly int $passMark = 50,
        public readonly int $totalMarks = 100,
        public readonly int $status = 1,
        public readonly ?int $createdBy = null,
        public readonly ?int $updatedBy = null
    ) {}

    public static function fromRequest(array $data, ?int $userId = null): self
    {
        return new self(
            categoryId: (int) ($data['category_id'] ?? 0),
            subjectId: (int) ($data['subject_id'] ?? 0),
            title: trim((string) ($data['title'] ?? '')),
            description: !empty($data['description']) ? trim((string) $data['description']) : null,
            durationMinutes: isset($data['duration_minutes']) && $data['duration_minutes'] !== '' ? (int) $data['duration_minutes'] : 60,
            passMark: isset($data['pass_mark']) && $data['pass_mark'] !== '' ? (int) $data['pass_mark'] : 50,
            totalMarks: isset($data['total_marks']) && $data['total_marks'] !== '' ? (int) $data['total_marks'] : 100,
            status: isset($data['status']) && $data['status'] !== '' ? (int) $data['status'] : 1,
            createdBy: $userId,
            updatedBy: $userId
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'category_id'      => $this->categoryId,
            'subject_id'       => $this->subjectId,
            'title'            => $this->title,
            'description'      => $this->description,
            'duration_minutes' => $this->durationMinutes,
            'pass_mark'        => $this->passMark,
            'total_marks'      => $this->totalMarks,
            'status'           => $this->status,
            'created_by'       => $this->createdBy,
            'updated_by'       => $this->updatedBy,
        ], fn($val) => $val !== null);
    }
}
