<?php

declare(strict_types=1);

namespace FunctionalTests;

use PHPUnit\Framework\TestCase;
use Solver\Output\BufferedOutput;
use Solver\TasksLocator;
use Solver\TestsRunner;

/**
 * @covers \Solver\Task
 * @covers \Solver\TasksLocator
 * @covers \Solver\TestsRunner
 */
class SolvingTest extends TestCase
{
    /**
     * @dataProvider runDataProvider
     */
    public function testRunExecutesTestsAndPrintsOutput(string $filter, bool $solutionsOnly, string $expected): void
    {
        $testsRoot = dirname(__FILE__, 2);
        $config = require "{$testsRoot}/environment/config.php";

        $output = new BufferedOutput();
        $tasksLocator = new TasksLocator($config['namespace'], $config['code_directory']);

        $runner = new TestsRunner($output, $tasksLocator, $config['data_directory']);
        $runner->run($filter, $solutionsOnly);

        $this->assertOutputEqualsFile("{$testsRoot}/outputs/{$expected}", $output->get());
    }

    private function assertOutputEqualsFile(string $path, string $output): void
    {
        if (!file_exists($path)) {
            file_put_contents($path, $output);
            $this->markTestIncomplete("Generated output {$path}");

            return;
        }

        $this->assertSame(file_get_contents($path), $output);
    }

    public function runDataProvider(): array
    {
        return [
            'no filter, with tests' => [
                'filter' => '',
                'solutionsOnly' => false,
                'expected' => 'no-filter-with-tests.txt',
            ],
            'no filter, no tests' => [
                'filter' => '',
                'solutionsOnly' => true,
                'expected' => 'no-filter-no-tests.txt',
            ],
            'simple string filter, with tests' => [
                'filter' => 'Acc',
                'solutionsOnly' => false,
                'expected' => 'simple-string-filter-with-tests.txt',
            ],
            'simple string filter, no tests' => [
                'filter' => 'Acc',
                'solutionsOnly' => true,
                'expected' => 'simple-string-filter-no-tests.txt',
            ],
            'regexp filter, with tests' => [
                'filter' => 'Passing.+Multiline',
                'solutionsOnly' => false,
                'expected' => 'regexp-filter-with-tests.txt',
            ],
            'regexp filter, no tests' => [
                'filter' => 'Passing.+Multiline',
                'solutionsOnly' => true,
                'expected' => 'regexp-filter-no-tests.txt',
            ],
        ];
    }
}
