<?php
/*
* I used this to query a database of URLs which contained regular expressions
* with a user supplied string which needed to be escaped. The URLs were in 
* the following type of format:
*
* /page/([a-z0-9]+)
* /page/([a-z0-9]+)/([a-z0-9]+)
*
* it seems to perform fairly quickly - and could be used for routing, etc
*/

$data = DB::table('table')
	->whereRaw("? REGEXP url_field", array($url))
	->get();