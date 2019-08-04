<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser;

use BenRowan\VCsvStream\Exceptions\ValidationException;
use BenRowan\VCsvStream\Parser\Validate\Yaml\YamlValidator;
use BenRowan\VCsvStream\Rows\Header;
use BenRowan\VCsvStream\Rows\Record;
use Symfony\Component\Yaml\Yaml;

class YamlParser
{
    public const KEY_HEADER    = 'header';
    public const KEY_ROWS      = 'rows';
    public const KEY_INCLUDE   = 'include';
    public const KEY_COLUMNS   = 'columns';
    public const KEY_TYPE      = 'type';
    public const KEY_VALUE     = 'value';
    public const KEY_FORMATTER = 'formatter';
    public const KEY_UNIQUE    = 'unique';
    public const KEY_COUNT     = 'count';

    /**
     * @var Header
     */
    private $header;
    /**
     * @var Record[]
     */
    private $records = [];
    /**
     * @var YamlValidator
     */
    private $validator;

    public function __construct()
    {
        $this->validator = new YamlValidator();
    }

    /**
     * @param string $configPath
     *
     * @throws ValidationException
     */
    public function parse(string $configPath): void
    {
        $config = Yaml::parseFile($configPath);

        $this->parseRoot($config);
    }

    /**
     * Get the built header.
     *
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * Get the built records.
     *
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    private function parseRoot(array $config): void
    {
        $this->validator->validateRoot($config);
    }

    private function parseHeader(): void
    {

    }

    private function parseRows(): void
    {

    }

    private function parseRow(): void
    {

    }

    private function parseColumn(): void
    {

    }
}