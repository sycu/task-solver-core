<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

$filter = $argv[1] ?? '';
$solutionsOnly = ($argv[2] ?? '') === 'solutions';

$tasksLocator = new Solver\TasksLocator();
$testsRunner = new Solver\TestsRunner(new Solver\ConsoleOutput());

foreach ($tasksLocator->find($filter) as $task) {
    $testsRunner->run($task, $solutionsOnly);
}
