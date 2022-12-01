<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Entity\StoreAbleInterface;

interface StorageAdapterInterface
{
    public function supports(string $type): bool;

    public function prepare(): void;

    public function store(StoreAbleInterface $entity): void;

    public function finish(): void;
}
