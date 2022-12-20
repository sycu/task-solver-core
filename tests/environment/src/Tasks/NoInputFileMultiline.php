<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class NoInputFileMultiline extends Task
{
    protected function solve(array $lines): string
    {
        return 'no-input-file' . PHP_EOL . count($lines);
    }
}
