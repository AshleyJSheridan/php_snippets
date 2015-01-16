php_snippets
============

# What This Is
This is a simple repo to hold a collection of small stand-alone PHP scripts for a variety of purposes.

# Contents
(alphabetically)<br/>
1. [head_request_filesize.php](#head_request_filesize)
1. [persistent_style_switcher.php](#persistent_style_switcher)
1. [pretty_cli.php](#pretty_cli)
1. [profanity_filter.php](#profanity_filter)
1. [remove_ms_crap.php](#remove_ms_crap)
1. [reverse_regexp_query_laravel.php](#reverse_regexp_query_laravel)
1. [roman_to_numeral_conversion.php](#roman_to_numeral_conversion)
1. [smart_image_resizing.php](#smart_image_resizing)
1. [uk_postcode_regex.php](#uk_postcode_regex)

## <a name="head_request_filesize"></a>Head Request Filesize
Fetches just the header of a remote file and outputs the filesize. In practical terms, and value in the HTTP response headers could be read, the filesize is a useful example.

## <a name="persistent_style_switcher"></a>Persistent Style Switcher
The purpose of this script is to allow your website to utilise several CSS files, that allow a user to pick one that suits them best.
This script reads from the <code>$_COOKIE</code> or the <code>$_GET</code> arrays (the latter takes precedence), and looks to see if a <code>style</code> parameter is set. It then outputs all associated stylesheets and marks all but the one specified as an alternate.
This has real-world uses for accessibility purposes, where you can give a user a better experience by offering a website style that might better suit them (larger fonts, better contrasting colour scheme, etc) and have it remember their preference.

## <a name="pretty_cli"></a>Pretty CLI
This is a small class intended for CLI scripts, allowing you to set colours for messages and even wrap them in different styles of borders.