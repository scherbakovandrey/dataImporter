<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\StorageAdapterInterface;
use App\Exception\DataImporterContextException;

class DataImporterContext
{
    public function __construct(private readonly \Traversable $storageAdapters)
    {
    }

    /**
     * @throws DataImporterContextException
     */
    public function handle(string $fileContents, string $type): void
    {
        /** @var StorageAdapterInterface $storageAdapter */
        foreach ($this->storageAdapters as $storageAdapter) {
            if ($storageAdapter->supports($type)) {
                (new XmlDataImporter($storageAdapter))->process($fileContents);

                return;
            }
        }

        throw new DataImporterContextException('Invalid storage adapter');
    }
}
