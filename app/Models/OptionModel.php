<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table            = 'options';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'question_id',
        'option_text',
        'is_correct',
        'explanation',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Search filter for admin grid
     */
    public function search(string $keyword): self
    {
        return $this->groupStart()
            ->like('options.option_text', $keyword)
            ->orLike('options.explanation', $keyword)
            ->orLike('questions.question_text', $keyword)
            ->groupEnd();
    }

    /**
     * Join with questions table for admin listing
     */
    public function getWithRelations(): self
    {
        return $this->select('options.*, questions.question_text, questions.question_type')
            ->join('questions', 'questions.id = options.question_id', 'left');
    }

    /**
     * Get all active options for a specific question
     */
    public function getByQuestion(int $questionId): array
    {
        return $this->where('question_id', $questionId)
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Batch fetch options for multiple questions
     */
    public function getByQuestionIds(array $questionIds): array
    {
        if (empty($questionIds)) {
            return [];
        }

        return $this->whereIn('question_id', $questionIds)
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Get single correct option for a question
     */
    public function getCorrectOption(int $questionId): ?array
    {
        return $this->where('question_id', $questionId)
            ->where('is_correct', 1)
            ->where('status', 1)
            ->first();
    }

    /**
     * Check if a given option is marked as correct
     */
    public function isCorrectOption(int $optionId): bool
    {
        return $this->where('id', $optionId)
            ->where('is_correct', 1)
            ->where('status', 1)
            ->countAllResults() > 0;
    }

    /**
     * Count options attached to a question
     */
    public function countByQuestion(int $questionId): int
    {
        return $this->where('question_id', $questionId)->countAllResults();
    }

    /**
     * Get all incorrect options for a question
     */
    public function getIncorrectOptions(int $questionId): array
    {
        return $this->where('question_id', $questionId)
            ->where('is_correct', 0)
            ->where('status', 1)
            ->findAll();
    }

    /**
     * Check if a question has at least one correct option assigned
     */
    public function hasCorrectOption(int $questionId): bool
    {
        return $this->where('question_id', $questionId)
            ->where('is_correct', 1)
            ->where('status', 1)
            ->countAllResults() > 0;
    }

    /**
     * Fetch options formatted for student exam attempt (excluding correct answer metadata)
     */
    public function getStudentOptions(array $questionIds): array
    {
        if (empty($questionIds)) {
            return [];
        }

        return $this->select('id, question_id, option_text')
            ->whereIn('question_id', $questionIds)
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}
