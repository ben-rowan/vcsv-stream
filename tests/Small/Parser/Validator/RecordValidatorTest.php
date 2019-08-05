<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\HeaderValidator;
use BenRowan\VCsvStream\Parser\Validator\RecordValidator;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;

class RecordValidatorTest extends AbstractValidatorTest
{
    protected function getClass(): ValidatorInterface
    {
        return new RecordValidator();
    }

    protected function getValidConfig(): array
    {
        return [
            ConfigParser::KEY_COUNT   => 10,
            ConfigParser::KEY_COLUMNS => [],
        ];
    }

    protected function getSection(): string
    {
        return RecordValidator::SECTION;
    }

    public function missingKeyDataProvider(): array
    {
        return [
            [ConfigParser::KEY_COUNT],
            [ConfigParser::KEY_COLUMNS],
        ];
    }

    public function wrongTypeDataProvider(): array
    {
        return [
            [ConfigParser::KEY_COUNT, '10'],
            [ConfigParser::KEY_COLUMNS, true],
        ];
    }
}