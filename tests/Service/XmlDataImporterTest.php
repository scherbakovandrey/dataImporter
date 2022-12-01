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
            ->with([
                'entity_id' => '340',
                'CategoryName' => 'Green Mountain Ground Coffee',
                'sku' => '20',
                'name' => 'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag',
                'description' => 'Item description',
                'shortdesc' => 'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.',
                'price' => '41.6000',
                'link' => 'http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html',
                'image' => 'http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg',
                'Brand' => 'Green Mountain Coffee',
                'Rating' => '0',
                'CaffeineType' => 'Caffeinated',
                'Count' => '24',
                'Flavored' => 'No',
                'Seasonal' => 'No',
                'Instock' => 'Yes',
                'Facebook' => '1',
                'IsKCup' => '0'
            ]);

        $storageAdapter
            ->expects($this->once())
            ->method('finish')
        ;

        $tempDirectory = sys_get_temp_dir();
        $testFilename = $tempDirectory.'/test.xml';
        file_put_contents($testFilename, $this->getSampleXml());

        $xmlDataImporter->process($testFilename);

        unlink($testFilename);
    }

    private function getSampleXml()
    {
        return '<?xml version="1.0" encoding="utf-8"?>
    <catalog>
    <item>
        <entity_id>340</entity_id>
        <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
        <sku>20</sku>
        <name><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]></name>
        <description>Item description</description>
        <shortdesc><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]></shortdesc>
        <price>41.6000</price>
        <link>http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html</link>
        <image>http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg</image>
        <Brand><![CDATA[Green Mountain Coffee]]></Brand>
        <Rating>0</Rating>
        <CaffeineType>Caffeinated</CaffeineType>
        <Count>24</Count>
        <Flavored>No</Flavored>
        <Seasonal>No</Seasonal>
        <Instock>Yes</Instock>
        <Facebook>1</Facebook>
        <IsKCup>0</IsKCup>
    </item>
        </catalog>';
    }
}
