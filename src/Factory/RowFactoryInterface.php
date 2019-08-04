<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Factory;

use BenRowan\VCsvStream\Row\RowInterface;

interface RowFactoryInterface
{
    /**
     * Create a header.
     *
     * @param bool $include
     *
     * @return RowInterface
     */
    public function createHeader(bool $include): RowInterface;

    /**
     * Create a record.
     *
     * @param int $count
     *
     * @return RowInterface
     */
    public function createRecord(int $count): RowInterface;
}