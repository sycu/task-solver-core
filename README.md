# Task Solver Core
PHP Framework for competitive programming

This is just a core for task solver. If you want to set up your own runtime environment, check [sycu/task-solver](https://github.com/sycu/task-solver) repository.

## Generating task

Generate **src/Tasks/AwesomeTask.php** class with namespace **My\Tasks** and data files in **tasks/AwesomeTask**:
```php
$generator = new Solver\TaskGenerator('My\Tasks', 'src/Tasks', 'tasks');

$generator->generate('AwesomeTask');
```

## Running tests

Run all tests for tasks located in **src/Tasks** matching **Task[3-9]** regexp. Namespace is **My\Tasks** and data files are stored in **tasks/AwesomeTask**:
```php
$tasksLocator = new Solver\TasksLocator('My\Tasks', 'src/Tasks');
$testsRunner = new Solver\TestsRunner(new Solver\Output\ConsoleOutput(), $tasksLocator, 'tasks');

$testsRunner->run('Task[3-9]', false);
```
