<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCsvCommand extends Command
{
    public const NAME = 'generate:csv';

    public const ARG_CONFIG_FILE = 'config_file';
    public const ARG_OUTPUT_FILE = 'output_file';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Generate a CSV fixture')
            ->addArgument(
                self::ARG_CONFIG_FILE,
                InputArgument::REQUIRED,
                'The YAML config for your CSV'
            )
            ->addArgument(
                self::ARG_OUTPUT_FILE,
                InputArgument::REQUIRED,
                "The generated CSV fixture"
            )
            ->setHelp(
                'This command takes a YAML config file and generates a CSV fixture based on your requirements'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = (string)$input->getArgument(self::ARG_CONFIG_FILE);
        $outputFile = (string)$input->getArgument(self::ARG_OUTPUT_FILE);
    }
}