<?php

//$input = file_get_contents('sample.txt');
$input = file_get_contents('input.txt');
$lines = preg_split('/([\r\n]+)/', $input);
$grid = array();
foreach($lines as $line) {
	if (strlen($line) > 0) {
		$grid[] = str_split($line);
	}
}

print var_export($grid, true) . "\n";

$total = count($grid) * 2 + ((count($grid[0]) - 2) * 2);
for($i = 1; $i < count($grid) - 1 ; $i++) {
	for ($j = 1; $j < count($grid[0]) - 1; $j++) {
		print $grid[$i][$j] . "\n";

		$visible = 4;
		for($k = $i - 1; $k >= 0; $k--) {
			if ($grid[$i][$j] <= $grid[$k][$j]) {
				$visible--;
				break;
			}
		}
		for($k = $i + 1; $k < count($grid); $k++) {
                	if ($grid[$i][$j] <= $grid[$k][$j]) {
                        	$visible--;
	                        break;
        	        }
		}

		for($k = $j - 1; $k >= 0; $k--) {
                	if ($grid[$i][$j] <= $grid[$i][$k]) {
                        	$visible--;
	                        break;
        	        }
	        }
        	for($k = $j + 1; $k < count($grid[0]); $k++) {
                	if ($grid[$i][$j] <= $grid[$i][$k]) {
                        	$visible--;
	                        break;
        	        }
	        }

		if ($visible !== 0) {
			$total++;
		}
	}

}
print "Total: " . $total . "\n";

?>
