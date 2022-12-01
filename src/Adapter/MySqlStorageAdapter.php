<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Entity\StoreAbleInterface;

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

    public function store(StoreAbleInterface $entity): void
    {
        // TODO: Implement store() method.
        // $entity->toArray() or use as Doctrine entity class
    }

    public function finish(): void
    {
        // TODO: Implement finish() method.
    }
}
