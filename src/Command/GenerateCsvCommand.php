<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Command;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Factory\Parser\ConfigParserFactory;
use BenRowan\VCsvStream\Parser\File\YamlParser;
use BenRowan\VCsvStream\VCsvStream;
use SplFileObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCsvCommand extends Command
{
    public const NAME = 'generate:csv';

    public const ARG_CONFIG_PATH = 'config_path';

    private $yamlParser;

    private $configParser;

    /**
     * GenerateCsvCommand constructor.
     *
     * @throws VCsvStreamException
     */
    public function __construct()
    {
        parent::__construct();

        VCsvStream::setup();

        $this->yamlParser   = new YamlParser();
        $this->configParser = (new ConfigParserFactory())->create();
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Generate a CSV fixture')
            ->addArgument(
                self::ARG_CONFIG_PATH,
                InputArgument::REQUIRED,
                'The config for your CSV'
            )
            ->setHelp(
                'This command takes a YAML config file and generates a CSV fixture based on your requirements'
            );
    }

    /**
     * Generate and output a CSV file based on the provided config.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws ParserException
     * @throws ValidationException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = (string)$input->getArgument(self::ARG_CONFIG_PATH);

        VCsvStream::loadYamlConfig($configPath);

        // Generate and output one line at a time to reduce memory consumption

        $vCsv = new SplFileObject('vcsv://fixture.csv');

        while (false === $vCsv->eof()) {
            $output->write($vCsv->fgets());
        }
    }
}