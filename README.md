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
![Screenshot of pretty_cli.php in use](https://raw.githubusercontent.com/AshleyJSheridan/php_snippets/master/images/pretty_cli.png)

## <a name="profanity_filter"></a> Profanity Filter
This is a profanity filter built with a short base list of words, and some logic in regular expressions to allow for deliberate character replacements of characters that look like letters, and s-p-a-c-e-d o-u-t words that might otherwise not be recognised. It also attempts to look for English pluralisation of words using simple logic.
This creates very large regular expressions, so be wary of running it repeatedly over large outut texts. It would be advised to run it over a source text and store that result separately from the original.

## <a name="remove_ms_crap"></a>Remove MS Crap
Does what it says on the tin. Typically, when content is copy/pasted from Microsoft Office software (Word, Outlook, et al) into a web-based rich text editor, it also copies over lots of unecessary metadata in the form of MS-specific HTML comments, <code>&lt;meta&gt;</code> tags, and other things. This small function helps clean that input up.

## <a name="reverse_regexp_query_laravel"></a> Reverse Regular Expression Query for Laravel
This is just a small snippet that you could use with Eloquent (the database abstraction layer used by Laravel and other frameworks) that you could use to query a table with a string, where the table contains the regular expression. This is the reverse of what one normally might do by querying a table of static strings with a regular expression.

## <a name="roman_to_numeral_conversion"></a> Roman to Numeral Conversion
This takes a standard base-10 integer and converts it to a Roman-numeral string using the traditional syntax (so 4 is ⅠⅤ and not ⅠⅠⅠⅠ)

## <a name="smart_image_resizing"></a> Smart Image Resizing
This function creates a resized image from a JPEG. The smart part of this is how it performs cropping where necessary, as it looks at the orientation of the source image to determine what parts are more likely to be fine to crop out. So a portrait image, for example, would crop out the bottom area of the image if it was being resized to a square image.

## <a name="uk_postcode_regex"></a> UK Postcode Regex
This is just a regular expression built to match a valid UK postcode according to the format specified by https://www.mrs.org.uk/pdf/postcodeformat.pdf . One thing to note is that this doesn't accept short-form postcodes, as they are technically not valid according to the spec. If that is what you need, then you can make the latter half of the regex optional with the <code>?</code> modifier.
