<?php

//$input = file_get_contents('sample.txt');
$input = file_get_contents('input.txt');
$lines = preg_split('/([\r\n]+)/', $input);
$tree = array();

function parse(&$t) {
	global $lines;
	global $tree;
	while (count($lines) > 0) {
		$line = array_shift($lines);
//		print $line . "\n";
		if (preg_match('/^\$ ([a-z]+)(?: (.*)){0,1}$/', $line, $matches)) {
			$cmd = $matches[1];
			$parameters = isset($matches[2]) ? $matches[2] : '';
			switch ($cmd) {
				case 'cd': {
					switch ($parameters) {
						case '/': {
							parse($tree);
							return;
						}

						case '..': {
							return;
						}

						default: {
							if (!isset($t[$parameters])) {
								$t[$parameters] = array();
							}
							parse($t[$parameters]);
							break;
						}
					}
					break;
				}

				case 'ls': {
					break;
				}
			}
		} else if (preg_match('/^([0-9]+) (.+)$/', $line, $matches)) {
			$size = (int)$matches[1];
			$name = $matches[2];
			$t[$name] = $size;
		} else if (preg_match('/^dir (.+)$/', $line, $matches)) {
			$name = $matches[1];
			$t[$name] = array();
		}
	}
}
parse($tree);
//print var_export($tree, true) . "\n";

$sum = 0;
function dir_size($t, $nm) {
	global $sum;
	$total = 0;
	foreach($t as $n => $s) {
		if (is_array($s)) {
			$total += dir_size($s, $n);
		} else {
			$total += $s;
		}
	}
	print "dir_size(" . $nm . "): " . $total . "\n";
	if ($total <= 100000) {
		$sum += $total;
	}
	return $total;
}


print "All files: " . dir_size($tree, "/") . "\n";

$sum = 0;
foreach ($tree as $name => $subdir) {
	if (is_array($subdir)) {
		$size = dir_size($subdir, $name);
	}
}
print "\ntotal:" . $sum . "\n";


?>
