<?php
// Part one: ~15ms
// Part two: ~15ms
// Total: ~30ms

/**
 * @return array{int, float}
 */
function solve(string $input, bool $skipOne = false, bool $skipTwo = false): array
{
	$time_start = microtime(true);
	$one = 0;
	$two = 0;

	$banks = file($input, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	// Joltage bank
	foreach ($banks as $bank) {
		if (!$skipOne) {
			$one += getMaxJoltage(str_split($bank), 2);
		}

		if (!$skipTwo) {
			$two += getMaxJoltage(str_split($bank), 12);
		}
	}

	$time = round((microtime(true) - $time_start) * 1000, 3);
	return [$one, $two, $time];
}

function getMaxJoltage(array $nums, int $length): int
{
	while (count($nums) > $length) {
		$popped = false;

		// Remove one number at a time from left to right
		for ($i = 0; $i < count($nums) - 1; $i++) {
			if ($nums[$i] < $nums[$i + 1]) {
				$popped = true;
				array_splice($nums, $i, 1);
				break;
			}
		}

		// If we never found a number to remove, remove the last one
		if (!$popped) {
			array_pop($nums);
		}
	}

	return implode($nums);
}


function solveAndTime(string $input, bool $skipOne = false, bool $skipTwo = false)
{
	[$one, $two, $time] = solve($input, $skipOne, $skipTwo);
	if (!$skipOne) {
		echo "One: " . $one . PHP_EOL;
	}

	if (!$skipTwo) {
		echo "Two: " . $two . PHP_EOL;
	}
	echo "Time: " . $time . " ms" . PHP_EOL;
}


echo "EXAMPLE" . PHP_EOL;
solveAndTime('input/example.txt', skipOne: false, skipTwo: false);

echo PHP_EOL . "INPUT" . PHP_EOL;
solveAndTime('input/input.txt', skipOne: false, skipTwo: false);
