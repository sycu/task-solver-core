<?php

declare(strict_types=1);

namespace TestEnvironment\Tasks;

use Solver\Task;

class PassingNotAcceptedMultiline extends Task
{
    protected function solve(array $lines): string
    {
        return 'passing-not-accepted' . PHP_EOL . count($lines);
    }
}
