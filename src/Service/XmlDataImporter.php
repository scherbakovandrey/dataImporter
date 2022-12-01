<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\StorageAdapterInterface;
use App\Entity\Feed;
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

            $feed = new Feed();
            $feed
                ->setEntityId((string) $object->entity_id)
                ->setCategoryName((string) $object->CategoryName)
                ->setSku((string) $object->sku)
                ->setName((string) $object->name)
                ->setDescription((string) $object->description)
                ->setShortDescription((string) $object->shortdesc)
                ->setPrice((string) $object->price)
                ->setLink((string) $object->link)
                ->setImage((string) $object->image)
                ->setBrand((string) $object->Brand)
                ->setRating((string) $object->Rating)
                ->setCaffeineType((string) $object->CaffeineType)
                ->setCount((string) $object->Count)
                ->setFlavored((string) $object->Flavored)
                ->setSeasonal((string) $object->Seasonal)
                ->setInstock((string) $object->Instock)
                ->setFacebook((string) $object->Facebook)
                ->setIsKCup((string) $object->IsKCup);

            $this->storageAdapter->store($feed);
        } while ($xml->next('item'));

        $this->storageAdapter->finish();
    }
}
