<?php

namespace App\Data;

class QuestionData
{
    public function __construct(
        public readonly int $examId,
        public readonly string $questionText,
        public readonly string $questionType = 'single',
        public readonly int $marks = 1,
        public readonly ?string $explanation = null,
        public readonly int $status = 1,
        public readonly ?int $createdBy = null,
        public readonly ?int $updatedBy = null
    ) {}

    public static function fromRequest(array $data, ?int $userId = null): self
    {
        return new self(
            examId: (int) ($data['exam_id'] ?? 0),
            questionText: trim((string) ($data['question_text'] ?? ($data['question'] ?? ''))),
            questionType: !empty($data['question_type']) ? trim((string) $data['question_type']) : 'single',
            marks: isset($data['marks']) && $data['marks'] !== '' ? (int) $data['marks'] : 1,
            explanation: !empty($data['explanation']) ? trim((string) $data['explanation']) : null,
            status: isset($data['status']) && $data['status'] !== '' ? (int) $data['status'] : 1,
            createdBy: $userId,
            updatedBy: $userId
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'exam_id'       => $this->examId,
            'question_text' => $this->questionText,
            'question_type' => $this->questionType,
            'marks'         => $this->marks,
            'explanation'   => $this->explanation,
            'status'        => $this->status,
            'created_by'    => $this->createdBy,
            'updated_by'    => $this->updatedBy,
        ], fn($val) => $val !== null);
    }
}
