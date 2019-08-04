<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generator\GeneratorFactory;
use BenRowan\VCsvStream\Row\RowInterface;
use BenRowan\VCsvStream\Stream;

class VCsvStream
{
    /**
     * @var Stream\File
     */
    private static $file;

    /**
     * @var Stream\Config
     */
    private static $config;

    /**
     * @var Stream\State
     */
    private static $state;

    /**
     * Initialise VCsvStream.
     *
     * @param array $config All VCsvStream configuration values.
     *
     * @throws VCsvStreamException
     */
    public static function setup(array $config = []): void
    {
        self::$file   = new Stream\File();
        self::$config = new Stream\Config($config);
        self::$state  = new Stream\State();

        GeneratorFactory::setup();

        VCsvStreamWrapper::setup();
    }

    /**
     * Gets the current representation of the file.
     *
     * @return Stream\File
     */
    public static function getFile(): Stream\File
    {
        return self::$file;
    }

    /**
     * Gets the current configuration.
     *
     * @return Stream\Config
     */
    public static function getConfig(): Stream\Config
    {
        return self::$config;
    }

    /**
     * Gets the current stream state.
     *
     * @return Stream\State
     */
    public static function getState(): Stream\State
    {
        return self::$state;
    }

    /**
     * Set the header to be rendered.
     *
     * @param RowInterface $header
     */
    public static function setHeader(RowInterface $header): void
    {
        self::$state->setHeader($header);
    }

    /**
     * Add a record to be rendered.
     *
     * @param RowInterface $record
     */
    public static function addRecord(RowInterface $record): void
    {
        self::$state->addRecord($record);
    }

    /**
     * Add a set of records to be rendered.
     *
     * @param RowInterface[] $records
     */
    public static function addRecords(array $records): void
    {
        self::$state->addRecords($records);
    }
}