<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validate\Yaml;

use BenRowan\VCsvStream\Exceptions\ValidationException;
use BenRowan\VCsvStream\Parser\YamlParser;

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
        if (false === isset($config[YamlParser::KEY_HEADER])) {
            throw new ValidationException(
                "You must include a '" . YamlParser::KEY_HEADER . "' in your config"
            );
        }

        if (false === isset($config[YamlParser::KEY_ROWS])) {
            throw new ValidationException(
                "You must include a '" . YamlParser::KEY_ROWS . "' in your config"
            );
        }
    }
}