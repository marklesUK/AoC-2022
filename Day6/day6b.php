<?php
//$input = "mjqjpqmgbljsphdztnvjfqwrcgsmlb";
$input = file_get_contents('input.txt');
$chars = str_split($input);
$length = false;
define('UNIQUE_LEN', 14);

for($i = 0; $i < count($chars) - UNIQUE_LEN; $i++) {
	$dup = false;
	$test = array_flip(array_slice($chars, $i, UNIQUE_LEN));
	if (count($test) === UNIQUE_LEN) {
		print $i+UNIQUE_LEN . "\n";
		break;
	}
}
