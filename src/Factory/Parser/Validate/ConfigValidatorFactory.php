<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Factory\Parser\Validate\Yaml;

use BenRowan\VCsvStream\Parser\Validator\RootValidator;
use BenRowan\VCsvStream\Parser\Validator\ConfigValidator;

class ConfigValidatorFactory
{
    public function create(): ConfigValidator
    {
        return new ConfigValidator(
            new RootValidator()
        );
    }
}