<?php

declare(strict_types=1);

namespace App\Adapter;

class MySqlStorageAdapter implements StorageAdapterInterface
{
    public function supports(string $type): bool
    {
        return false; // return 'mysql' === $type;
    }

    public function prepare(): void
    {
        // TODO: Implement prepare() method.
    }

    public function store(array $fields): void
    {
        // TODO: Implement store() method.
    }

    public function finish(): void
    {
        // TODO: Implement finish() method.
    }
}
