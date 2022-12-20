<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class NoInputFile extends Task
{
    protected function solve(array $lines): string
    {
        return 'no-input-file-' . count($lines);
    }
}
