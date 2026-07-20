<?php

namespace App\Data;

class OptionData
{
    public function __construct(
        public readonly int $questionId,
        public readonly string $optionText,
        public readonly int $isCorrect = 0,
        public readonly ?string $explanation = null,
        public readonly int $status = 1,
        public readonly ?int $createdBy = null,
        public readonly ?int $updatedBy = null
    ) {}

    public static function fromRequest(array $data, ?int $userId = null): self
    {
        return new self(
            questionId: (int) ($data['question_id'] ?? 0),
            optionText: trim((string) ($data['option_text'] ?? '')),
            isCorrect: isset($data['is_correct']) && $data['is_correct'] !== '' ? (int) $data['is_correct'] : 0,
            explanation: !empty($data['explanation']) ? trim((string) $data['explanation']) : null,
            status: isset($data['status']) && $data['status'] !== '' ? (int) $data['status'] : 1,
            createdBy: $userId,
            updatedBy: $userId
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'question_id' => $this->questionId,
            'option_text' => $this->optionText,
            'is_correct'  => $this->isCorrect,
            'explanation' => $this->explanation,
            'status'      => $this->status,
            'created_by'  => $this->createdBy,
            'updated_by'  => $this->updatedBy,
        ], fn($val) => $val !== null);
    }
}
