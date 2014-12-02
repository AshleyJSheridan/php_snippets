<?php
$roman = 'xix';

$values = array(
	'i' => 1,
	'v' => 5,
	'x' => 10,
	'l' => 50,
	'c' => 100,
	'd' => 500,
	'm' => 1000,
);
$total = 0;
for($i=0; $i<strlen($roman); $i++)
{
	$v = $values[substr($roman, $i, 1)];
	
	$v2 = ($i <= strlen($roman))?$values[substr($roman, $i+1, 1)]:0;
	
	if($v2 && $v < $v2)
	{
		$total += ($v2 - $v);
		$i++;
	}
	else
		$total += $v;
}
echo $total;
