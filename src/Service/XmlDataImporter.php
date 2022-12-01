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
    public function process(string $filename): void
    {
        if (empty($filename)) {
            throw new XmlDataImporterException('Filename is empty!');
        }

        try {
            $xml = \XMLReader::open($filename);
        } catch (\Exception $e) {
            throw new XmlDataImporterException('Cannot open XML file!');
        }

        $this->storageAdapter->prepare();

        // Note: if the parser doesn't find the '<item>' in the XML file it will be working forever
        while ('item' !== $xml->name) {
            try {
                $xml->read();
            } catch (\Exception $e) {
                throw new XmlDataImporterException('Cannot read the XML file!');
            }
        }
        do {
            $object = simplexml_load_string($xml->readOuterXml());
            if (false === $object) {
                throw new XmlDataImporterException('Cannot process the XML file!');
            }

            $fields = [];
            $fields['entity_id'] = (string) $object->entity_id;
            $fields['sku'] = (string) $object->sku;
            $fields['name'] = (string) $object->name;
            $fields['description'] = (string) $object->description;
            $fields['shortdesc'] = (string) $object->shortdesc;
            $fields['price'] = (string) $object->price;
            $fields['link'] = (string) $object->link;
            $fields['image'] = (string) $object->image;
            $fields['Brand'] = (string) $object->Brand;
            $fields['Rating'] = (string) $object->Rating;
            $fields['CaffeineType'] = (string) $object->CaffeineType;
            $fields['Count'] = (string) $object->Count;
            $fields['Flavored'] = (string) $object->Flavored;
            $fields['Seasonal'] = (string) $object->Seasonal;
            $fields['Instock'] = (string) $object->Instock;
            $fields['Facebook'] = (string) $object->Facebook;
            $fields['IsKCup'] = (string) $object->IsKCup;

            $this->storageAdapter->store($fields);
        } while ($xml->next('item'));

        $this->storageAdapter->finish();
    }
}
