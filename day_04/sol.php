<?php
// Part One: ~35ms
// Part Two: ~950ms (part one is also ran since it's basically the first iteration of part two; doesn't add meaningful time)

/**
 * @return array{int, int, float}
 */
function solve(string $input, bool $skipTwo): array
{
	$time_start = microtime(true);
	$one = 0;
	$two = 0;

	$rows = file($input, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	$grid = [];
	foreach ($rows as $row) {
		$grid[] = str_split($row);
	}

	$height = count($grid);
	$width = count($grid[0]);

	$surroundingOffsets = [
		[-1, -1],
		[-1, 0],
		[-1, 1],
		[0, -1],
		[0, 1],
		[1, -1],
		[1, 0],
		[1, 1],
	];

	$changes = true;
	$iterCount = 0;
	$newGrid = $grid;

	while ($changes && (!$skipTwo || $iterCount === 0)) {
		$changes = false;

		for ($y = 0; $y < $height; $y++) {
			for ($x = 0; $x < $width; $x++) {
				if ($grid[$y][$x] === '.') {
					continue;
				}

				// Check the 8 surrounding cells
				$fullCells = 0;
				foreach ($surroundingOffsets as [$offsetY, $offsetX]) {
					$checkY = $y + $offsetY;
					$checkX = $x + $offsetX;
					if ($checkY < 0 || $checkY >= $height || $checkX < 0 || $checkX >= $width) {
						continue;
					}

					if ($grid[$checkY][$checkX] === '@') {
						$fullCells++;
					}
				}

				if ($fullCells >= 4) {
					continue;
				}

				// In part one, we don't swap grid; so we only count first iteration
				if ($iterCount === 0) {
					$one++;
				}

				$two++;

				// Change cell to empty
				$newGrid[$y][$x] = '.';
				$changes = true;
			}
		}

		$iterCount++;
		$grid = $newGrid;
	}

	$time = round((microtime(true) - $time_start) * 1000, 3);
	return [$one, $two, $time];
}

function solveAndTime(string $input, bool $skipTwo = false)
{
	[$one, $two, $time] = solve($input, $skipTwo);
	echo "One: " . $one . PHP_EOL;

	if (!$skipTwo) {
		echo "Two: " . $two . PHP_EOL;
	}
	echo "Time: " . $time . " ms" . PHP_EOL;
}


echo "EXAMPLE" . PHP_EOL;
solveAndTime('input/example.txt', skipTwo: false);

echo PHP_EOL . "INPUT" . PHP_EOL;
solveAndTime('input/input.txt', skipTwo: false);
