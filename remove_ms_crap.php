<?php
// an old function aimed at removing the cruft that comes from copy/pasting anything from MSOffice into an RTE
// meant to operate only on small snippets, not content which should contain valid meta tags
function removeMSCrap($crap, $richText=false)
{
	$find = Array(chr(128), chr(133), chr(8226), chr(145), chr(8217), chr(146), chr(8220), chr(147), chr(8221), chr(148), chr(8226), chr(149), chr(8211), chr(150), chr(8212), chr(151), chr(153), chr(169), chr(174));
	$replace = Array("&euro;", "&#133;", "&#8243;", "&#039;", "&#039;", "&#039;", "&#039;", "&#034;", "&#034;", "&#034;", "&#034;", "&#149;", "&#149;", "&#150;", "&#150;", "&#151;", "&#153;", "&copy;", "&reg;");
	$roses = str_replace($find, $replace, $crap);
	if($richText)
	{
		$find = '/\<meta (\n|.)+\<\/meta\>/i';
		$roses = preg_replace($find, '', $roses);
		$roses = str_replace("</meta>", "", $roses);
	}
	return $roses;
}
