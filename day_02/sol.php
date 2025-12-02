<?php
// Decently clean and elegant, didn't bother optimizing the outer for
// I imagine we can skip quite a few checks for larger inputs
// Part 1: ~600ms
// Part 2: ~1500ms

/**
 * Don't you love PHPdocs?
 *
 * @return array{int, int, float}
 */
function solve(string $input, bool $skipOne = false, bool $skipTwo = false): array
{
	$time_start = microtime(true);
	$one = 0;
	$two = 0;

	$line = file($input, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$ids = explode(',', $line[0]);

	foreach ($ids as $id) {
		[$left, $right] = explode('-', $id);

		for ($i = $left; $i <= $right; $i++) {
			if (!$skipOne && isRepeatingDouble((string)($i))) {
				$one += $i;
				$two += $i;
				continue; // Doesn't save time in this input.
				// After checking <1% of inputs are double-repeating and needing the any-repeating check. Classic AOC
			}

			if (!$skipTwo && isRepeatingAny((string)($i))) {
				$two += $i;
			}
		}
	}

	$time = round((microtime(true) - $time_start) * 1000, 3);
	return [$one, $two, $time];
}

function isRepeatingDouble(string $input): bool
{
	$len = strlen($input);
	if ($len % 2 !== 0) {
		return false; // Not even -> cannot be two equal halves
	}

	$half = $len / 2;
	return substr($input, 0, $half) === substr($input, $half);
}

function isRepeatingAny(string $input): bool
{
	$len = strlen($input);

	for ($block = 1; $block <= $len / 2; $block++) {
		if ($len % $block !== 0) {
			continue; // Block size must divide length evenly
		}

		$sequence = substr($input, 0, $block);
		$repeatCount = $len / $block;

		if (str_repeat($sequence, $repeatCount) === $input) {
			return true;
		}
	}

	return false;
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
