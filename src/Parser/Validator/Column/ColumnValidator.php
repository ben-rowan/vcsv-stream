<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator\Column;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\AbstractValidator;

class ColumnValidator extends AbstractValidator
{
    public const SECTION = 'column';

    /**
     * Validate that the required record elements are set correctly.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(array $config): bool
    {
        $this->validateType($config);

        return true;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateType(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_TYPE, $config);
        $this->assertIsValidColumnType(ConfigParser::KEY_TYPE, $config);
    }
}