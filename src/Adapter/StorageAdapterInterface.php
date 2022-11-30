<?php

declare(strict_types=1);

namespace App\Adapter;

interface StorageAdapterInterface
{
    public function supports(string $type): bool;

    public function prepare(): void;

    public function store(array $fields): void; // maybe Entity???

    public function finish(): void;
}