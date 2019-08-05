<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Factory\Parser;

use BenRowan\VCsvStream\Factory\Parser\Validate\ConfigValidatorFactory;
use BenRowan\VCsvStream\Factory\RowFactory;
use BenRowan\VCsvStream\Parser\ConfigParser;

class ConfigParserFactory
{
    public function create(): ConfigParser
    {
        return new ConfigParser(
            new ConfigValidatorFactory(),
            new RowFactory()
        );
    }
}