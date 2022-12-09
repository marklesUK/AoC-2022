<?php

//$input = file_get_contents('sample.txt');
$input = file_get_contents('input.txt');
$lines = preg_split('/([\r\n]+)/', $input);

function show_grid($grid, $showmarkers = false) {
	global $x,$y;
	if ($showmarkers) {
		$grid[0][0] = 's';
		$grid[$y[1]][$x[1]] = 'T';
		$grid[$y[0]][$x[0]] = 'H';
	}

	$maxrow = 0;
	foreach($grid as $row) {
		if (count($row) > $maxrow) {
			$maxrow = count($row);
		}
	}

	foreach($grid as $idx => $row) {
		for ($i = 0; $i <= $maxrow; $i++) {
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

$x[0] = 0;
$y[0] = 0;

$x[1] = 0;
$y[1] = 0;

$grid[0][0] = '#';

function move_horizontal($dir) {
	global $x,$y,$grid;
	$x[0] += ($dir ? 1 : -1);

	$diffx = $x[0] - $x[1];
	$diffy = $y[0] - $y[1];

	if ($diffy === 0) {
		// same row
		if (abs($diffx) > 1) {
			$x[1] += (($diffx > 0) ? 1 : -1);
		}
	} else {
		$diff = floor(sqrt(($diffx * $diffx) + ($diffy * $diffy)));
		if ($diff > 1) {
			$x[1] += (($diffx > 0) ? 1 : -1);
			$y[1] += (($diffy > 0) ? 1 : -1);
		}
	}
	$grid[$y[1]][$x[1]] = '#';
}

function move_vertical($dir) {
	global $x,$y,$grid;
	$y[0] += ($dir ? 1 : -1);

	$diffx = $x[0] - $x[1];
	$diffy = $y[0] - $y[1];

	if ($diffx === 0) {
		// same column
		if (abs($diffy) > 1) {
			$y[1] += (($diffy > 0) ? 1 : -1);
		}
	} else {
		$diff = floor(sqrt(($diffx * $diffx) + ($diffy * $diffy)));
		if ($diff > 1) {
			$x[1] += (($diffx > 0) ? 1 : -1);
			$y[1] += (($diffy > 0) ? 1 : -1);
		}
	}
	$grid[$y[1]][$x[1]] = '#';
}

//show_grid($grid);
foreach($lines as $line) {
	if (strlen($line) ===  0) {
		continue;
	}
	if (preg_match('/^[LR] ([0-9]+)$/', $line, $matches)) {
		for ($i = 0; $i < (int)$matches[1]; $i++) {
			move_horizontal($line[0] === 'R');
		}
	}
	if (preg_match('/^[UD] ([0-9]+)$/', $line, $matches)) {
		for ($i = 0; $i < (int)$matches[1]; $i++) {
			move_vertical($line[0] === 'U');
		}
	}
//	show_grid($grid);
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
