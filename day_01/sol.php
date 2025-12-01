<?php

function solve($input, $debug = false): array
{
	$dial = 50;
	$passwordOne = 0;
	$passwordTwo = 0;

	if ($debug) {
		echo "The dial starts at " . $dial . PHP_EOL;
	}

	$lines = file($input, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		$dir = $line[0] === 'R' ? 1 : -1;
		$dist = trim(substr($line, 1));

		[$dial, $zeroTimes] = newRot($dial, $dir, $dist);
		if ($dial === 0) {
			$passwordOne += 1;
			$passwordTwo += 1;
		}

		$passwordTwo += $zeroTimes;

		if ($debug) {
			if ($zeroTimes > 0) {
				echo "The dial is rotated " . $line . " to point at " . $dial . "; during this rotation, it points at 0, " . $zeroTimes . " time(s)" . PHP_EOL;
			} else {
				echo "The dial is rotated " . $line . " to point at " . $dial . PHP_EOL;
			}
		}
	}

	return [$passwordOne, $passwordTwo];
}

function newRot($cur, $dir, $dist): array
{
	$timesAtZero = 0;

	while ($dist > 0) {
		$cur = $dir === 1 ? $cur + 1 : $cur - 1;

		if ($cur > 99) {
			$cur = 0;
		}

		if ($cur < 0) {
			$cur = 99;
		}

		if ($cur === 0 && $dist > 1) {
			$timesAtZero += 1;
		}


		$dist -= 1;
	}

	return [$cur, $timesAtZero];
}


[$one, $two] = solve('input/input.txt', false);
echo "Solutions" . PHP_EOL;
echo "One: " . $one . PHP_EOL;
echo "Two: " . $two . PHP_EOL;
