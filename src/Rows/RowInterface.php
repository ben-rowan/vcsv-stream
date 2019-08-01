<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

use BenRowan\VCsvStream\Generators\GeneratorInterface;

interface RowInterface
{
    /**
     * @param string $name The name for this column
     * @param mixed $value The value used in this column
     *
     * @return RowInterface
     */
    public function addValueColumn(string $name, $value): RowInterface;

    /**
     * @param string $name The name for this column
     * @param string $formatter The Faker formatter to be used for this column (see: https://github.com/fzaninotto/Faker#formatters)
     * @param bool $isUnique When set to true no 2 rows will have the same value for this column
     *
     * @return RowInterface
     */
    public function addFakerColumn(string $name, string $formatter, bool $isUnique = false): RowInterface;

    /**
     * @param string $name The name for this column
     *
     * @return RowInterface
     */
    public function addColumn(string $name): RowInterface;

    public function getColumnNames(): array;

    public function hasColumnGenerator(string $name): bool;

    public function getColumnGenerator(string $name): GeneratorInterface;

    public function markRowRendered(): void;

    public function isFullyRendered(): bool;
}