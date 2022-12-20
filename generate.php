<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

$output = new Solver\ConsoleOutput();

$key = $argv[1] ?? null;
if (!$key) {
    $output->writeln('Key is required');
    exit(1);
}

$generator = new Solver\TaskGenerator();

try {
    $generator->generate($key);
} catch (RuntimeException $exception) {
    $output->writeln($exception->getMessage());
    exit(1);
}
