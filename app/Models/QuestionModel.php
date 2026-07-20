<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table            = 'questions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'exam_id',
        'question_text',
        'question_type',
        'marks',
        'negative_marks',
        'difficulty',
        'explanation',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $deletedField = 'deleted_at';


    public function search(string $keyword): self
    {
        return $this->groupStart()
            ->like('questions.question_text', $keyword)
            ->orLike('questions.explanation', $keyword)
            ->orLike('exams.title', $keyword)
            ->groupEnd();
    }

    public function getWithRelations(): self
    {
        return $this->select('questions.*, exams.title as exam_title')
            ->join('exams', 'exams.id = questions.exam_id', 'left');
    }


    public function getByExam(int $examId): array
    {
        return $this
            ->where('exam_id', $examId)
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function countByExam(int $examId): int
    {
        return $this
            ->where('exam_id', $examId)
            ->countAllResults();
    }


    public function getRandomQuestions(int $examId, int $limit = 20): array
    {
        return $this
            ->where('exam_id', $examId)
            ->where('status', 1)
            ->orderBy('RAND()')
            ->findAll($limit);
    }

    public function getByDifficulty(
        int $examId,
        string $difficulty
    ): array {
        return $this
            ->where('exam_id', $examId)
            ->where('difficulty', $difficulty)
            ->findAll();
    }


    public function getLatestQuestions(int $limit = 10) {}
    public function getActiveQuestionCount() {}
    public function existsInExam(int $examId, int $questionId) {}
}
