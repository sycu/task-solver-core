<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class FailingTestWithSolutionMultiline extends Task
{
    protected function solve(array $lines): string
    {
        return 'correct-solution' . PHP_EOL . count($lines);
    }
}
