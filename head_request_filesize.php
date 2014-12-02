<?php
$remoteFile = 'http://ashleysheridan.co.uk/images/articles/canvas_glow.png';
$ch = curl_init($remoteFile);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$data = curl_exec($ch);
curl_close($ch);
$contentLength = 0;
if($data !== false)
{
	if (preg_match('/Content-Length: (\d+)/', $data, $matches))
	{
		$contentLength = (int)$matches[1];
	}
}
echo $contentLength;
