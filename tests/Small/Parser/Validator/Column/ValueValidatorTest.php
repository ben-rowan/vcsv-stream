<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator\Column;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\Column\ColumnValidator;
use BenRowan\VCsvStream\Parser\Validator\Column\ValueValidator;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;
use BenRowan\VCsvStream\Tests\Small\Parser\Validator\AbstractValidatorTest;

class ValueValidatorTest extends AbstractValidatorTest
{
    protected function getClass(): ValidatorInterface
    {
        return new ValueValidator();
    }

    protected function getValidConfig(): array
    {
        return [
            ConfigParser::KEY_VALUE => 'value',
        ];
    }

    protected function getSection(): string
    {
        return ValueValidator::SECTION;
    }

    public function missingKeyDataProvider(): array
    {
        return [
            [ConfigParser::KEY_VALUE],
        ];
    }

    public function wrongTypeDataProvider(): array
    {
        return [
            [ConfigParser::KEY_VALUE, []],
        ];
    }
}