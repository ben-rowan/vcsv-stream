<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Factory\Parser\Validate\ConfigValidatorFactory;
use BenRowan\VCsvStream\Factory\RowFactoryInterface;
use BenRowan\VCsvStream\Parser\Validator\ConfigValidator;
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
     * @var RowInterface
     */
    private $header;
    /**
     * @var RowInterface[]
     */
    private $records = [];
    /**
     * @var string[]
     */
    private $validColumnNames = [];
    /**
     * @var ConfigValidator
     */
    private $validator;
    /**
     * @var RowFactoryInterface
     */
    private $rowFactory;

    /**
     * ConfigParser constructor.
     *
     * @param ConfigValidatorFactory $validatorFactory
     * @param RowFactoryInterface    $rowFactory
     */
    public function __construct(
        ConfigValidatorFactory $validatorFactory,
        RowFactoryInterface $rowFactory
    )
    {
        $this->validator  = $validatorFactory->create();
        $this->rowFactory = $rowFactory;
    }

    /**
     * @param array $config
     *
     * @throws ValidationException
     * @throws ParserException
     */
    public function parse(array $config): void
    {
        $this->reset();

        $this->validator->validateRoot($config);

        $this->parseHeader($config[self::KEY_HEADER]);

        if (false === isset($config[self::KEY_RECORDS])) {
            return;
        }

        $this->parseRecords($config[self::KEY_RECORDS]);
    }

    /**
     * Get the built header.
     *
     * @return RowInterface
     */
    public function getHeader(): RowInterface
    {
        return $this->header;
    }

    /**
     * Get the built records.
     *
     * @return RowInterface[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * Parse header config and create header.
     *
     * @param array $header Header config data
     *
     * @throws ValidationException
     */
    private function parseHeader(array $header): void
    {
        $this->validator->validateHeader($header);

        $include = (bool)$header[self::KEY_INCLUDE];

        $this->header = $this->rowFactory->createHeader($include);

        if (false === isset($header[self::KEY_COLUMNS])) {
            $this->header->markRowRendered();
            return;
        }

        $columns = $header[self::KEY_COLUMNS];

        foreach ($columns as $name => $column) {
            $this->addValidColumnName($name);

            $this->parseColumn($this->header, $name, $column);
        }
    }

    /**
     * Parse all records.
     *
     * @param array $records Config data for all records
     *
     * @throws ParserException
     * @throws ValidationException
     */
    private function parseRecords(array $records): void
    {
        foreach ($records as $record) {
            $this->parseRecord($record);
        }
    }

    /**
     * Parse record config and create records.
     *
     * @param array $record Record config data
     *
     * @throws ParserException
     * @throws ValidationException
     */
    private function parseRecord(array $record): void
    {
        $this->validator->validateRecord($record);

        $count   = (int)$record[self::KEY_COUNT];
        $columns = $record[self::KEY_COLUMNS];

        $record = $this->rowFactory->createRecord($count);

        foreach ($columns as $name => $column) {
            $this->assertIsValidColumnName($name);

            $this->parseColumn($record, $name, $column);
        }

        $this->records[] = $record;
    }

    /**
     * Parse the column config and add a column to the provided row.
     *
     * @param RowInterface $row    Row to add a column to.
     * @param string       $name   The name of the column
     * @param array        $column The config for the column
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
                $isUnique  = (bool)($column[self::KEY_UNIQUE] ?? false);

                $row->addFakerColumn($name, $formatter, $isUnique);
                break;
        }
    }

    /**
     * Reset the state of the parser
     */
    private function reset(): void
    {
        unset($this->header);

        $this->records          = [];
        $this->validColumnNames = [];
    }

    /**
     * @param string $name Column name configured in the header section
     */
    private function addValidColumnName(string $name): void
    {
        $this->validColumnNames[$name] = $name;
    }

    /**
     * @param string $name Column name configured a record section
     *
     * @throws ParserException
     */
    private function assertIsValidColumnName(string $name): void
    {
        if (true === isset($this->validColumnNames[$name])) {
            return;
        }

        throw new ParserException(
            "Column name '$name' wasn't included in the '" . self::KEY_HEADER . "' section"
        );
    }
}