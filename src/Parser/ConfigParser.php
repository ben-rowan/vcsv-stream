<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Factory\Parser\Validate\Yaml\ConfigValidatorFactory;
use BenRowan\VCsvStream\Factory\RowFactoryInterface;
use BenRowan\VCsvStream\Parser\Validator\ConfigValidator;
use BenRowan\VCsvStream\Row\Header;
use BenRowan\VCsvStream\Row\Record;
use BenRowan\VCsvStream\Row\RowInterface;

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
    public const COL_TYPE_TEXT  = 'text';

    public const COL_TYPES = [
        self::COL_TYPE_VALUE,
        self::COL_TYPE_FAKER,
        self::COL_TYPE_TEXT,
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
     * @var string[]
     */
    private $validNames = [];
    /**
     * @var ConfigValidator
     */
    private $validator;
    /**
     * @var RowFactoryInterface
     */
    private $rowFactory;

    public function __construct(
        ConfigValidatorFactory $configValidatorFactory,
        RowFactoryInterface $rowFactory
    )
    {
        $this->validator  = $configValidatorFactory->create();
        $this->rowFactory = $rowFactory;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     */
    public function parse(array $config): void
    {
        $this->reset();

        $this->validator->validateRoot($config);

        $this->parseHeader($config[self::KEY_HEADER]);
        $this->parseRecords($config[self::KEY_RECORDS]);
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
     * @param array $header
     *
     * @throws ValidationException
     */
    private function parseHeader(array $header): void
    {
        $this->validator->validateHeader($header);

        $include = (bool)$header[self::KEY_INCLUDE];
        $columns = $header[self::KEY_COLUMNS];

        $this->header = $this->rowFactory->createHeader($include);

        foreach ($columns as $name => $column) {
            $this->addValidName($name);

            $this->parseColumn($this->header, $name, $column);
        }
    }

    private function parseRecords(array $records): void
    {
        foreach ($records as $record) {
            $this->parseRecord($record);
        }
    }

    private function parseRecord(array $record): void
    {
        $this->validator->validateRecord($record);

        $count   = (int)$record[self::KEY_COUNT];
        $columns = $record[self::KEY_COLUMNS];

        $record = $this->rowFactory->createRecord($count);

        foreach ($columns as $name => $column) {
            $this->assertIsValidName($name);

            $this->parseColumn($record, $name, $column);
        }

        $this->records[] = $record;
    }

    /**
     * @param RowInterface $row
     * @param string       $name
     * @param array        $column
     *
     * @throws ValidationException
     */
    private function parseColumn(RowInterface $row, string $name, array $column): void
    {
        $this->validator->validateColumn($column);

        $type = (string)$column[self::KEY_TYPE];

        switch ($type) {
            case self::COL_TYPE_TEXT:
                $row->addColumn($name);
                break;
            case self::COL_TYPE_VALUE:
                $this->validator->validateValueColumn($column);

                $row->addValueColumn($name, $column[self::KEY_VALUE]);
                break;
            case self::COL_TYPE_FAKER:
                $this->validator->validateFakerColumn($column);

                $formatter = (string)$column[self::KEY_FORMATTER];
                $isUnique  = (bool)$column[self::KEY_UNIQUE] ?? false;

                $row->addFakerColumn($name, $formatter, $isUnique);
                break;
        }
    }

    private function reset(): void
    {
        unset($this->header);

        $this->records    = [];
        $this->validNames = [];
    }

    private function addValidName(string $name): void
    {
        $this->validNames[$name] = $name;
    }

    private function assertIsValidName(string $name): void
    {
        if (true === isset($this->validNames[$name])) {
            return;
        }

        throw new ParserException(
            "Column name '$name' wasn't included in the '" . self::KEY_HEADER . "' section"
        );
    }
}