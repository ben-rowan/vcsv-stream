<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Factory\Parser\Validate\Yaml;

use BenRowan\VCsvStream\Parser\Validate\Yaml\RootValidator;
use BenRowan\VCsvStream\Parser\Validate\Yaml\YamlValidator;

class YamlValidatorFactory
{
    public function create(): YamlValidator
    {
        return new YamlValidator(
            new RootValidator()
        );
    }
}