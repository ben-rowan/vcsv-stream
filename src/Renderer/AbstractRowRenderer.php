<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderer;

use BenRowan\VCsvStream\Stream;

abstract class AbstractRowRenderer implements RowRendererInterface
{
    /**
     * Handles the transformation of column data into a CSV row string.
     *
     * @param Stream\Config $config
     * @param array $columns
     *
     * @return string
     */
    protected function renderRow(Stream\Config $config, array $columns): string
    {
        $row = implode(
            $config->getDelimiter(),
            array_map(
                function ($value) use ($config) {
                    if (is_numeric($value)) {
                        return (string) $value;
                    }

                    return $config->getEnclosure() . $value . $config->getEnclosure();
                },
                $columns
            )
        );

        return $row . $config->getNewline();
    }
}