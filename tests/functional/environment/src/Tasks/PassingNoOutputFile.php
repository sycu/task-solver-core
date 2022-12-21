<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class PassingNoOutputFile extends Task
{
    protected function solve(array $lines): string
    {
        return 'passing-no-output-file-' . count($lines);
    }
}
