<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generator;

interface GeneratorInterface
{
    public function generate(): string;
}