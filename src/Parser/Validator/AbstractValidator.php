<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @param string $section The section of the config that you're validating
     * @param string $item    The item (eg header, records, include...) that you're validating
     * @param array  $config  The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertIsset(string $section, string $item, array $config): void
    {
        if (true === isset($config[$item])) {
            return;
        }

        throw new ValidationException(
            "You must include a '$item' item in your '$section' config section"
        );
    }

    /**
     * @param string $item   The item (eg header, records, include...) that you're validating
     * @param array  $config The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertIsArray(string $item, array $config): void
    {
        if (true === is_array($config[$item])) {
            return;
        }

        throw new ValidationException(
            "'$item' must not have a scalar value"
        );
    }

    /**
     * @param string $item   The item (eg header, records, include...) that you're validating
     * @param array  $config The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertNotArray(string $item, array $config): void
    {
        if (false === is_array($config[$item])) {
            return;
        }

        throw new ValidationException(
            "'$item' must be a scalar value"
        );
    }

    /**
     * @param string $item   The item (eg header, records, include...) that you're validating
     * @param array  $config The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertIsBool(string $item, array $config): void
    {
        if (true === is_bool($config[$item])) {
            return;
        }

        throw new ValidationException(
            "'$item' must be a boolean"
        );
    }

    /**
     * @param string $item   The item (eg header, records, include...) that you're validating
     * @param array  $config The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertIsInt(string $item, array $config): void
    {
        if (true === is_int($config[$item])) {
            return;
        }

        throw new ValidationException(
            "'$item' must be an integer"
        );
    }

    /**
     * @param string $item   The item (eg header, records, include...) that you're validating
     * @param array  $config The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertIsString(string $item, array $config): void
    {
        if (true === is_string($config[$item])) {
            return;
        }

        throw new ValidationException(
            "'$item' must be a string"
        );
    }

    /**
     * @param string $item   The item (eg header, records, include...) that you're validating
     * @param array  $config The config that you're validating
     *
     * @throws ValidationException
     */
    protected function assertIsValidColumnType(string $item, array $config): void
    {
        if (true === in_array($config[$item], ConfigParser::COL_TYPES, true)) {
            return;
        }

        throw new ValidationException(
            "'$item' must be a valid column type: " . implode(',', ConfigParser::COL_TYPES)
        );
    }
}