<?php

declare(strict_types=1);

namespace Solver\Output;

class ConsoleOutput implements OutputInterface
{
    public function writeln(string $string): void
    {
        $this->write($string . PHP_EOL);
    }

    public function write(string $string): void
    {
        echo($string);
    }
}
