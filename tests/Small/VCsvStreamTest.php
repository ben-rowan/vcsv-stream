<?php

namespace BenRowan\VCsvStream\Tests\Small;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\VCsvStream;
use PHPUnit\Framework\TestCase;
use SplFileObject;

class VCsvStreamTest extends TestCase
{
    private const FIXTURE_DIR = __DIR__ . '/../Assets/fixtures/VCsvStream';

    public const FIXTURE_WITH_HEADER = self::FIXTURE_DIR . '/with_header.yaml';
    public const FIXTURE_NO_HEADER   = self::FIXTURE_DIR . '/no_header.yaml';

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
     *
     * @throws ValidationException
     * @throws ParserException
     */
    public function iCanGenerateACsvWithAHeader(): void
    {
        VCsvStream::loadYamlConfig(self::FIXTURE_WITH_HEADER);

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
     *
     * @throws ValidationException
     * @throws ParserException
     */
    public function iCanGenerateACsvWithoutAHeader(): void
    {
        VCsvStream::loadYamlConfig(self::FIXTURE_NO_HEADER);

        $vCsv = new SplFileObject('vcsv://fixture.csv');

        $rows = [];
        while ($row = $vCsv->fgetcsv()) {
            $rows[] = $row;
        }

        $this->assertCount(10020, $rows);
    }
}
