<?php

namespace BenRowan\VCsvStream\Tests\Small;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Row\Header;
use BenRowan\VCsvStream\Row\NoHeader;
use BenRowan\VCsvStream\Row\Record;
use BenRowan\VCsvStream\VCsvStream;
use PHPUnit\Framework\TestCase;
use SplFileObject;

class VCsvStreamTest extends TestCase
{
    public const HEADER_1 = 'Column One';
    public const HEADER_2 = 'Column Two';
    public const HEADER_3 = 'Column Three';

    /**
     * @throws VCsvStreamException
     */
    public function setUp()
    {
        VCsvStream::setup();
    }

    /**
     * Run the code...
     *
     * @test
     */
    public function iCanGetDataFromStream(): void
    {
        $this->withHeader();

        $records = [];

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 2)
            ->addFakerColumn(self::HEADER_3, 'randomNumber', false);

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 3)
            ->addFakerColumn(self::HEADER_3, 'text', false);

        $records[] = (new Record(10000))
            ->addValueColumn(self::HEADER_2, 4)
            ->addFakerColumn(self::HEADER_3, 'ipv4', false);

        VCsvStream::addRecords($records);

        $vCsv = new SplFileObject('vcsv://fixture.csv');

        $rows = [];
        while ($row = $vCsv->fgetcsv()) {
            $rows[] = $row;
        }

        $this->assertCount(10021, $rows);
    }

    /**
     * Run the code...
     *
     * @test
     */
    public function iCanGetDataFromStreamWithNoHeader(): void
    {
        $this->withoutHeader();

        $records = [];

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 2)
            ->addFakerColumn(self::HEADER_3, 'randomNumber', false);

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 3)
            ->addFakerColumn(self::HEADER_3, 'text', false);

        $records[] = (new Record(10000))
            ->addValueColumn(self::HEADER_2, 4)
            ->addFakerColumn(self::HEADER_3, 'ipv4', false);

        VCsvStream::addRecords($records);

        $vCsv = new SplFileObject('vcsv://fixture.csv');

        $rows = [];
        while ($row = $vCsv->fgetcsv()) {
            $rows[] = $row;
        }

        $this->assertCount(10020, $rows);
    }

    private function withHeader(): void
    {
        $header = new Header();

        $header
            ->addValueColumn(self::HEADER_1, 1)
            ->addFakerColumn(self::HEADER_2, 'randomNumber', true)
            ->addColumn(self::HEADER_3);

        VCsvStream::setHeader($header);
    }

    private function withoutHeader(): void
    {
        $header = new NoHeader();

        $header
            ->addValueColumn(self::HEADER_1, 1)
            ->addFakerColumn(self::HEADER_2, 'randomNumber', true)
            ->addColumn(self::HEADER_3);

        VCsvStream::setHeader($header);
    }
}
