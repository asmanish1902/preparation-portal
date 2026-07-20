<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table            = 'subjects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'slug',
        'code',
        'description',
        'status',
        'sort_order',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 0;

    public function search(string $keyword): self
    {
        return $this->groupStart()
            ->like('name', $keyword)
            ->orLike('code', $keyword)
            ->orLike('description', $keyword)
            ->groupEnd();
    }


    public function getActiveCategories(): array
    {
        return $this->where('status', self::STATUS_ACTIVE)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }


    public function dropdown(): array
    {
        return $this->select('id, name')
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getNextSortOrder(): int
    {
        $max = $this->selectMax('sort_order')->first();
        return ((int) ($max['sort_order'] ?? 0)) + 1;
    }
}
