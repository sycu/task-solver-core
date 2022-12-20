<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class PassingAcceptedMultiline extends Task
{
    protected function solve(array $lines): string
    {
        return 'correct-solution' . PHP_EOL . count($lines);
    }
}
