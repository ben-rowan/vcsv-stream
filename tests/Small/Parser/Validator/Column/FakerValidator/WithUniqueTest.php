<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator\Column\FakerValidator;

use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\Column\FakerValidator;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;
use BenRowan\VCsvStream\Tests\Small\Parser\Validator\AbstractValidatorTest;

class WithUniqueTest extends AbstractValidatorTest
{
    protected function getClass(): ValidatorInterface
    {
        return new FakerValidator();
    }

    protected function getValidConfig(): array
    {
        return [
            ConfigParser::KEY_FORMATTER => 'randomNumber',
            ConfigParser::KEY_UNIQUE    => true,
        ];
    }

    protected function getSection(): string
    {
        return FakerValidator::SECTION;
    }

    public function missingKeyDataProvider(): array
    {
        return [
            [ConfigParser::KEY_FORMATTER],
        ];
    }

    public function wrongTypeDataProvider(): array
    {
        return [
            [ConfigParser::KEY_FORMATTER, true],
            [ConfigParser::KEY_UNIQUE, 'false'],
        ];
    }
}