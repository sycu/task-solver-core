<?php

declare(strict_types=1);

namespace Solver\Runner\Progress;

use Solver\Output\OutputInterface;
use Solver\Task;

class ConsoleProgress implements ProgressInterface
{
    private const PROGRESS_LENGTH = 10;

    private array $tests = [];
    private array $failures = [];
    private array $solvingStartTimes = [];
    private array $solvingEndTimes = [];


    public function __construct(private readonly OutputInterface $output)
    {
    }

    public function taskStarted(Task $task): void
    {
        $this->output->write("{$task->key()}:\t");
    }

    public function taskMissingInputFile(Task $task): void
    {
        $this->output->writeln('Missing input file');
    }

    public function taskFinished(Task $task, string $solution, ?string $acceptedSolution): void
    {
        $time = $this->solvingEndTimes[$task->key()] - $this->solvingStartTimes[$task->key()];

        $this->output->write(sprintf('Solved in %.3fs: %s', $time, $this->formatOutput($solution)));
        if ($this->failures[$task->key()] ?? false) {
            $this->output->write(' but is probably wrong');
        } elseif (!$acceptedSolution) {
            $this->output->write(' but is not accepted yet');
        } elseif($solution !== $acceptedSolution) {
            $this->output->write(" but it does not match accepted solution {$this->formatOutput($acceptedSolution)}");
        }

        $this->output->writeln('');
        foreach ($this->failures[$task->key()] ?? [] as $failure) {
            $this->output->writeln("  {$failure}");
        }
    }

    public function solvingStarted(Task $task): void
    {
        $this->solvingStartTimes[$task->key()] = microtime(true);
    }

    public function solvingFinished(Task $task): void
    {
        $this->solvingEndTimes[$task->key()] = microtime(true);
    }

    public function testPassed(Task $task, int $test): void
    {
        $this->tests[$task->key()][$test] = $test;

        $this->output->write('.');
    }

    public function testFailed(Task $task, int $test, string $output, string $expected): void
    {
        $this->tests[$task->key()][$test] = $test;

        $this->output->write('F');
        $this->failures[$task->key()][$test] = sprintf(
            'Test case %d failed: expected %s got %s',
            $test,
            $this->formatOutput($expected),
            $this->formatOutput($output)
        );
    }

    public function testSkipped(Task $task, int $test): void
    {
        $this->tests[$task->key()][$test] = $test;

        $this->output->write('S');
    }

    public function allTestsFinished(Task $task): void
    {
        $this->output->write(str_repeat(' ', self::PROGRESS_LENGTH - count($this->tests[$task->key()])));
    }

    private function formatOutput(string $output): string
    {
        if (str_contains($output, PHP_EOL)) {
            return PHP_EOL . $output;
        }

        return $output;
    }
}
