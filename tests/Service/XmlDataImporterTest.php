<?php

namespace App\Tests\Service;

use App\Adapter\StorageAdapterInterface;
use App\Entity\Feed;
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

    public function testXmlError(): void
    {
        $this->expectException(XmlDataImporterException::class);

        $storageAdapter = $this->createMock(StorageAdapterInterface::class);

        $xmlDataImporter = new XmlDataImporter($storageAdapter);

        $storageAdapter
            ->expects($this->once())
            ->method('prepare')
        ;

        $tempDirectory = sys_get_temp_dir();
        $testFilename = $tempDirectory.'/test.xml';
        file_put_contents($testFilename, $this->getErrorXml());

        $xmlDataImporter->process($testFilename);

        unlink($testFilename);
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

        $feed = new Feed();
        $feed
            ->setEntityId('340')
            ->setCategoryName('Green Mountain Ground Coffee')
            ->setSku('20')
            ->setName('Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag')
            ->setDescription('Item description')
            ->setShortDescription('Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.')
            ->setPrice('41.6000')
            ->setLink('http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html')
            ->setImage('http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg')
            ->setBrand('Green Mountain Coffee')
            ->setRating('0')
            ->setCaffeineType('Caffeinated')
            ->setCount('24')
            ->setFlavored('No')
            ->setSeasonal('No')
            ->setInstock('Yes')
            ->setFacebook('1')
            ->setIsKCup('0');

        $storageAdapter
            ->expects($this->once())
            ->method('store')
            ->with($feed);

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

    private function getSampleXml(): string
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

    private function getErrorXml(): string
    {
        return '<?xml version="1.0" encoding="utf-8"?>
    <catalog>
    <item>
        <entity_id>340/entity_id>
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