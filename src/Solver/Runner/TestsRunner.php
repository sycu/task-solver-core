<?php

declare(strict_types=1);

namespace Solver\Runner;

use Solver\Runner\Progress\ProgressInterface;
use Solver\Task;
use Solver\TasksLocator;

class TestsRunner
{
    private const INPUT_PATTERN = '%s/input.txt';
    private const OUTPUT_PATTERN = '%s/output.txt';
    private const TEST_INPUT_PATTERN = '%s/test%d.input.txt';
    private const TEST_OUTPUT_PATTERN = '%s/test%d.output.txt';

    public function __construct(
        private readonly ProgressInterface $progress,
        private readonly TasksLocator $tasksLocator,
        private readonly string $dataDirectory
    ) {
    }

    public function run(string $filter, bool $solutionsOnly): void
    {
        foreach ($this->tasksLocator->find($filter) as $task) {
            $this->runForTask($task, $solutionsOnly);
        }
    }

    private function runForTask(Task $task, bool $solutionOnly): void
    {
        $this->progress->taskStarted($task);
        for ($number = 1; $this->testExists($task, $number); $number++) {
            if ($solutionOnly || $task->skipTests()) {
                $this->progress->testSkipped($task, $number);
                continue;
            }

            $taskDataDirectory = $this->taskDataDirectory($task);
            $output = $task->solveForInputFile(sprintf(self::TEST_INPUT_PATTERN, $taskDataDirectory, $number));
            $expected = rtrim(file_get_contents(sprintf(self::TEST_OUTPUT_PATTERN, $taskDataDirectory, $number)));

            if ($output === $expected) {
                $this->progress->testPassed($task, $number);
            } else {
                $this->progress->testFailed($task, $number, $output, $expected);
            }
        }

        $this->progress->allTestsFinished($task);

        $taskDataDirectory = $this->taskDataDirectory($task);
        if (!file_exists(sprintf(self::INPUT_PATTERN, $taskDataDirectory))) {
            $this->progress->taskMissingInputFile($task);

            return;
        }

        $this->progress->solvingStarted($task);
        $solution = $task->solveForInputFile(sprintf(self::INPUT_PATTERN, $taskDataDirectory));
        $this->progress->solvingFinished($task);

        $this->progress->taskFinished($task, $solution, $this->acceptedSolution($task));
    }

    private function taskDataDirectory(Task $task): string
    {
        return "{$this->dataDirectory}/{$task->key()}";
    }

    private function testExists(Task $task, int $number): bool
    {
        $taskDataDirectory = $this->taskDataDirectory($task);

        return file_exists(sprintf(self::TEST_INPUT_PATTERN, $taskDataDirectory, $number))
            && file_exists(sprintf(self::TEST_OUTPUT_PATTERN, $taskDataDirectory, $number));
    }

    private function acceptedSolution(Task $task): ?string
    {
        $acceptedSolutionPath = sprintf(self::OUTPUT_PATTERN, $this->taskDataDirectory($task));
        if (!file_exists($acceptedSolutionPath)) {
            return null;
        }

        return rtrim(file_get_contents($acceptedSolutionPath));
    }
}
