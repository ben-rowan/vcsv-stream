<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;

abstract class AbstractValidator
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
}