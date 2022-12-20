<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class PassingNotAccepted extends Task
{
    protected function solve(array $lines): string
    {
        return 'passing-not-accepted-' . count($lines);
    }
}
