<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;

class RootValidator extends AbstractValidator
{
    public const SECTION = 'root';

    /**
     * Validate that the required root elements are set correctly.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(array $config): bool
    {
        $this->validateHeader($config);
        $this->validateRecords($config);

        return true;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateHeader(array $config): void
    {
        $this->assertIsset(self::SECTION, ConfigParser::KEY_HEADER, $config);
        $this->assertIsArray(ConfigParser::KEY_HEADER, $config);
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function validateRecords(array $config): void
    {
        if (false === isset($config[ConfigParser::KEY_RECORDS])) {
            return;
        }

        $this->assertIsArray(ConfigParser::KEY_RECORDS, $config);
    }
}