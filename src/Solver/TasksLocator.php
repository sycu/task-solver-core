<?php

declare(strict_types=1);

namespace Solver;

class TasksLocator
{
    public function __construct(private readonly string $namespace, private readonly string $directory)
    {
    }

    /**
     * @return Task[]
     */
    public function find(string $filter): array
    {
        $files = scandir($this->directory);
        natsort($files);

        $tasks = [];
        foreach ($files as $file) {
            if (preg_match("/^(.*{$filter}.*)\.php$/", $file, $matches)) {
                $class = "{$this->namespace}\\{$matches[1]}";
                $tasks[] = new $class();
            }
        }

        return $tasks;
    }
}
