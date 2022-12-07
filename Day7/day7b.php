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

$sizes = array();

function dir_size($t, $nm) {
	global $sizes;
	$total = 0;
	foreach($t as $n => $s) {
		if (is_array($s)) {
			$total += dir_size($s, $n);
		} else {
			$total += $s;
		}
	}
///	print "dir_size(" . $nm . "): " . $total . "\n";
	$sizes[] = $total;
	return $total;
}

$free_space = 70000000 - dir_size($tree, "/");
print "free space: " . $free_space . "\n";
sort($sizes);
//print var_export($sizes, true) . "\n";

$sum = 0;
foreach ($sizes as $size) {
	if (($size + $free_space) >= 30000000) {
		print $size . "\n";
		break;
	}
}


?>
