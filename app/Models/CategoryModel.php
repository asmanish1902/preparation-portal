<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'slug',
        'description',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Type casting for robust data handling
    protected array $casts = [
        'id'         => 'int',
        'sort_order' => 'int',
        'status'     => 'int',
        'created_by' => '?int',
        'updated_by' => '?int',
        'deleted_by' => '?int',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 0;

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

    public function search(string $keyword): self
    {
        return $this->groupStart()
            ->like('name', $keyword)
            ->orLike('description', $keyword)
            ->groupEnd();
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
