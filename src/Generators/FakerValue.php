<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

use Faker;

final class FakerValue implements GeneratorInterface
{
    /**
     * @var Faker\Generator
     */
    private $faker;

    /**
     * @var string
     */
    private $formatter;

    public function __construct(Faker\Generator $faker, string $formatter, bool $isUnique = false)
    {
        $this->faker    = $isUnique ? $faker->unique() : $faker;
        $this->formatter = $formatter;
    }

    public function generate(): string
    {
        return (string) $this->faker->{$this->formatter};
    }
}