<?php

declare(strict_types=1);

namespace Solver;

use RuntimeException;

class TaskGenerator
{
    public function generate(string $key): void
    {
        $rootPath = dirname(__FILE__, 3);
        $templatesPath = "{$rootPath}/templates";
        $dataDestination = "{$rootPath}/tasks/{$key}";

        if (is_dir($dataDestination)) {
            throw new RuntimeException('Task already exists');
        }

        mkdir($dataDestination);
        copy("{$templatesPath}/description.txt", "{$dataDestination}/description.txt");
        copy("{$templatesPath}/test1.input.txt", "{$dataDestination}/test1.input.txt");
        copy("{$templatesPath}/test1.output.txt", "{$dataDestination}/test1.output.txt");
        copy("{$templatesPath}/input.txt", "{$dataDestination}/input.txt");
        copy("{$templatesPath}/output.txt", "{$dataDestination}/output.txt");

        $taskTemplate = file_get_contents("{$templatesPath}/Task.php.template");
        $taskContent = strtr($taskTemplate, ['[KEY]' => $key]);
        file_put_contents("{$rootPath}/src/Tasks/{$key}.php", $taskContent);
    }
}
