<?php

namespace App\Tests\Service;

use App\Adapter\StorageAdapterInterface;
use App\Exception\XmlDataImporterException;
use App\Service\XmlDataImporter;
use PHPUnit\Framework\TestCase;

class XmlDataImporterTest extends TestCase
{
    public function testEmptyFileContents(): void
    {
        $this->expectException(XmlDataImporterException::class);
        $this->expectExceptionMessage('Filename is empty!');

        $storageAdapter = $this->createMock(StorageAdapterInterface::class);

        $xmlDataImporter = new XmlDataImporter($storageAdapter);

        $xmlDataImporter->process('');
    }

    /**
     * @throws XmlDataImporterException
     */
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

        $tempDirectory = sys_get_temp_dir();
        $testFilename = $tempDirectory.'/test.xml';
        file_put_contents($testFilename, '<?xml version="1.0" encoding="utf-8"?><catalog><item><entity_id>340</entity_id></item></catalog>');

        $xmlDataImporter->process($testFilename);
    }
}
