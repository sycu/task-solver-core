<?php

declare(strict_types=1);

namespace UnitTests\Solver\Output;

use PHPUnit\Framework\TestCase;
use Solver\Output\ConsoleOutput;

/**
 * @covers \Solver\Output\ConsoleOutput
 */
class ConsoleOutputTest extends TestCase
{
    private ConsoleOutput $output;

    protected function setUp(): void
    {
        $this->output = new ConsoleOutput();
    }

    public function testWritelnStoresOutputInBuffer(): void
    {
        $this->expectOutputString("Foo\n");

        $this->output->writeln('Foo');
    }

    public function testWriteStoresOutputInBuffer(): void
    {
        $this->expectOutputString('Foo');

        $this->output->write('Foo');
    }

    public function testWritelnConcatenatesOutputOnMultipleCalls(): void
    {
        $this->expectOutputString("Foo\nBar\n");

        $this->output->writeln('Foo');
        $this->output->writeln('Bar');
    }

    public function testWriteConcatenatesOutputOnMultipleCalls(): void
    {
        $this->expectOutputString('FooBar');

        $this->output->write('Foo');
        $this->output->write('Bar');
    }
}
