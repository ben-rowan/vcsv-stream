<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderer;

use BenRowan\VCsvStream\Stream;

interface RowRendererInterface
{
    public function render(Stream\Config $config, Stream\State $streamState): string;
}