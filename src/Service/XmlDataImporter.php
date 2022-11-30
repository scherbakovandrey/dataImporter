<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\StorageAdapterInterface;

class XmlDataImporter
{
    public function __construct(private StorageAdapterInterface $storageAdapter)
    {
    }

    public function process(string $fileContents): void
    {
        $xml = simplexml_load_string($fileContents);

        $this->storageAdapter->prepare();

        foreach ($xml as $element)
        {
            $fields = [];
            $fields['entity_id'] = $element->entity_id;
            $fields['price'] = $element->price;

            $this->storageAdapter->store($fields);
        }

        $this->storageAdapter->finish();
    }
}