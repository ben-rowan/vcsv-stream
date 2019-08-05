<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Stream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Row\Header;
use BenRowan\VCsvStream\Row\Record;
use BenRowan\VCsvStream\Stream\State;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class StateTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function iCanSetAndGetHeader(): void
    {
        $state  = $this->getClass();
        $header = new Header();

        $state->setHeader($header);

        $this->assertSame($header, $state->getHeader());
    }

    /**
     * @test
     */
    public function iCanTellWhenAHeaderIsNotSet(): void
    {
        $state = $this->getClass();

        $this->assertFalse($state->hasHeader());
    }

    /**
     * @test
     */
    public function iCanTellWhenAHeaderIsSet(): void
    {
        $state  = $this->getClass();
        $header = new Header();

        $state->setHeader($header);

        $this->assertTrue($state->hasHeader());
    }

    /**
     * @test
     *
     * @throws VCsvStreamException
     */
    public function iCanAddAndGetMultipleRecords(): void
    {
        $state     = $this->getClass();
        $recordOne = new Record(10);
        $recordTwo = new Record(10);

        $state->addRecords(
            [
                $recordOne,
                $recordTwo,
            ]
        );

        $this->assertSame($recordOne, $state->currentRecord());
        $state->nextRecord();
        $this->assertSame($recordTwo, $state->currentRecord());
    }

    /**
     * @test
     */
    public function iCanTellWhenARecordHasNotBeenAdded(): void
    {
        $state = $this->getClass();

        $this->assertFalse($state->hasRecords());
    }

    /**
     * @test
     */
    public function iCanTellWhenARecordHasBeenAdded(): void
    {
        $state     = $this->getClass();
        $recordOne = new Record(10);

        $state->addRecords(
            [
                $recordOne,
            ]
        );

        $this->assertTrue($state->hasRecords());
    }

    private function getClass(): State
    {
        return new State();
    }
}