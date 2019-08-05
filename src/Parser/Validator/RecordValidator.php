<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;

class RecordValidator extends AbstractValidator
{
    public const SECTION = 'record';

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
        $this->validateCount($config);
        $this->validateColumns($config);

        return true;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateCount(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_COUNT, $config);
        $this->assertIsInt(ConfigParser::KEY_COUNT, $config);
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateColumns(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_COLUMNS, $config);
        $this->assertIsArray(ConfigParser::KEY_COLUMNS, $config);
    }
}