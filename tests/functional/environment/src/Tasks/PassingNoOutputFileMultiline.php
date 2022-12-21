<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class PassingNoOutputFileMultiline extends Task
{
    protected function solve(array $lines): string
    {
        return 'passing-no-output-file' . PHP_EOL . count($lines);
    }
}
