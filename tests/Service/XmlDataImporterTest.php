<?php

namespace App\Tests\Service;

use App\Adapter\StorageAdapterInterface;
use App\Service\XmlDataImporter;
use PHPUnit\Framework\TestCase;
use App\Exception\XmlDataImporterException;

class XmlDataImporterTest extends TestCase
{
    public function testEmptyFileContents(): void
    {
        $this->expectException(XmlDataImporterException::class);
        $this->expectExceptionMessage('The file contents of the XML file is empty!');

        $storageAdapter = $this->createMock(StorageAdapterInterface::class);

        $xmlDataImporter = new XmlDataImporter($storageAdapter);

        $xmlDataImporter->process('');
    }

    public function testProcess()
    {
        $storageAdapter = $this->createMock(StorageAdapterInterface::class);

        $xmlDataImporter = new XmlDataImporter($storageAdapter);

        $storageAdapter
            ->expects($this->once())
            ->method('prepare')
            ;

        $storageAdapter
            ->expects($this->once())
            ->method('store')
        ;

        $storageAdapter
            ->expects($this->once())
            ->method('finish')
        ;

        $xmlDataImporter->process('<?xml version="1.0" encoding="utf-8"?><catalog><item><entity_id>340</entity_id></item></catalog>');
    }
}