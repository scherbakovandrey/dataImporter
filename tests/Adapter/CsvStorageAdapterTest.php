<?php

namespace App\Tests\Adapter;

use App\Adapter\CsvStorageAdapter;
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
        $csvStorageAdapter->prepare();
        $csvStorageAdapter->store([
            'id' => '1',
            'name' => 'John',
            'age' => '20',
        ]);
        $csvStorageAdapter->store([
            'id' => '2',
            'name' => 'Marie',
            'age' => '19',
        ]);
        $csvStorageAdapter->store([
            'id' => '3',
            'name' => 'Jack',
            'age' => '25',
        ]);
        $csvStorageAdapter->finish();

        $output_file_content_1 = file_get_contents($tempDirectory.'/'.self::OUTPUT_FILENAME);
        $reference_file_content_2 = file_get_contents(self::REFERENCE_FILENAME);

        $this->assertTrue($output_file_content_1 == $reference_file_content_2);

        unlink($tempDirectory.'/'.self::OUTPUT_FILENAME);
    }
}
