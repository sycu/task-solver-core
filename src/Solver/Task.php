<?php

declare(strict_types=1);

namespace Solver;

use ReflectionClass;

abstract class Task
{
    protected const SOLVER_SKIP_TESTS = false;

    /**
     * @param string[] $lines
     */
    abstract protected function solve(array $lines): string;

    public function solveForInputFile(string $inputFile): string
    {
        return $this->solve(explode(PHP_EOL, rtrim(file_get_contents($inputFile))));
    }

    public function key(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function skipTests(): bool
    {
        return static::SOLVER_SKIP_TESTS;
    }
}
