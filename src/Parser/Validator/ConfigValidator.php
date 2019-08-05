<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\Validator\Column\ColumnValidator;
use BenRowan\VCsvStream\Parser\Validator\Column\FakerValidator;
use BenRowan\VCsvStream\Parser\Validator\Column\ValueValidator;

class ConfigValidator
{
    /**
     * @var RootValidator
     */
    private $rootValidator;
    /**
     * @var HeaderValidator
     */
    private $headerValidator;
    /**
     * @var RecordValidator
     */
    private $recordValidator;
    /**
     * @var ColumnValidator
     */
    private $columnValidator;
    /**
     * @var FakerValidator
     */
    private $fakerValidator;
    /**
     * @var ValueValidator
     */
    private $valueValidator;

    public function __construct(
        RootValidator $rootValidator,
        HeaderValidator $headerValidator,
        RecordValidator $recordValidator,
        ColumnValidator $columnValidator,
        FakerValidator $fakerValidator,
        ValueValidator $valueValidator
    )
    {
        $this->rootValidator   = $rootValidator;
        $this->headerValidator = $headerValidator;
        $this->recordValidator = $recordValidator;
        $this->columnValidator = $columnValidator;
        $this->fakerValidator  = $fakerValidator;
        $this->valueValidator  = $valueValidator;
    }

    /**
     * Validate that the required root elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateRoot(array $config): bool
    {
        return $this->rootValidator->validate($config);
    }

    /**
     * Validate that the required header elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateHeader(array $config): bool
    {
        return $this->headerValidator->validate($config);
    }

    /**
     * Validate that the required record elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateRecord(array $config): bool
    {
        return $this->recordValidator->validate($config);
    }

    /**
     * Validate that the required column elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateColumn(array $config): bool
    {
        return $this->columnValidator->validate($config);
    }

    /**
     * Validate that the required faker column elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateFakerColumn(array $config): bool
    {
        return $this->fakerValidator->validate($config);
    }

    /**
     * Validate that the required value column elements are set.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateValueColumn(array $config): bool
    {
        return $this->valueValidator->validate($config);
    }
}