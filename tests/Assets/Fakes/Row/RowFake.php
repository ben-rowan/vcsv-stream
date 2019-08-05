<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Assets\Fakes\Row;

use BenRowan\VCsvStream\Generator\GeneratorInterface;
use BenRowan\VCsvStream\Row\RowInterface;
use RuntimeException;

class RowFake implements RowInterface
{
    public const KEY_NAME      = 'name';
    public const KEY_VALUE     = 'value';
    public const KEY_FORMATTER = 'formatter';
    public const KEY_UNIQUE    = 'unique';

    /**
     * @var array[]
     */
    private $valueColumns = [];
    /**
     * @var array[]
     */
    private $fakerColumns = [];
    /**
     * @var array[]
     */
    private $textColumns = [];
    /**
     * @var bool|null
     */
    private $include;
    /**
     * @var int|null
     */
    private $count;

    public function addValueColumn(string $name, $value): RowInterface
    {
        $this->valueColumns[] = [
            self::KEY_NAME  => $name,
            self::KEY_VALUE => $value,
        ];

        return $this;
    }

    public function addFakerColumn(string $name, string $formatter, bool $isUnique = false): RowInterface
    {
        $this->fakerColumns[] = [
            self::KEY_NAME      => $name,
            self::KEY_FORMATTER => $formatter,
            self::KEY_UNIQUE    => $isUnique,
        ];

        return $this;
    }

    public function addColumn(string $name): RowInterface
    {
        $this->textColumns[] = [
            self::KEY_NAME => $name
        ];

        return $this;
    }

    /**
     * @return array[]
     */
    public function getValueColumns(): array
    {
        return $this->valueColumns;
    }

    /**
     * @return array[]
     */
    public function getFakerColumns(): array
    {
        return $this->fakerColumns;
    }

    /**
     * @return array[]
     */
    public function getTextColumns(): array
    {
        return $this->textColumns;
    }

    /**
     * @return bool
     */
    public function getInclude(): bool
    {
        if (null === $this->include) {
            throw new RuntimeException('No include value has been set');
        }

        return $this->include;
    }

    /**
     * @param bool $include
     */
    public function setInclude(bool $include): void
    {
        $this->include = $include;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        if (null === $this->count) {
            throw new RuntimeException('No count value has been set');
        }

        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getColumnNames(): array
    {
        throw new RuntimeException('This needs implementing');
    }

    public function hasColumnGenerator(string $name): bool
    {
        throw new RuntimeException('This needs implementing');
    }

    public function getColumnGenerator(string $name): GeneratorInterface
    {
        throw new RuntimeException('This needs implementing');
    }

    public function markRowRendered(): void
    {
        throw new RuntimeException('This needs implementing');
    }

    public function isFullyRendered(): bool
    {
        throw new RuntimeException('This needs implementing');
    }
}