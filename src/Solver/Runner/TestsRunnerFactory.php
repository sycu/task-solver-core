<?php

declare(strict_types=1);

namespace Solver\Runner;

use Solver\Output\ConsoleOutput;
use Solver\Runner\Progress\ConsoleProgress;
use Solver\TasksLocator;

class TestsRunnerFactory
{
    public static function createFromConfig(array $config, array $dependencies = []): TestsRunner
    {
        return new TestsRunner(
            $dependencies['progress'] ?? new ConsoleProgress($dependencies['output'] ?? new ConsoleOutput()),
            $dependencies['tasksLocator'] ?? new TasksLocator($config['namespace'], $config['code_directory']),
            $config['data_directory']
        );
    }
}
