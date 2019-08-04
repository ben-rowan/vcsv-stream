<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\Validate\Yaml;

use BenRowan\VCsvStream\Exceptions\ValidationException;

class YamlValidator
{
    /**
     * @var RootValidator
     */
    private $rootValidator;

    public function __construct(
        RootValidator $rootValidator
    )
    {
        $this->rootValidator = $rootValidator;
    }

    /**
     * Validate that the required root elements are set.
     *
     * @param array $config
     *
     * @throws ValidationException
     */
    public function validateRoot(array $config): void
    {
        $this->rootValidator->validate($config);
    }
}