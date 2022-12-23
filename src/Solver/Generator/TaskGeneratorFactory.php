<?php

declare(strict_types=1);

namespace Solver\Generator;

class TaskGeneratorFactory
{
    public static function createFromConfig(array $config): TaskGenerator
    {
        return new TaskGenerator($config['namespace'], $config['code_directory'], $config['data_directory']);
    }
}
