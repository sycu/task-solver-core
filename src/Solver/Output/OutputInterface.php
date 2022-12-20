<?php

declare(strict_types=1);

namespace Solver\Output;

interface OutputInterface
{
    public function writeln(string $string): void;

    public function write(string $string): void;
}
