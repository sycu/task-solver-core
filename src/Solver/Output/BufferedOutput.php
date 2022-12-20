<?php

declare(strict_types=1);

namespace Solver\Output;

class BufferedOutput implements OutputInterface
{
    private string $buffer = '';

    public function writeln(string $string): void
    {
        $this->write($string . PHP_EOL);
    }

    public function write(string $string): void
    {
        $this->buffer .= $string;
    }

    public function get(): string
    {
        return $this->buffer;
    }
}
