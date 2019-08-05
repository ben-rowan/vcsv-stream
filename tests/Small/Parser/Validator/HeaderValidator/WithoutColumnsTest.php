<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator\HeaderValidator;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\HeaderValidator;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;
use BenRowan\VCsvStream\Tests\Small\Parser\Validator\AbstractValidatorTest;

class WithoutColumnsTest extends AbstractValidatorTest
{
    protected function getClass(): ValidatorInterface
    {
        return new HeaderValidator();
    }

    protected function getValidConfig(): array
    {
        return [
            ConfigParser::KEY_INCLUDE => true,
        ];
    }

    protected function getSection(): string
    {
        return HeaderValidator::SECTION;
    }

    public function missingKeyDataProvider(): array
    {
        return [
            [ConfigParser::KEY_INCLUDE],
        ];
    }

    public function wrongTypeDataProvider(): array
    {
        return [
            [ConfigParser::KEY_INCLUDE, 'true'],
        ];
    }
}