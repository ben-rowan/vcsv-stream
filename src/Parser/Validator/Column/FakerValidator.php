<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator\Column;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\AbstractValidator;

class FakerValidator extends AbstractValidator
{
    public const SECTION = 'column';

    /**
     * Validate that the required faker column elements are set correctly.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(array $config): bool
    {
        $this->validateFormatter($config);
        $this->validateUnique($config);

        return true;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateFormatter(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_FORMATTER, $config);
        $this->assertIsString(ConfigParser::KEY_FORMATTER, $config);
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateUnique(array $config): void
    {
        if (false === isset($config[ConfigParser::KEY_UNIQUE])) {
            return;
        }

        $this->assertIsBool(ConfigParser::KEY_UNIQUE, $config);
    }
}