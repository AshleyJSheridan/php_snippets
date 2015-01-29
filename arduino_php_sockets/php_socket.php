<?php
$port = 'COM4';

while(true)
{
	$fh = fopen($port, 'w');
	
	fwrite($fh, 'a');
	
	fclose($fh);
	
	sleep(1);
}