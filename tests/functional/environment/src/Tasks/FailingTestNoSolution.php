<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class FailingTestNoSolution extends Task
{
    protected function solve(array $lines): string
    {
        return 'failing-test-no-solution-' . count($lines);
    }
}
