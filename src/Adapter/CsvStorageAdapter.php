<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Exception\CsvStorageAdapterException;

class CsvStorageAdapter implements StorageAdapterInterface
{
    /** @var resource|null */
    private $fp;

    public function supports(string $type): bool
    {
        return 'csv' === $type;
    }

    /**
     * @throws CsvStorageAdapterException
     */
    public function prepare(): void
    {
        $this->fp = fopen('file.csv', 'w');

        if (!$this->fp)
        {
            throw new CsvStorageAdapterException('Opening CSV file error!');
        }
    }

    /**
     * @throws CsvStorageAdapterException
     */
    public function store(array $fields): void
    {
        if (!fputcsv($this->fp, $fields))
        {
           throw new CsvStorageAdapterException('Writing CSV file error!');
        }
    }

    /**
     * @throws CsvStorageAdapterException
     */
    public function finish(): void
    {
        if (!fclose($this->fp))
        {
            throw new CsvStorageAdapterException('Closing CSV file error!');
        }
    }
}