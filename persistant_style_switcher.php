<?php
$styles = array('main' => 'Pastel', 'modern' => 'Modern');
session_start();
if(isset($_COOKIE['style']))
{
	$style = $_COOKIE['style'];
	if(in_array($style, $styles))
	{
		$_SESSION['style'] = $style;
	}
}
if(isset($_GET['style']))
{
	$style = $_GET['style'];
	if(in_array($style, $styles))
	{
		$_SESSION['style'] = $style;
		setcookie('style', $style, time()+60*60*24*30);
	}
}
if(!isset($_SESSION['style']))
{
	$_SESSION['style'] = $styles['main'];
}
foreach($styles as $key => $value)
{
	$alternate = ($_SESSION['style'] == $value)?'':'alternate ';
	print "\n<link rel=\"{$alternate}stylesheet\" href=\"styles/$key.css\" title=\"$value\"/>";
}
