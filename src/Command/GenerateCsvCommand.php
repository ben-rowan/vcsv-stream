<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCsvCommand extends Command
{
    public const NAME = 'generate:csv';

    public const ARG_CONFIG_PATH = 'config_path';
    public const ARG_OUTPUT_PATH = 'output_path';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Generate a CSV fixture')
            ->addArgument(
                self::ARG_CONFIG_PATH,
                InputArgument::REQUIRED,
                'The YAML config for your CSV'
            )
            ->addArgument(
                self::ARG_OUTPUT_PATH,
                InputArgument::REQUIRED,
                "The generated CSV fixture"
            )
            ->setHelp(
                'This command takes a YAML config file and generates a CSV fixture based on your requirements'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = (string)$input->getArgument(self::ARG_CONFIG_PATH);
        $outputPath = (string)$input->getArgument(self::ARG_OUTPUT_PATH);
    }
}