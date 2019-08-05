<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;

class RootValidator extends AbstractValidator
{
    public const SECTION = 'root';

    /**
     * Validate that the required root elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(array $config): bool
    {
        // header
        $this->assertIsset(self::SECTION, ConfigParser::KEY_HEADER, $config);
        $this->assertIsArray(ConfigParser::KEY_HEADER, $config);

        // records
        $this->assertIsset(self::SECTION, ConfigParser::KEY_RECORDS, $config);
        $this->assertIsArray(ConfigParser::KEY_RECORDS, $config);

        return true;
    }
}