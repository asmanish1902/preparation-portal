<?php

namespace App\Data;

class SubjectData
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $code = null,
        public readonly ?string $description = null,
        public readonly int $status = 1,
        public readonly int $sortOrder = 0,
        public readonly ?int $createdBy = null,
        public readonly ?int $updatedBy = null
    ) {}

    public static function fromRequest(array $data, ?int $userId = null): self
    {
        return new self(
            name: trim((string) ($data['name'] ?? '')),
            slug: url_title(trim((string) ($data['name'] ?? '')), '-', true),
            code: isset($data['code']) ? strtoupper(trim((string) $data['code'])) : null,
            description: isset($data['description']) ? trim((string) $data['description']) : null,
            status: isset($data['status']) ? (int) $data['status'] : 1,
            sortOrder: (int) ($data['sort_order'] ?? 0),
            createdBy: $userId,
            updatedBy: $userId
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name'        => $this->name,
            'slug'        => $this->slug,
            'code'        => $this->code,
            'description' => $this->description,
            'status'      => $this->status,
            'sort_order'  => $this->sortOrder,
            'created_by'  => $this->createdBy,
            'updated_by'  => $this->updatedBy,
        ], fn($val) => $val !== null);
    }
}
