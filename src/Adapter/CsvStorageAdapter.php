<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Entity\StoreAbleInterface;
use App\Exception\CsvStorageAdapterException;

class CsvStorageAdapter implements StorageAdapterInterface
{
    /** @var resource|null */
    private $fp;

    private string $separator = ',';

    private string $enclosure = '"';

    private string $escape = '\\';

    private string $eol = "\n";

    private string $filename = 'output.csv';

    public function supports(string $type): bool
    {
        return 'csv' === $type;
    }

    /**
     * @throws CsvStorageAdapterException
     */
    public function prepare(): void
    {
        $this->fp = fopen($this->filename, 'w');

        if (!$this->fp) {
            throw new CsvStorageAdapterException('Opening CSV file error!');
        }
    }

    /**
     * @throws CsvStorageAdapterException
     */
    public function store(StoreAbleInterface $entity): void
    {
        if (!fputcsv($this->fp, $entity->toArray(), $this->separator, $this->enclosure, $this->escape, $this->eol)) {
            throw new CsvStorageAdapterException('Writing CSV file error!');
        }
    }

    /**
     * @throws CsvStorageAdapterException
     */
    public function finish(): void
    {
        if (!fclose($this->fp)) {
            throw new CsvStorageAdapterException('Closing CSV file error!');
        }
    }

    public function setFilename(string $filename)
    {
        $this->filename = $filename;
    }

    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    public function setEnclosure(string $enclosure): void
    {
        $this->enclosure = $enclosure;
    }

    public function setEscape(string $escape): void
    {
        $this->escape = $escape;
    }

    public function setEol(string $eol): void
    {
        $this->eol = $eol;
    }
}
