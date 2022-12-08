<?php

//$input = file_get_contents('sample1.txt');
$input = file_get_contents('input.txt');
$lines = preg_split('/([\r\n]+)/', $input);
$grid = array();
foreach($lines as $line) {
	if (strlen($line) > 0) {
		$grid[] = str_split($line);
	}
}

//print var_export($grid, true) . "\n";

$max = 0;

for($i = 1; $i < count($grid) - 1; $i++) {
	for ($j = 1; $j < count($grid[0]) - 1; $j++) {

		print "Location: " . $i . "," . $j . ": " . $grid[$i][$j] . "";


		$tree_count1 = 0;
		$last_tree = 0;
		for($k = $i - 1; $k >= 0; $k--) {
//			print "up testing: " . $k . "," . $j . ": " . $grid[$k][$j] . "\n\t";
			$tree_count1++;
			if ($grid[$k][$j] >= $grid[$i][$j]) {
				// taller than / same as current
				break;
			}
		}

		$tree_count2 = 0;
		$last_tree = 0;
		for($k = $i + 1; $k < count($grid); $k++) {
//			print "down testing: " . $k . "," . $j . ": " . $grid[$k][$j] . "\n\t";
			$tree_count2++;
			if ($grid[$k][$j] >= $grid[$i][$j]) {
				// taller than / sama as current
				break;
			}
		}

		$tree_count3 = 0;
		for($k = $j - 1; $k >= 0; $k--) {
//			print "left testing: " . $k . "," . $j . ": " . $grid[$k][$j] . "\n\t";
			$tree_count3++;
			if ($grid[$i][$k] >= $grid[$i][$j]) {
				break;
			}
		}

		$tree_count4 = 0;
		for($k = $j + 1; $k < count($grid[0]); $k++) {
//			print "\nright testing: " . $i . "," . $k . ": " . $grid[$i][$k] . "\n";
			$tree_count4++;
			if ($grid[$i][$k] >= $grid[$i][$j]) {
				// taller than / same as current
				break;
			}
		}

		$score = $tree_count1 * $tree_count2 * $tree_count3 * $tree_count4;
		if ($score > $max) {
			$max = $score;
		}
		print " => " . $tree_count1 . " * " .  $tree_count2 . " * " . $tree_count3 . " * " . $tree_count4 . " = " . $score . "\n";

	}

}
print "Max score: " . $max . "\n";

?>
