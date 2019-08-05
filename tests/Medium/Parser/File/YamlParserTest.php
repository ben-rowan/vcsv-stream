<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Medium\Parser\File;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Parser\File\YamlParser;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class YamlParserTest extends AbstractTestCase
{
    private const FIXTURE_DIR = __DIR__ . '/../../../Assets/fixtures/Parser/File/YamlParser';

    private const FIXTURE_VALID   = self::FIXTURE_DIR . '/valid.yaml';
    private const FIXTURE_INVALID = self::FIXTURE_DIR . '/invalid.yaml';
    private const FIXTURE_MISSING = self::FIXTURE_DIR . '/i_do_not_exist.yaml';

    /**
     * @test
     *
     * @throws ParserException
     */
    public function iCanParseAValidYamlFile(): void
    {
        $parser = $this->getClass();
        $config = $parser->parse(self::FIXTURE_VALID);

        $this->assertSame($this->expectedConfig(), $config);
    }

    /**
     * @test
     *
     * @throws ParserException
     */
    public function iThrowAParserExceptionForInvalidFiles(): void
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessageRegExp('#Unable to parse CSV config \'.*\': .*#');


        $parser = $this->getClass();

        $parser->parse(self::FIXTURE_INVALID);
    }

    /**
     * @test
     *
     * @throws ParserException
     */
    public function iThrowAParserExceptionIfTheFileDoesNotExist(): void
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessageRegExp('#Unable to read config file \'.*\'#');

        $parser = $this->getClass();

        $parser->parse(self::FIXTURE_MISSING);
    }

    private function getClass(): YamlParser
    {
        return new YamlParser();
    }

    private function expectedConfig(): array
    {
        return [
            'header'  => [
                'include' => true,
                'columns' => [
                    'Column One'   => [
                        'type'  => 'value',
                        'value' => 1,
                    ],
                    'Column Two'   => [
                        'type'      => 'faker',
                        'formatter' => 'randomNumber',
                        'unique'    => true,
                    ],
                    'Column Three' => [
                        'type' => 'text',
                    ],
                ],
            ],
            'records' => [
                'Record One'   => [
                    'count'   => 10,
                    'columns' => [
                        'Column Two'   => [
                            'type'  => 'value',
                            'value' => 2,
                        ],
                        'Column Three' => [
                            'type'      => 'faker',
                            'formatter' => 'randomNumber',
                            'unique'    => false,
                        ],
                    ],
                ],
                'Record Two'   => [
                    'count'   => 10,
                    'columns' => [
                        'Column Two'   => [
                            'type'  => 'value',
                            'value' => 3,
                        ],
                        'Column Three' => [
                            'type'      => 'faker',
                            'formatter' => 'text',
                            'unique'    => false,
                        ],
                    ],
                ],
                'Record Three' => [
                    'count'   => 10000,
                    'columns' => [
                        'Column Two'   => [
                            'type'  => 'value',
                            'value' => 4,
                        ],
                        'Column Three' => [
                            'type'      => 'faker',
                            'formatter' => 'ipv4',
                        ],
                    ],
                ],
            ],
        ];
    }
}