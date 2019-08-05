<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\RootValidator;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;

class RootValidatorTest extends AbstractValidatorTest
{
    protected function getClass(): ValidatorInterface
    {
        return new RootValidator();
    }

    protected function getValidConfig(): array
    {
        return [
            ConfigParser::KEY_HEADER  => [],
            ConfigParser::KEY_RECORDS => [],
        ];
    }

    protected function getSection(): string
    {
        return RootValidator::SECTION;
    }

    public function missingKeyDataProvider(): array
    {
        return [
            [ConfigParser::KEY_HEADER],
            [ConfigParser::KEY_RECORDS],
        ];
    }

    public function wrongTypeDataProvider(): array
    {
        return [
            [ConfigParser::KEY_HEADER, true],
            [ConfigParser::KEY_RECORDS, 'hello'],
        ];
    }
}