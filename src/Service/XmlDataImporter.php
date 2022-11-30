<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\StorageAdapterInterface;
use App\Exception\XmlDataImporterException;

class XmlDataImporter
{
    public function __construct(private readonly StorageAdapterInterface $storageAdapter)
    {
    }

    /**
     * @throws XmlDataImporterException
     */
    public function process(string $fileContents): void
    {
        if (empty($fileContents)) {
            throw new XmlDataImporterException('The file contents of the XML file is empty!');
        }

        $xml = simplexml_load_string($fileContents);

        $this->storageAdapter->prepare();

        foreach ($xml as $element) {
            $fields = [];
            $fields['entity_id'] = $element->entity_id;
            $fields['price'] = $element->price;

            $this->storageAdapter->store($fields);
        }

        $this->storageAdapter->finish();
    }
}
