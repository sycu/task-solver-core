<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class FailingTestWithSolution extends Task
{
    protected function solve(array $lines): string
    {
        return 'correct-solution-' . count($lines);
    }
}
