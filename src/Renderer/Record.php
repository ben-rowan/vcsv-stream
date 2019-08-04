<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderer;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Stream;
use BenRowan\VCsvStream\Row\Header as HeaderRow;
use BenRowan\VCsvStream\Row\Record as RecordRow;

class Record extends AbstractRowRenderer
{
    /**
     * Renders the current record data as a string representing a CSV row.
     *
     * Hierarchy for generators:
     *
     *  - (1st) Record generator
     *  - (2nd) Header generator
     *
     * @param Stream\Config $config
     * @param Stream\State $streamState
     *
     * @return string
     *
     * @throws VCsvStreamException
     */
    public function render(Stream\Config $config, Stream\State $streamState): string
    {
        if (! $streamState->hasRecords()) {
            return '';
        }

        /** @var RecordRow $record */
        $record = $streamState->currentRecord();

        /** @var HeaderRow $header */
        $header = $streamState->getHeader();

        $row = [];

        foreach ($header->getColumnNames() as $columnName) {

            if ($record->hasColumnGenerator($columnName)) {
                $row[] = $record->getColumnGenerator($columnName)->generate();
                continue;
            }

            if ($header->hasColumnGenerator($columnName)) {
                $row[] = $header->getColumnGenerator($columnName)->generate();
                continue;
            }

            throw new VCsvStreamException("No generator found for column '$columnName'");
        }

        $renderedRow = $this->renderRow($config, $row);

        $record->markRowRendered();

        if ($record->isFullyRendered()) {
            $streamState->nextRecord();
        }

        return $renderedRow;
    }
}