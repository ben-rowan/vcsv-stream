<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\ConfigParser;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Factory\Parser\ConfigParserFactory;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class ValidationTest extends AbstractTestCase
{
    /**
     * @test
     *
     * @param array $config
     *
     * @throws ValidationException
     * @throws ParserException
     *
     * @dataProvider invalidConfigDataProvider
     */
    public function iCorrectlyValidateConfig(array $config): void
    {
        $this->expectException(ValidationException::class);

        $parser = $this->getClass();

        $parser->parse($config);
    }

    /**
     * Just returns one error per validator type to ensure
     * they're still integrated correctly.
     *
     * Detailed testing is done at the validator level.
     *
     * @return array
     */
    public function invalidConfigDataProvider(): array
    {
        return [
            'Invalid Root' => [
                []
            ],
            'Invalid Header' => [
                [
                    ConfigParser::KEY_HEADER  => [],
                    ConfigParser::KEY_RECORDS => [],
                ],
            ],
            'Invalid Header Column' => [
                [
                    ConfigParser::KEY_HEADER  => [
                        ConfigParser::KEY_INCLUDE => true,
                        ConfigParser::KEY_COLUMNS => [
                            'Name' => []
                        ]
                    ],
                    ConfigParser::KEY_RECORDS => [],
                ],
            ],
            'Invalid Faker Column' => [
                [
                    ConfigParser::KEY_HEADER  => [
                        ConfigParser::KEY_INCLUDE => true,
                        ConfigParser::KEY_COLUMNS => [
                            'Name' => [
                                ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_FAKER
                            ]
                        ]
                    ],
                    ConfigParser::KEY_RECORDS => [],
                ],
            ],
            'Invalid Value Column' => [
                [
                    ConfigParser::KEY_HEADER  => [
                        ConfigParser::KEY_INCLUDE => true,
                        ConfigParser::KEY_COLUMNS => [
                            'Name' => [
                                ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_VALUE
                            ]
                        ]
                    ],
                    ConfigParser::KEY_RECORDS => [],
                ],
            ],
            'Invalid Record' => [
                [
                    ConfigParser::KEY_HEADER  => [
                        ConfigParser::KEY_INCLUDE => true,
                        ConfigParser::KEY_COLUMNS => [
                            'Name' => [
                                ConfigParser::KEY_TYPE => 'value'
                            ]
                        ]
                    ],
                    ConfigParser::KEY_RECORDS => [
                        'Name' => []
                    ],
                ],
            ],
            'Invalid Record Column' => [
                [
                    ConfigParser::KEY_HEADER  => [
                        ConfigParser::KEY_INCLUDE => true,
                        ConfigParser::KEY_COLUMNS => [
                            'Name' => [
                                ConfigParser::KEY_TYPE => 'value'
                            ]
                        ]
                    ],
                    ConfigParser::KEY_RECORDS => [
                        'Name' => [
                            ConfigParser::KEY_COUNT => 10,
                            ConfigParser::KEY_COLUMNS => [
                                'Name' => []
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    private function getClass(): ConfigParser
    {
        return (new ConfigParserFactory())->create();
    }
}