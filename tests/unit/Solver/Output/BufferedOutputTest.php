<?php

declare(strict_types=1);

namespace UnitTests\Solver\Output;

use PHPUnit\Framework\TestCase;
use Solver\Output\BufferedOutput;

/**
 * @covers \Solver\Output\BufferedOutput
 */
class BufferedOutputTest extends TestCase
{
    private BufferedOutput $output;

    protected function setUp(): void
    {
        $this->output = new BufferedOutput();
    }

    public function testWritelnStoresOutputInBuffer(): void
    {
        $this->output->writeln('Foo');

        $this->assertSame("Foo\n", $this->output->get());
    }

    public function testWriteStoresOutputInBuffer(): void
    {
        $this->output->write('Foo');

        $this->assertSame('Foo', $this->output->get());
    }

    public function testWritelnConcatenatesOutputOnMultipleCalls(): void
    {
        $this->output->writeln('Foo');
        $this->output->writeln('Bar');

        $this->assertSame("Foo\nBar\n", $this->output->get());
    }

    public function testWriteConcatenatesOutputOnMultipleCalls(): void
    {
        $this->output->write('Foo');
        $this->output->write('Bar');

        $this->assertSame('FooBar', $this->output->get());
    }
}
