<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\ConfigParser;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Factory\Parser\Validate\ConfigValidatorFactory;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;
use BenRowan\VCsvStream\Tests\Assets\Fakes\Row\RowFactoryFake;
use BenRowan\VCsvStream\Tests\Assets\Fakes\Row\RowFake;

class ParsingTest extends AbstractTestCase
{
    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanIncludeAHeader(): void
    {
        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [],
            ],
            ConfigParser::KEY_RECORDS => [],
        ];

        $parser->parse($config);

        /** @var RowFake $header */
        $header = $parser->getHeader();

        $this->assertTrue($header->getInclude());
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanExcludeAHeader(): void
    {
        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => false,
                ConfigParser::KEY_COLUMNS => [],
            ],
            ConfigParser::KEY_RECORDS => [],
        ];

        $parser->parse($config);

        /** @var RowFake $header */
        $header = $parser->getHeader();

        $this->assertFalse($header->getInclude());
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddAValueHeaderColumn(): void
    {
        $name  = 'Column';
        $value = 'value';

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE  => ConfigParser::COL_TYPE_VALUE,
                        ConfigParser::KEY_VALUE => $value,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [],
        ];

        $parser->parse($config);

        /** @var RowFake $header */
        $header = $parser->getHeader();
        $column = $header->getValueColumns()[0];

        $this->assertSame($name, $column[RowFake::KEY_NAME]);
        $this->assertSame($value, $column[RowFake::KEY_VALUE]);
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddAFakerHeaderColumn(): void
    {
        $name      = 'Column';
        $formatter = 'randomNumber';
        $unique    = true;

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE      => ConfigParser::COL_TYPE_FAKER,
                        ConfigParser::KEY_FORMATTER => $formatter,
                        ConfigParser::KEY_UNIQUE    => $unique,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [],
        ];

        $parser->parse($config);

        /** @var RowFake $header */
        $header = $parser->getHeader();
        $column = $header->getFakerColumns()[0];

        $this->assertSame($name, $column[RowFake::KEY_NAME]);
        $this->assertSame($formatter, $column[RowFake::KEY_FORMATTER]);
        $this->assertSame($unique, $column[RowFake::KEY_UNIQUE]);
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddATextHeaderColumn(): void
    {
        $name = 'Column';

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [],
        ];

        $parser->parse($config);

        /** @var RowFake $header */
        $header = $parser->getHeader();
        $column = $header->getTextColumns()[0];

        $this->assertSame($name, $column[RowFake::KEY_NAME]);
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddARecord(): void
    {
        $name  = 'Column';
        $count = 1;

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [
                'Record' => [
                    ConfigParser::KEY_COUNT   => $count,
                    ConfigParser::KEY_COLUMNS => [],
                ],
            ],
        ];

        $parser->parse($config);

        /** @var RowFake $record */
        $record = $parser->getRecords()[0];

        $this->assertSame($count, $record->getCount());
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddAValueRecordColumn(): void
    {
        $name  = 'Column';
        $count = 1;
        $value = 'value';

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [
                'Record' => [
                    ConfigParser::KEY_COUNT   => $count,
                    ConfigParser::KEY_COLUMNS => [
                        $name => [
                            ConfigParser::KEY_TYPE  => ConfigParser::COL_TYPE_VALUE,
                            ConfigParser::KEY_VALUE => $value,
                        ],
                    ],
                ],
            ],
        ];

        $parser->parse($config);

        /** @var RowFake $record */
        $record = $parser->getRecords()[0];
        $column = $record->getValueColumns()[0];

        $this->assertSame($name, $column[RowFake::KEY_NAME]);
        $this->assertSame($value, $column[RowFake::KEY_VALUE]);
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddAFakerRecordColumn(): void
    {
        $name      = 'Column';
        $count     = 1;
        $formatter = 'randomNumber';
        $unique    = false;

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [
                'Record' => [
                    ConfigParser::KEY_COUNT   => $count,
                    ConfigParser::KEY_COLUMNS => [
                        $name => [
                            ConfigParser::KEY_TYPE      => ConfigParser::COL_TYPE_FAKER,
                            ConfigParser::KEY_FORMATTER => $formatter,
                            ConfigParser::KEY_UNIQUE    => $unique,
                        ],
                    ],
                ],
            ],
        ];

        $parser->parse($config);

        /** @var RowFake $record */
        $record = $parser->getRecords()[0];
        $column = $record->getFakerColumns()[0];

        $this->assertSame($name, $column[RowFake::KEY_NAME]);
        $this->assertSame($formatter, $column[RowFake::KEY_FORMATTER]);
        $this->assertSame($unique, $column[RowFake::KEY_UNIQUE]);
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iCanAddATextRecordFakerColumn(): void
    {
        $name  = 'Column';
        $count = 1;

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $name => [
                        ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [
                'Record' => [
                    ConfigParser::KEY_COUNT   => $count,
                    ConfigParser::KEY_COLUMNS => [
                        $name => [
                            ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                        ],
                    ],
                ],
            ],
        ];

        $parser->parse($config);

        /** @var RowFake $record */
        $record = $parser->getRecords()[0];
        $column = $record->getTextColumns()[0];

        $this->assertSame($name, $column[RowFake::KEY_NAME]);
    }

    /**
     * @test
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public function iGetAnExceptionIfARecordColumnNameWasNotDefinedInTheHeaderColumns(): void
    {
        $this->expectException(ParserException::class);

        $headerColumnName = 'Correct Column Name';
        $recordColumnName = 'Wrong Column Name';

        $parser = $this->getClass();
        $config = [
            ConfigParser::KEY_HEADER  => [
                ConfigParser::KEY_INCLUDE => true,
                ConfigParser::KEY_COLUMNS => [
                    $headerColumnName => [
                        ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                    ],
                ],
            ],
            ConfigParser::KEY_RECORDS => [
                'Record' => [
                    ConfigParser::KEY_COUNT   => 1,
                    ConfigParser::KEY_COLUMNS => [
                        $recordColumnName => [
                            ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_TEXT,
                        ],
                    ],
                ],
            ],
        ];

        $parser->parse($config);
    }

    private function getClass(): ConfigParser
    {
        return new ConfigParser(
            new ConfigValidatorFactory(),
            new RowFactoryFake()
        );
    }
}