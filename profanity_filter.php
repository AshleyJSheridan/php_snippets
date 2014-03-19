<?php
/**
 * filter class to replace profanity with safe characters
 */
class filter_profanity
{
	// these characters will be looked for as joining characters between letters in attempt to bypass the filter l-i-k-e t_h_i_s...
	private $joining_chars = ' _\-\+\.';
	
	// these words should be the plain ascii version
	// the code will generate regular expression replacements based on the character arrays below
	// mis-spellings (like 'fck' instead of 'fuck') will need to be manually added, the code will then generate
	// corresponding equivalents (like ⓕⓒⓚ)
	private $profanity = array(
		'anal','anus','arse','ass','assface','asshole','asslick','asswipe',
		'ballsack','bastard','biatch','bitch','blowjob','bollock','bollok','boob','bugger','bum','butt','butthole','buttcam','buttplug','buttwipe','buttfucking','buttfuck','barely legal','bdsm','bbw','bimbo','bukkake',
		'clit','clitoris','cock','cockhead','cocksucker','coon','crap','cunt','cum','cumshot','cumming',
		'damn','dick','dickhead','dildo','dyke','deepthroat','defloration','doggystyle','dp',
		'ejaculation',
		'fag','fatass','fck','fellate','fellatio','felching','fuck','fucker','fuckface','fudgepacker','fucked','fisting','fingering','foreplay','foursome',
		'gayboy','gaygirl','goddamn','gagged','gloryhole','golden shower','gilf',
		'homo','handjob','hymen','huge toy','hooter',
		'jackoff','jap','jizz',
		'knob','knobend','knobjockey','knocker',
		'labia','lactating','ladyboy',
		'masterbate','masturbate','mofo','muff','milf','muff dive','muff diving',
		'nigga','nigger','nipple',
		'orgy',
		'paki','penis','piss','pisstake','poop','porn','prick','pube','pussy','pornstar','porn star','porno','pornographic','pissing',
		'rectum','retard',
		'schlong','scrotum','sex','shit','shithead','shyte','slut','spunk','shitting','sperm','strap on','stripper','speculum','sybian',
		'tit','tosser','turd','twat','threesome','topless','titty',
		'vagina',
		'whore','wank','wanker','whoar',
	);
	
	// these characters will replace each letter in a profanity word above in a regex character class
	private $replacement = array(
		'a' => 'aªàáâãäåāăąǎȁȃȧᵃḁẚạảₐ⒜ⓐａ4⍺4⁴₄④⑷⒋４₳@',
		'b' => 'bᵇḃḅḇ⒝ⓑｂɞßℬ฿',
		'c' => 'cçćĉċčᶜⅽ⒞ⓒｃ©¢℃￠€\<',
		'd' => 'dďᵈḋḍḏḑḓⅆⅾ⒟ⓓｄ',
		'e' => 'eèéêëēĕėęěȅȇȩᵉḙḛẹẻẽₑ℮ℯⅇ⒠ⓔｅ⅀∑⨊⨋€℮',
		'f' => 'fᶠḟ⒡ⓕﬀｆƒ⨐ƒ៛',
		'g' => 'gĝğġģǧǵɡᵍᵹḡℊ⒢ⓖｇ',
		'h' => 'hĥȟʰһḣḥḧḩḫẖₕℎ⒣ⓗｈ44⁴₄④⑷⒋４',
		'i' => 'iìíîïĩīĭįİıǐȉȋᵢḭỉịⁱℹⅈⅰⅱ⒤ⓘｉlĺļľŀˡḷḻḽₗℓⅼ⒧ⓛｌ|׀∣❘｜1¹₁⅟①⑴⒈１',
		'j' => 'jĵǰʲⅉ⒥ⓙⱼｊ',
		'k' => 'kķǩᵏḱḳḵₖ⒦ⓚｋ',
		'l' => 'iìíîïĩīĭįİıǐȉȋᵢḭỉịⁱℹⅈⅰⅱ⒤ⓘｉlĺļľŀˡḷḻḽₗℓⅼ⒧ⓛｌ|׀∣❘｜1¹₁⅟①⑴⒈１',
		'm' => 'mᵐḿṁṃₘⅿ⒨ⓜ㎜ｍℳ',
		'n' => 'nñńņňŉƞǹṅṇṉṋⁿₙ⒩ⓝｎ',
		'o' => 'oºòóôõöōŏőơǒǫȍȏȯᵒọỏₒℴ⒪ⓞｏ°⃝⃠⊕⊖⊗⊘⊙⊚⊛⊜⊝⌼⌽⌾⍉⍜⍟⍥⎉⎊⎋⏀⏁⏂⏣○◌●◯⚆⚇⚪⚬❍⦲⦵⦶⦷⦸⦹⦾⧂⧃⧲⧬⨀㊀0⁰₀⓪０',
		'p' => 'pᵖṕṗₚ⒫ⓟｐ',
		'q' => 'q⒬ⓠｑ',
		'r' => 'rŕŗřȑȓɼʳᵣṙṛṟ⒭ⓡｒſẛɼẛ',
		's' => 'sśŝşšșˢṡṣₛ⒮ⓢｓ$﹩＄5⁵₅⑤⑸⒌５§',
		't' => 'tţťƫțᵗƾṫṭṯṱẗₜ⒯ⓣｔ☨☩♰♱⛨✙✚✛✜✝✞✟⧧†\+',
		'u' => 'uùúûüũūŭůűųưǔȕȗᵘᵤṳṵṷụủ⒰ⓤｕvᵛᵥṽṿⅴ⒱ⓥｖ',
		'v' => 'uùúûüũūŭůűųưǔȕȗᵘᵤṳṵṷụủ⒰ⓤｕvᵛᵥṽṿⅴ⒱ⓥｖ',
		'w' => 'wŵʷẁẃẅẇẉẘ⒲ⓦｗ',
		'x' => 'xˣẋẍₓⅹ⒳ⓧｘ˟╳❌❎⤫⤬⤭⤮⤯⤰⤱⤲⨯×✕✖⨰⨱⨴⨵⨶⨷',
		'y' => 'yýÿŷȳʸẏẙỳỵỷỹ⒴ⓨｙ¥￥',
		'z' => 'zźżžƶᶻẑẓẕ⒵ⓩｚ2²₂②⑵⒉２',
		' ' => ' _\-\+\.',
	);
	

	/**
	* return a filtered string
	* @param string $filter_line the string to be filtered
	* @param string $replace_char optional character to use as the replacement - defaults to *
	* @return string
	*/
	public function filter_string($filter_line, $replace_char='*')
	{
		/*
		* loop through the words in the $profanity array, and for each character swap in the replacement characters
		* within the regex character match brackets
		* the regex also matches against word boundaries, so clbuttic mistakes don't occur
		*/
		foreach($this->profanity as $word)
		{
			$regex = '/(\b|[ \t])';
			$regex_parts = array();
			
			// it's ok to use strlen & substr here as the input string should only ever be ascii, never multibyte
			for($i=0; $i<strlen($word); $i++)
			{
				$letter = substr($word, $i, 1);
				$regex_parts[] = "[{$this->replacement[$letter]}]+";
			}
			$regex_parts[] = "[{$this->replacement['e']}]*[{$this->replacement['s']}{$this->replacement['d']}]*";
			
			$regex .= join("[{$this->joining_chars}]*", $regex_parts);
			$regex .= '(\b|[ \t])/ui';

			$replacement = (mb_strlen($replace_char))?' '.str_pad('', strlen($word), $replace_char).' ':'';
			$filter_line = preg_replace($regex, $replacement, $filter_line );
		}
		return $filter_line;
	}
}