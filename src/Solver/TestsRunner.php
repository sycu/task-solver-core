<?php

declare(strict_types=1);

namespace Solver;

use Solver\Output\OutputInterface;

class TestsRunner
{
    private const PROGRESS_LENGTH = 10;
    private const INPUT_PATTERN = '%s/input.txt';
    private const OUTPUT_PATTERN = '%s/output.txt';
    private const TEST_INPUT_PATTERN = '%s/test%d.input.txt';
    private const TEST_OUTPUT_PATTERN = '%s/test%d.output.txt';

    public function __construct(
        private readonly OutputInterface $output,
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
        $failures = $this->runTestsAndGetFailures($task, $solutionOnly);
        $this->printSolutionAndFailures($task, $failures);
    }

    /**
     * @return string[]
     */
    private function runTestsAndGetFailures(Task $task, bool $solutionOnly): array
    {
        $this->output->write("{$task->key()}:\t");
        $failures = [];
        for ($number = 1; $this->testExists($task, $number); $number++) {
            if ($solutionOnly || $task->skipTests()) {
                $this->output->write('S');
                continue;
            }

            $taskDataDirectory = $this->taskDataDirectory($task);
            $output = $task->solveForInputFile(sprintf(self::TEST_INPUT_PATTERN, $taskDataDirectory, $number));
            $expected = rtrim(file_get_contents(sprintf(self::TEST_OUTPUT_PATTERN, $taskDataDirectory, $number)));

            if ($output === $expected) {
                $this->output->write('.');
            } else {
                $this->output->write('F');
                $failures[] = sprintf(
                    'Test case %d failed: expected %s got %s',
                    $number,
                    $this->formatOutput($expected),
                    $this->formatOutput($output)
                );
            }
        }

        $this->output->write(str_repeat(' ', self::PROGRESS_LENGTH - $number + 1));

        return $failures;
    }

    /**
     * @param string[] $failures
     */
    private function printSolutionAndFailures(Task $task, array $failures): void
    {
        $taskDataDirectory = $this->taskDataDirectory($task);
        if (!file_exists(sprintf(self::INPUT_PATTERN, $taskDataDirectory))) {
            $this->output->writeln('Missing input file');

            return;
        }

        $startTime = microtime(true);
        $solution = $task->solveForInputFile(sprintf(self::INPUT_PATTERN, $taskDataDirectory));
        $solutionTime = microtime(true) - $startTime;
        $acceptedSolution = $this->acceptedSolution($task);

        $this->output->write(sprintf('Solved in %.3fs: %s', $solutionTime, $this->formatOutput($solution)));
        if ($failures) {
            $this->output->write(' but is probably wrong');
        } elseif (!$acceptedSolution) {
            $this->output->write(' but is not accepted yet');
        } elseif($solution !== $acceptedSolution) {
            $this->output->write(" but it does not match accepted solution {$this->formatOutput($acceptedSolution)}");
        }

        $this->output->writeln('');
        foreach ($failures as $failure) {
            $this->output->writeln("  {$failure}");
        }
    }

    private function formatOutput(string $output): string
    {
        if (str_contains($output, PHP_EOL)) {
            return PHP_EOL . $output;
        }

        return $output;
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
