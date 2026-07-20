<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamModel extends Model
{
    protected $table            = 'exams';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'subject_id',
        'title',
        'slug',
        'description',
        'duration_minutes',
        'pass_mark',
        'total_marks',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // protected array $casts = [
    //     'id'               => 'int',
    //     'category_id'      => 'int',
    //     'subject_id'       => 'int',
    //     'duration_minutes' => 'int',
    //     'pass_mark'        => 'int',
    //     'total_marks'      => 'int',
    //     'status'           => 'int',
    //     'created_by'       => '?int',
    //     'updated_by'       => '?int',
    //     'deleted_by'       => '?int',
    // ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function search(string $keyword): self
    {
        return $this->groupStart()
            ->like('exams.title', $keyword)
            ->orLike('exams.description', $keyword)
            ->orLike('categories.name', $keyword)
            ->orLike('subjects.name', $keyword)
            ->groupEnd();
    }

    public function getWithRelations(): self
    {
        return $this->select('exams.*, categories.name as category_name, subjects.name as subject_name')
            ->join('categories', 'categories.id = exams.category_id', 'left')
            ->join('subjects', 'subjects.id = exams.subject_id', 'left');
    }


    public function getActiveExams(): array
    {
        return $this->where('status', 1)
            ->findAll();
    }


    protected function withCategory()
    {
        return $this
            ->select('
            exams.*,
            categories.name category_name
        ')
            ->join(
                'categories',
                'categories.id=exams.category_id'
            );
    }


    public function getExamsWithCategory()
    {
        return $this
            ->withCategory()
            ->findAll();
    }


    public function getExam($id)
    {
        return $this
            ->withCategory()
            ->find($id);
    }

    public function getExamQuestionCount()
    {
        return $this->select('exams.*, COUNT(questions.id) AS total_questions')
            ->join(
                'questions',
                'questions.exam_id=exams.id',
                'left'
            )
            ->groupBy('exams.id')
            ->findAll();
    }

    public function getByCategory($categoryId)
    {
        return $this
            ->where('category_id', $categoryId)
            ->where('status', 1)
            ->findAll();
    }


    public function getLatestExams($limit = 5) {}

    public function getUpcomingExamCount() {}

    public function getExamBySlug(string $slug) {}
}
