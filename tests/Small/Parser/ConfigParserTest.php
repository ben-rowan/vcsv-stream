<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class ConfigParserTest extends AbstractTestCase
{
    private const FIXTURE_DIR = __DIR__ . '/../../Assets/fixtures/Parser/YamlParser';

    private const FIXTURE_VALID = self::FIXTURE_DIR . '/valid.yaml';

    private function getClass(): ConfigParser
    {
        return new ConfigParser();
    }

    /**
     * @test
     */
    public function iCanParseAValidYamlFile(): void
    {
        $parser = $this->getClass();

        $parser->parse(self::FIXTURE_VALID);

        $header = $parser->getHeader();
        $records = $parser->getRecords();
    }
}