<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Factory\Parser\ConfigParserFactory;
use BenRowan\VCsvStream\Generator\GeneratorFactory;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\File\YamlParser;
use BenRowan\VCsvStream\Row\RowInterface;
use BenRowan\VCsvStream\Stream\Config;
use BenRowan\VCsvStream\Stream\File;
use BenRowan\VCsvStream\Stream\State;

class VCsvStream
{
    /**
     * @var File
     */
    private static $file;
    /**
     * @var Config
     */
    private static $config;
    /**
     * @var State
     */
    private static $state;
    /**
     * @var YamlParser
     */
    private static $yamlParser;
    /**
     * @var ConfigParser
     */
    private static $configParser;

    /**
     * Initialise VCsvStream.
     *
     * @param array $config All VCsvStream configuration values.
     *
     * @throws VCsvStreamException
     */
    public static function setup(array $config = []): void
    {
        self::$file         = new File();
        self::$config       = new Config($config);
        self::$state        = new State();
        self::$yamlParser   = new YamlParser();
        self::$configParser = (new ConfigParserFactory())->create();

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
     * Load a Yaml CSV config.
     *
     * @param string $configPath
     *
     * @throws ParserException
     * @throws ValidationException
     */
    public static function loadYamlConfig(string $configPath): void
    {
        $config = self::$yamlParser->parse($configPath);

        self::$configParser->parse($config);

        self::setHeader(self::$configParser->getHeader());
        self::addRecords(self::$configParser->getRecords());
    }

    /**
     * Set the header to be rendered.
     *
     * @param RowInterface $header
     */
    private static function setHeader(RowInterface $header): void
    {
        self::$state->setHeader($header);
    }

    /**
     * Add a set of records to be rendered.
     *
     * @param RowInterface[] $records
     */
    private static function addRecords(array $records): void
    {
        self::$state->addRecords($records);
    }
}