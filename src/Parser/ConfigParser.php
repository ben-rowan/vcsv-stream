<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Factory\Parser\Validate\Yaml\ConfigValidatorFactory;
use BenRowan\VCsvStream\Factory\RowFactory;
use BenRowan\VCsvStream\Factory\RowFactoryInterface;
use BenRowan\VCsvStream\Parser\Validator\ConfigValidator;
use BenRowan\VCsvStream\Row\Header;
use BenRowan\VCsvStream\Row\Record;
use Symfony\Component\Yaml\Yaml;

class ConfigParser
{
    public const KEY_HEADER    = 'header';
    public const KEY_RECORDS   = 'records';
    public const KEY_INCLUDE   = 'include';
    public const KEY_COLUMNS   = 'columns';
    public const KEY_TYPE      = 'type';
    public const KEY_VALUE     = 'value';
    public const KEY_FORMATTER = 'formatter';
    public const KEY_UNIQUE    = 'unique';
    public const KEY_COUNT     = 'count';

    public const COL_TYPE_VALUE = 'value';
    public const COL_TYPE_FAKER = 'faker';
    public const COL_TYPE_TEXT = 'text';

    public const COL_TYPES = [
        self::COL_TYPE_VALUE,
        self::COL_TYPE_FAKER,
        self::COL_TYPE_TEXT
    ];

    /**
     * @var Header
     */
    private $header;
    /**
     * @var Record[]
     */
    private $records = [];
    /**
     * @var ConfigValidator
     */
    private $validator;
    /**
     * @var RowFactory
     */
    private $rowFactory;

    public function __construct(
        ConfigValidatorFactory $configValidatorFactory,
        RowFactoryInterface $rowFactory
    )
    {
        $this->validator  = $configValidatorFactory->create();
        $this->rowFactory = $rowFactory;

        $this->header  = $this->rowFactory->createHeader(true);
        $this->records = [$this->rowFactory->createRecord(10)];


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