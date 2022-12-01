<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\StorageAdapterInterface;
use App\Exception\DataImporterContextException;
use App\Exception\XmlDataImporterException;

class DataImporterContext
{
    public function __construct(private readonly \Traversable $storageAdapters)
    {
    }

    /**
     * @throws DataImporterContextException|XmlDataImporterException
     */
    public function handle(string $filename, string $type): void
    {
        /** @var StorageAdapterInterface $storageAdapter */
        foreach ($this->storageAdapters as $storageAdapter) {
            if ($storageAdapter->supports($type)) {
                (new XmlDataImporter($storageAdapter))->process($filename);

                return;
            }
        }

        throw new DataImporterContextException('Invalid storage adapter!');
    }
}
