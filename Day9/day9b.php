<?php

//$input = file_get_contents('sample.txt');
$input = file_get_contents('sample2.txt');
//$input = file_get_contents('input.txt');
$lines = preg_split('/([\r\n]+)/', $input);

define("KNOTS", 10);

function show_grid($grid, $showmarkers = false) {
	global $x,$y;
	if ($showmarkers) {
		$grid[0][0] = 's';
		for($i = (KNOTS - 1); $i > 0; $i--) {
			$grid[$y[$i]][$x[$i]] = sprintf("%d", $i);
		}
		$grid[$y[0]][$x[0]] = 'H';
	}

	$maxrow = 0;
	$minrow = 0;
	foreach($grid as $row) {
		if (max(array_keys($row)) > $maxrow) {
			$maxrow = max(array_keys($row));
		}
		if (min(array_keys($row)) < $minrow) {
			$minrow = min(array_keys($row));
		}
	}

	for($i = min(array_keys($grid)); $i <= max(array_keys($grid)); $i++) {
		if (!isset($grid[$i])) {
			$grid[$i] = array();
		}
	}

	foreach($grid as $idx => $row) {
		for ($i = $minrow; $i <= $maxrow; $i++) {
			if (!isset($grid[$idx][$i])) {
				$grid[$idx][$i] = ".";
			}
		}
		ksort($grid[$idx]);
	}

	krsort($grid);

	foreach($grid as $row) {
		foreach($row as $value) {
			print $value;
		}
		print "\n";
	}
	print "\n\n";
}


for($i = 0; $i < KNOTS; $i++) {
	$x[$i] = 0;
	$y[$i] = 0;
}

$grid[0][0] = '#';

function follow($i) {
	global $x,$y,$grid;

	$diffx = $x[$i] - $x[$i+1];
	$diffy = $y[$i] - $y[$i+1];

	$diff = floor(sqrt(($diffx * $diffx) + ($diffy * $diffy)));
	if ($diff > 1) {
		$x[$i+1] += (($diffx === 0) ? 0 : (($diffx > 0) ? 1 : -1));
		$y[$i+1] += (($diffy === 0) ? 0 : (($diffy > 0) ? 1 : -1));
	}
}

function move_horizontal($dir) {
	global $x,$y,$grid;
	$x[0] += ($dir ? 1 : -1);

	$diffx = $x[0] - $x[1];
	$diffy = $y[0] - $y[1];

	$diff = floor(sqrt(($diffx * $diffx) + ($diffy * $diffy)));
	if ($diff > 1) {
		$x[+1] += (($diffx === 0) ? 0 : (($diffx > 0) ? 1 : -1));
		$y[+1] += (($diffy === 0) ? 0 : (($diffy > 0) ? 1 : -1));
	}
	for($i = 1; $i < (KNOTS - 1); $i++) {
		follow($i);
	}
	$grid[$y[(KNOTS -1)]][$x[(KNOTS -1)]] = '#';
}

function move_vertical($dir) {
	global $x,$y,$grid;
	$y[0] += ($dir ? 1 : -1);

	$diffx = $x[0] - $x[1];
	$diffy = $y[0] - $y[1];

	$diff = floor(sqrt(($diffx * $diffx) + ($diffy * $diffy)));
	if ($diff > 1) {
		$x[1] += (($diffx === 0) ? 0 : (($diffx > 0) ? 1 : -1));
		$y[1] += (($diffy === 0) ? 0 : (($diffy > 0) ? 1 : -1));
	}
	for($i = 1; $i < (KNOTS -1); $i++) {
		follow($i);
	}
	$grid[$y[(KNOTS -1)]][$x[(KNOTS -1)]] = '#';
}

//show_grid($grid);
foreach($lines as $line) {
	if (strlen($line) ===  0) {
		continue;
	}
	if (preg_match('/^[LR] ([0-9]+)$/', $line, $matches)) {
		for ($i = 0; $i < (int)$matches[1]; $i++) {
			$x[0] += (($line[0] === 'R') ? 1 : -1);
		}
	}
	if (preg_match('/^[UD] ([0-9]+)$/', $line, $matches)) {
		for ($i = 0; $i < (int)$matches[1]; $i++) {
			$y[0] += (($line[0] === 'U') ? 1 : -1);
		}
	}
	for($i = 0; $i < (KNOTS -1); $i++) {
		follow($i);
	}
	$grid[$y[(KNOTS -1)]][$x[(KNOTS -1)]] = '#';
	show_grid($grid, true);
}

$count = 0;
foreach($grid as $row) {
	foreach($row as $value) {
		if ($value === "#") {
			$count++;
		}
	}
}
print "Count: " . $count ."\n";

?>
