# Task Solver
Solutions for Advent Of Code 2022

## Setup
```shell
composer install
```

## Run tests and get solutions
You can filter tasks by providing **[FILTER]** argument (regexp)
```shell
php solve.php [FILTER] [OPTIONS]
```

Options:
- **solutions** - skip tests, just calculate and return solutions. For now only works after FILTER argument, but you can pass an empty string for workaround.

Examples:
```shell
php solve.php
php solve.php Day5
php solve.php "Day[0-9]{1,2}B"
php solve.php "Day[3-6]B" solutions
```

Example output:
```
$ php solve.php "Day([5-9]|10|11)"

Day5A:	.         Solved in 0.000s: FJSRQCFTN
Day5B:	.         Solved in 0.000s: CJVLJQPHS
Day6A:	.....     Solved in 0.001s: 1766
Day6B:	.....     Solved in 0.001s: 2383
Day7A:	.         Solved in 0.000s: 1428881
Day7B:	.         Solved in 0.000s: 10475598
Day8A:	.         Solved in 0.006s: 1809
Day8B:	.         Solved in 0.007s: 479400
Day9A:	.         Solved in 0.003s: 6181
Day9B:	..        Solved in 0.009s: 2386
Day10A:	.         Solved in 0.000s: 13480
Day10B:	.         Solved in 0.000s:
####..##....##.###...##...##..####.#..#.
#....#..#....#.#..#.#..#.#..#.#....#.#..
###..#.......#.###..#....#....###..##...
#....#.##....#.#..#.#.##.#....#....#.#..
#....#..#.#..#.#..#.#..#.#..#.#....#.#..
####..###..##..###...###..##..#....#..#.
Day11A:	.         Solved in 0.002s: 108240
Day11B:	.         Solved in 0.954s: 25712998901
```

## Generate new task
It will create task data in **tasks/** directory, which you should fill out. Actual code template will be located in **src/Tasks/**


```shell
php generate.php KEY
```

Examples:
```shell
php generate.php Day12A
```

Files to fill (assuming Day12A is a task key):

| File                          | Description                                                                                             | Required |
|-------------------------------|---------------------------------------------------------------------------------------------------------|----------|
| src/Tasks/Day12A.php          | Your code for the task. Just implement "**solve**" method for given array of input lines.               | Yes      |
| tasks/Day12A/description.txt  | Task description. It is not used anywhere, just for convenience.                                        | No       |
| tasks/Day12A/input.txt        | Input for the actual problem.                                                                           | Yes      |
| tasks/Day12A/output.txt       | Working solution, that you have already submitted. It is used to validate your code during refactoring. | No       |
| tasks/Day12A/test1.input.txt  | Input for a test case. You can have multiple test cases, just add test2.input.txt and so on.            | No       |
| tasks/Day12A/test1.output.txt | Output for a test case. Each test input should have a matching output file to be executed.              | No       |
