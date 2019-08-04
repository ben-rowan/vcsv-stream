<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Factory;

use BenRowan\VCsvStream\Row\Header;
use BenRowan\VCsvStream\Row\NoHeader;
use BenRowan\VCsvStream\Row\Record;
use BenRowan\VCsvStream\Row\RowInterface;

class RowFactory implements RowFactoryInterface
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
        if (true === $include) {
            return new Header();
        }

        return new NoHeader();
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
        return new Record($count);
    }
}