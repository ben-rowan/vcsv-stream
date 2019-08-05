<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator\Column;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\Column\ColumnValidator;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;
use BenRowan\VCsvStream\Tests\Small\Parser\Validator\AbstractValidatorTest;

class ColumnValidatorTest extends AbstractValidatorTest
{
    protected function getClass(): ValidatorInterface
    {
        return new ColumnValidator();
    }

    protected function getValidConfig(): array
    {
        return [
            ConfigParser::KEY_TYPE => ConfigParser::COL_TYPE_FAKER,
        ];
    }

    protected function getSection(): string
    {
        return ColumnValidator::SECTION;
    }

    public function missingKeyDataProvider(): array
    {
        return [
            [ConfigParser::KEY_TYPE],
        ];
    }

    public function wrongTypeDataProvider(): array
    {
        return [
            [ConfigParser::KEY_TYPE, 'hello'],
        ];
    }
}