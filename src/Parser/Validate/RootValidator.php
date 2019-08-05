<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validate;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;

class RootValidator
{
    /**
     * Validate that the required root elements are set.
     *
     * @param array $config
     *
     * @throws ValidationException
     */
    public function validate(array $config): void
    {
        if (false === isset($config[ConfigParser::KEY_HEADER])) {
            throw new ValidationException(
                "You must include a '" . ConfigParser::KEY_HEADER . "' in your config"
            );
        }

        if (false === isset($config[ConfigParser::KEY_RECORDS])) {
            throw new ValidationException(
                "You must include a '" . ConfigParser::KEY_RECORDS . "' in your config"
            );
        }
    }
}