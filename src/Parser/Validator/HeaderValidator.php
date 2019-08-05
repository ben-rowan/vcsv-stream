<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;

class HeaderValidator extends AbstractValidator
{
    public const SECTION = 'header';

    /**
     * Validate that the required header elements are set correctly.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(array $config): bool
    {
        $this->validateInclude($config);
        $this->validateColumns($config);

        return true;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateInclude(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_INCLUDE, $config);
        $this->assertIsBool(ConfigParser::KEY_INCLUDE, $config);
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateColumns(array $config): void
    {
        if (false === isset($config[ConfigParser::KEY_COLUMNS])) {
            return;
        }

        $this->assertIsArray(ConfigParser::KEY_COLUMNS, $config);
    }
}