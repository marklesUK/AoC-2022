<?php
//$input = "nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg";
$input = file_get_contents('input.txt');
$chars = str_split($input);
$length = false;

for($i = 0; $i < count($chars) - 4; $i++) {
	$dup = false;
	$test = array_flip(array_slice($chars, $i, 4));
	if (count($test) === 4) {
		print $i+4;
		break;
	}
}
