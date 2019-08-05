<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Parser\File;

use BenRowan\VCsvStream\Exceptions\Parser\ParserException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlParser
{
    /**
     * @param string $configPath
     *
     * @return array
     *
     * @throws ParserException
     */
    public function parse(string $configPath): array
    {
        $this->assertFileIsReadable($configPath);

        try {
            $config = Yaml::parseFile($configPath);

            return $config;
        } catch (ParseException $e) {
            throw new ParserException(
                "Unable to parse CSV config '$configPath': " . $e->getMessage()
            );
        }
    }

    /**
     * @param string $configPath
     *
     * @throws ParserException
     */
    private function assertFileIsReadable(string $configPath): void
    {
        if (true === file_exists($configPath) && true === is_readable($configPath)) {
            return;
        }

        throw new ParserException("Unable to read config file '$configPath'");
    }
}