<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Factory\Parser\Validate;

use BenRowan\VCsvStream\Parser\Validator\Column\ColumnValidator;
use BenRowan\VCsvStream\Parser\Validator\Column\FakerValidator;
use BenRowan\VCsvStream\Parser\Validator\Column\ValueValidator;
use BenRowan\VCsvStream\Parser\Validator\HeaderValidator;
use BenRowan\VCsvStream\Parser\Validator\RecordValidator;
use BenRowan\VCsvStream\Parser\Validator\RootValidator;
use BenRowan\VCsvStream\Parser\Validator\ConfigValidator;

class ConfigValidatorFactory
{
    private $rootValidator;
    private $headerValidator;
    private $recordValidator;
    private $columnValidator;
    private $fakerValidator;
    private $valueValidator;

    public function __construct()
    {
        $this->rootValidator   = new RootValidator();
        $this->headerValidator = new HeaderValidator();
        $this->recordValidator = new RecordValidator();
        $this->columnValidator = new ColumnValidator();
        $this->fakerValidator  = new FakerValidator();
        $this->valueValidator  = new ValueValidator();
    }

    public function create(): ConfigValidator
    {
        return new ConfigValidator(
            $this->rootValidator,
            $this->headerValidator,
            $this->recordValidator,
            $this->columnValidator,
            $this->fakerValidator,
            $this->valueValidator
        );
    }
}