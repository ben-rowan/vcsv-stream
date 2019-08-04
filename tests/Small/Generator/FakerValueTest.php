<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Generator;

use BenRowan\VCsvStream\Generator\FakerValue;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;
use Faker;
use OverflowException;

class FakerValueTest extends AbstractTestCase
{
    private $faker;

    public function setUp(): void
    {
        $this->faker = Faker\Factory::create();
        $this->faker->seed(1);
    }

    /**
     * @test
     *
     * @param string $property
     *
     * @dataProvider iCanGenerateValuesDataProvider
     */
    public function iCanGenerateValues(string $property): void
    {
        $fakerValue = new FakerValue($this->faker, $property);

        $this->assertNotEmpty($fakerValue->generate());
    }

    public function iCanGenerateValuesDataProvider(): array
    {
        return [
            ['text'],
            ['randomNumber'],
            ['randomFloat'],
            ['email']
        ];
    }

    /**
     * @test
     */
    public function iCanGenerateUniqueValues(): void
    {
        // Faker throws this when it runs out of unique values.
        $this->expectException(OverflowException::class);

        // Can only return digits 0-9
        $fakerValue = new FakerValue($this->faker, 'randomDigitNotNull', true);

        while (true) {
            $fakerValue->generate();
        }
    }
}