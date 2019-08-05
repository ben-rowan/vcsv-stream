<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Parser\Validator;

use BenRowan\VCsvStream\Exceptions\Parser\ValidationException;
use BenRowan\VCsvStream\Parser\Validator\ValidatorInterface;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

abstract class AbstractValidatorTest extends AbstractTestCase
{
    abstract protected function getClass(): ValidatorInterface;
    abstract protected function getValidConfig(): array;
    abstract protected function getSection(): string;

    /**
     * @test
     *
     * @throws ValidationException
     */
    public function iReturnTrueForAValidConfig(): void
    {
        $validator = $this->getClass();

        $valid = $validator->validate($this->getValidConfig());

        $this->assertTrue($valid);
    }

    /**
     * @test
     *
     * @param string $missingKey
     *
     * @throws ValidationException
     *
     * @dataProvider missingKeyDataProvider
     */
    public function iGetAnExceptionForAMissingKey(string $missingKey): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            "You must include a '$missingKey' item in your '{$this->getSection()}' config section"
        );

        $validator = $this->getClass();

        $validator->validate($this->getConfigWithoutKey($missingKey));
    }

    abstract public function missingKeyDataProvider(): array;

    /**
     * @test
     *
     * @param string $key
     * @param        $value
     *
     * @throws ValidationException
     *
     * @dataProvider wrongTypeDataProvider
     */
    public function iGetAnExceptionForWrongType(string $key, $value): void
    {
        $this->expectException(ValidationException::class);

        $validator = $this->getClass();

        $validator->validate($this->getConfigWithSubstitution($key, $value));
    }

    abstract public function wrongTypeDataProvider(): array;

    private function getConfigWithoutKey(string $key): array
    {
        $config = $this->getValidConfig();

        unset($config[$key]);

        return $config;
    }

    private function getConfigWithSubstitution(string $key, $value): array
    {
        $config = $this->getValidConfig();

        $config[$key] = $value;

        return $config;
    }
}