<?php

declare(strict_types=1);

namespace FunctionalTests;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Solver\Generator\TaskGenerator;
use Solver\Generator\TaskGeneratorFactory;

/**
 * @covers \Solver\Generator\TaskGenerator
 * @covers \Solver\Generator\TaskGeneratorFactory
 */
class GeneratingTest extends TestCase
{
    private TaskGenerator $taskGenerator;

    protected function setUp(): void
    {
        $testsRoot = dirname(__FILE__);
        $this->removeTestFiles($testsRoot);

        $this->taskGenerator = TaskGeneratorFactory::createFromConfig([
            'namespace' => 'TestEnvironment\Generated',
            'code_directory' => "{$testsRoot}/environment/src/Generated",
            'data_directory' => "{$testsRoot}/environment/tasks",
        ]);
    }

    protected function tearDown(): void
    {
        $testsRoot = dirname(__FILE__);
        $this->removeTestFiles($testsRoot);
    }

    public function testGenerateCreatesNewTaskAndData(): void
    {
        $this->taskGenerator->generate('FooBar');

        $this->assertSameGeneratedFiles('FooBar.php', 'src/Generated/FooBar.php');
        $this->assertSameGeneratedFiles('description.txt', 'tasks/FooBar/description.txt');
        $this->assertSameGeneratedFiles('input.txt', 'tasks/FooBar/input.txt');
        $this->assertSameGeneratedFiles('output.txt', 'tasks/FooBar/output.txt');
        $this->assertSameGeneratedFiles('test1.input.txt', 'tasks/FooBar/test1.input.txt');
        $this->assertSameGeneratedFiles('test1.output.txt', 'tasks/FooBar/test1.output.txt');
    }

    public function testThrowsExceptionWhenTaskAlreadyExists(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Task FooBar already exists');

        $this->taskGenerator->generate('FooBar');
        $this->taskGenerator->generate('FooBar');
    }

    private function assertSameGeneratedFiles(string $expected, string $generated): void
    {
        $testsRoot = dirname(__FILE__);

        $generatedContent = file_get_contents("{$testsRoot}/environment/{$generated}");
        $expectedPath = "{$testsRoot}/resources/generated_files/{$expected}";
        if (!file_exists($expectedPath)) {
            file_put_contents($expectedPath, $generatedContent);
            $this->markTestIncomplete("Generated file {$expectedPath}");

            return;
        }

        $this->assertSame(file_get_contents($expectedPath), $generatedContent);
    }

    private function removeTestFiles(string $root): void
    {
        $paths = [
            "{$root}/environment/src/Generated/FooBar.php",
            "{$root}/environment/tasks/FooBar/description.txt",
            "{$root}/environment/tasks/FooBar/input.txt",
            "{$root}/environment/tasks/FooBar/output.txt",
            "{$root}/environment/tasks/FooBar/test1.input.txt",
            "{$root}/environment/tasks/FooBar/test1.output.txt",
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $dir = "{$root}/environment/tasks/FooBar/";
        if (file_exists($dir)) {
            rmdir($dir);
        }
    }
}
