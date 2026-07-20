<?php

namespace App\Data;

use CodeIgniter\HTTP\IncomingRequest;

final readonly class CategoryData
{
    public function __construct(
        public string $name,
        public string $description,
        public int $status,
        public int $sortOrder,
    ) {}

    public static function fromRequest(IncomingRequest $request): self
    {
        return self::fromArray((array) $request->getPost());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: trim((string) ($data['name'] ?? '')),
            description: trim((string) ($data['description'] ?? '')),
            status: isset($data['status']) ? (int) $data['status'] : 1,
            sortOrder: isset($data['sort_order']) ? (int) $data['sort_order'] : 0,
        );
    }

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'status'      => $this->status,
            'sort_order'  => $this->sortOrder,
        ];
    }

    public function isActive(): bool
    {
        return $this->status === 1;
    }
}
