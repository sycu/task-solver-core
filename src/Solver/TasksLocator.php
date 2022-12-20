<?php

declare(strict_types=1);

namespace Solver;

class TasksLocator
{
    /**
     * @return Task[]
     */
    public function find(string $filter): array
    {
        $files = scandir(dirname(__FILE__, 2) . '/Tasks');
        natsort($files);

        $tasks = [];
        foreach ($files as $file) {
            if (preg_match("/^(.*{$filter}.*)\.php$/", $file, $matches)) {
                $tasks[] = new ('\\Tasks\\' . $matches[1])();
            }
        }

        return $tasks;
    }
}
