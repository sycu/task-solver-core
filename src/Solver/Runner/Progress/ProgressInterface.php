<?php

declare(strict_types=1);

namespace Solver\Runner\Progress;

use Solver\Task;

interface ProgressInterface
{
    public function taskStarted(Task $task): void;
    public function taskMissingInputFile(Task $task): void;
    public function taskFinished(Task $task, string $solution, ?string $acceptedSolution): void;

    public function solvingStarted(Task $task): void;
    public function solvingFinished(Task $task): void;

    public function testPassed(Task $task, int $test): void;
    public function testFailed(Task $task, int $test, string $output, string $expected): void;
    public function testSkipped(Task $task, int $test): void;

    public function allTestsFinished(Task $task): void;
}
