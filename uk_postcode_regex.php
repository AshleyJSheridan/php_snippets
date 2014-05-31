<?php
/**
* While not strictly PHP, this can be used in form validation to verify a valid UK postcode
* according to the format laid out at https://www.mrs.org.uk/pdf/postcodeformat.pdf
* 
* It's worth noting that ROI doesn't use postcodes, this is strictly UK only
*/

// if you want to use the regex with a language that doesn't support the case-insensitive match flag (i) then use the longer regex instead
//$postcode_regexp = '/^([a-pA-Pr-uR-UwWyYzZ][a-hA-Hk-yK-Y]{0,1}\d[\da-hA-HjJkKsStT]{0,1} \d[aAbBd-hD-HjJlLnNp-uP-Uw-zW-Z]{2})$/';
$postcode_regexp = '/^([a-pr-uwyz][a-hk-y]{0,1}\d[\da-hjkst]{0,1} \d[abd-hjlnp-uw-z]{2})$/i';

if(preg_match($user_input, $postcode_regexp))
{}