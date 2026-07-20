<?php

namespace App\Services;

final readonly class ServiceResult
{
    private function __construct(
        private bool $success,
        private string $message,
        private mixed $data = null,
        private array $errors = [],
    ) {}

    public static function success(
        string $message = '',
        mixed $data = null
    ): self {
        return new self(true, $message, $data);
    }

    public static function failure(
        string $message,
        array $errors = []
    ): self {
        return new self(false, $message, null, $errors);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function isFailure(): bool
    {
        return ! $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
