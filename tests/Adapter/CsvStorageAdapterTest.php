<?php

namespace App\Tests\Adapter;

use App\Adapter\CsvStorageAdapter;
use App\Entity\Feed;
use PHPUnit\Framework\TestCase;

class CsvStorageAdapterTest extends TestCase
{
    public const OUTPUT_FILENAME = 'output.csv';
    public const REFERENCE_FILENAME = './tests/Sample/reference.csv';

    public function testStore(): void
    {
        $tempDirectory = sys_get_temp_dir();

        $csvStorageAdapter = new CsvStorageAdapter();
        $csvStorageAdapter->setFilename($tempDirectory.'/'.self::OUTPUT_FILENAME);

        $csvStorageAdapter->setSeparator(',');
        $csvStorageAdapter->prepare();

        $csvStorageAdapter->store($this->getFeed1());
        $csvStorageAdapter->store($this->getFeed2());
        $csvStorageAdapter->store($this->getFeed3());

        $csvStorageAdapter->finish();

        $output_file_content_1 = file_get_contents($tempDirectory.'/'.self::OUTPUT_FILENAME);
        $reference_file_content_2 = file_get_contents(self::REFERENCE_FILENAME);

        $this->assertTrue($output_file_content_1 == $reference_file_content_2);

        unlink($tempDirectory.'/'.self::OUTPUT_FILENAME);
    }

    private function getFeed1(): Feed
    {
        $feed = new Feed();
        $feed
            ->setEntityId('1')
            ->setCategoryName('Green Mountain Ground Coffee - 1')
            ->setSku('10')
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

        return $feed;
    }

    private function getFeed2(): Feed
    {
        $feed = new Feed();
        $feed
            ->setEntityId('2')
            ->setCategoryName('Green Mountain Ground Coffee - 2')
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

        return $feed;
    }

    private function getFeed3(): Feed
    {
        $feed = new Feed();
        $feed
            ->setEntityId('3')
            ->setCategoryName('Green Mountain Ground Coffee - 3')
            ->setSku('30')
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

        return $feed;
    }
}
