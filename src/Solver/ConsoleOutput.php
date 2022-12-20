<?php

declare(strict_types=1);

namespace Solver;

class ConsoleOutput
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
