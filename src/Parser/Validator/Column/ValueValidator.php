<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator\Column;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\AbstractValidator;

class ValueValidator extends AbstractValidator
{
    public const SECTION = 'column';

    /**
     * Validate that the required value column elements are set correctly.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(array $config): bool
    {
        $this->validateValue($config);

        return true;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateValue(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_VALUE, $config);
        $this->assertNotArray(ConfigParser::KEY_VALUE, $config);
    }
}