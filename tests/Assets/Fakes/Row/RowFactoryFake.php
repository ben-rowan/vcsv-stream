<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Assets\Fakes\Row;

use BenRowan\VCsvStream\Factory\RowFactoryInterface;
use BenRowan\VCsvStream\Row\RowInterface;

class RowFactoryFake implements RowFactoryInterface
{
    /**
     * Create a header.
     *
     * @param bool $include
     *
     * @return RowInterface
     */
    public function createHeader(bool $include): RowInterface
    {
        $header = new RowFake();
        $header->setInclude($include);

        return $header;
    }

    /**
     * Create a record.
     *
     * @param int $count
     *
     * @return RowInterface
     */
    public function createRecord(int $count): RowInterface
    {
        $record = new RowFake();
        $record->setCount($count);

        return $record;
    }
}