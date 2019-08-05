<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\ConfigParser;
use BenRowan\VCsvStream\Parser\Validator\RootValidator;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class RootValidatorTest extends AbstractTestCase
{
    /**
     * @test
     *
     * @throws ValidationException
     */
    public function iReturnTrueForAValidConfig(): void
    {
        $validator = $this->getClass();

        $valid = $validator->validate(
            [
                ConfigParser::KEY_HEADER  => [],
                ConfigParser::KEY_RECORDS => [],
            ]
        );

        $this->assertTrue($valid);
    }

    /**
     * @test
     *
     * @throws ValidationException
     */
    public function iGetAnExceptionForAMissingHeaderKey(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            "You must include a '" . ConfigParser::KEY_HEADER . "' item in your '"
            . RootValidator::SECTION . "' config section"
        );

        $validator = $this->getClass();

        $validator->validate(
            [
                ConfigParser::KEY_RECORDS => [],
            ]
        );
    }

    /**
     * @test
     *
     * @throws ValidationException
     */
    public function iGetAnExceptionIfHeaderHasTheWrongType(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            "'" . ConfigParser::KEY_HEADER . "' must not have a scalar value"
        );

        $validator = $this->getClass();

        $validator->validate(
            [
                ConfigParser::KEY_HEADER  => true,
                ConfigParser::KEY_RECORDS => [],
            ]
        );
    }

    /**
     * @test
     *
     * @throws ValidationException
     */
    public function iGetAnExceptionForAMissingRecordsKey(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            "You must include a '" . ConfigParser::KEY_RECORDS . "' item in your '"
            . RootValidator::SECTION . "' config section"
        );

        $validator = $this->getClass();

        $validator->validate(
            [
                ConfigParser::KEY_HEADER  => [],
            ]
        );
    }

    /**
     * @test
     *
     * @throws ValidationException
     */
    public function iGetAnExceptionIfRecordsHasTheWrongType(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            "'" . ConfigParser::KEY_RECORDS . "' must not have a scalar value"
        );

        $validator = $this->getClass();

        $validator->validate(
            [
                ConfigParser::KEY_HEADER  => [],
                ConfigParser::KEY_RECORDS => true,
            ]
        );
    }

    private function getClass(): RootValidator
    {
        return new RootValidator();
    }
}