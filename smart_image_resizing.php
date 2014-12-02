<?php
function createResizedImage($url, $newUrl, $width, $height)
{
	list($width_orig, $height_orig) = getimagesize($url);
	if(($width / $height) < ($width_orig / $height_orig))
	{
		// landscape
		$ratio = $width / $height;
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($url);
		imagecopyresampled($image_p, // dst_im
			$image, // src_im
			0, // dst_x
			0, // dst_y
			($width_orig / 2) - ($height_orig * $ratio) / 2, // src_x
			0, // src_y
			$width, // dst_w
			$height, // dst_h
			$height_orig * $ratio, // src_w
			$height_orig); // src_h
	}
	else
	{
		// portrait
		$ratio = $height / $width;
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($url);
		imagecopyresampled($image_p, // dst_im
			$image, // src_im
			0, // dst_x
			0, // dst_y
			0, // src_x
			0, // src_y
			$width, // dst_w
			$height, // dst_h
			$width_orig, // src_w
			$width_orig * $ratio); // src_h
	}
	imagejpeg($image_p, $newUrl, 100);
}

createResizedImage("images/snowman.jpg", "images/thumbs/snowman.jpg", 200, 100);
createResizedImage("images/building.jpg", "images/thumbs/building.jpg", 200, 100);
createResizedImage("images/boat.jpg", "images/thumbs/boat.jpg", 200, 100);
