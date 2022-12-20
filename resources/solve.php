<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

$filter = $argv[1] ?? '';
$solutionsOnly = ($argv[2] ?? '') === 'solutions';

$config = require 'config.php';
$tasksLocator = new Solver\TasksLocator($config['namespace'], $config['code_directory']);
$testsRunner = new Solver\TestsRunner($config['data_directory'], new Solver\ConsoleOutput());

foreach ($tasksLocator->find($filter) as $task) {
    $testsRunner->run($task, $solutionsOnly);
}
