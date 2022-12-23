<?php

declare(strict_types=1);

namespace Solver\Generator;

use RuntimeException;

class TaskGenerator
{
    public function __construct(
        private readonly string $namespace,
        private readonly string $codeDirectory,
        private readonly string $dataDirectory
    ) {
    }

    public function generate(string $key): void
    {
        $rootPath = dirname(__FILE__, 4);
        $templatesPath = "{$rootPath}/templates";
        $dataDestination = "{$this->dataDirectory}/{$key}";

        if (is_dir($dataDestination)) {
            throw new RuntimeException("Task {$key} already exists");
        }

        mkdir($dataDestination);
        copy("{$templatesPath}/description.txt", "{$dataDestination}/description.txt");
        copy("{$templatesPath}/test1.input.txt", "{$dataDestination}/test1.input.txt");
        copy("{$templatesPath}/test1.output.txt", "{$dataDestination}/test1.output.txt");
        copy("{$templatesPath}/input.txt", "{$dataDestination}/input.txt");
        copy("{$templatesPath}/output.txt", "{$dataDestination}/output.txt");

        $taskTemplate = file_get_contents("{$templatesPath}/Task.php.template");
        $taskContent = strtr($taskTemplate, ['[KEY]' => $key, '[NAMESPACE]' => $this->namespace]);
        file_put_contents("{$this->codeDirectory}/{$key}.php", $taskContent);
    }
}
