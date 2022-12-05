<?php
 $input = "    [D]    
[N] [C]    
[Z] [M] [P]
 1   2   3 

move 1 from 2 to 1
move 3 from 1 to 3
move 2 from 2 to 1
move 1 from 1 to 2";

$stacks = array();
$lines = preg_split('/(\r\n)/', $input);
foreach($lines as $line) {
	if (preg_match('/^move ([0-9]+) from ([0-9]+) to ([0-9]+)$/', $line, $matches))	{
		$count = (int)$matches[1];
		$from = (int)$matches[2] - 1;
		$to = (int)$matches[3] - 1;
		$crates = array_slice($stacks[$from],0,$count);
		$stacks[$from] = array_slice($stacks[$from],$count);
		$stacks[$to] = array_merge($crates, $stacks[$to]);
	} else if (strlen($line) % 4 === 3) {
		if (str_contains($line, "[")) {
			$stack = 0;
			for($i = 1; $i < strlen($line); $i += 4) {
				if ($line[$i] !== " ") {
					$stacks[$stack][] = $line[$i];
				}
				$stack++;
			}
		} else {
			ksort($stacks);
		}
	}
}
//print var_export($stacks, true) . "\n";
foreach($stacks as $stack) {
	print $stack[0];
}
