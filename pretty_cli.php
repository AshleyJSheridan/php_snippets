<?php
$pcli = pretty_cli::getInstance();
$pcli->set_box_width(60);
$pcli->set_box_type('double');

$pcli->msg(
	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sodales eros sit amet tellus fringilla, sed euismod lectus tincidunt. Nunc velit erat, gravida finibus metus sed, viverra pretium lorem. Sed eu consequat nisi. Duis id velit in sem dapibus tempor sed vel orci. ',
	'',
	true,
	true,
	'purple',
	'teal'
);
$pcli->set_box_width(40);
$pcli->set_box_type('thick');
$pcli->msg('a fairly short warning message that wraps to a couple of lines',
	'error',
	true,
	true
);
$pcli->msg('a quick notice message, not boxed',
	'warning',
	true
);
$pcli->set_box_width(70);
$pcli->set_box_type('classic');
$pcli->msg(
	'Classic border style success message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sodales eros sit amet tellus fringilla, sed euismod lectus tincidunt. Nunc velit erat, gravida finibus metus sed, viverra pretium lorem. Sed eu consequat nisi. Duis id velit in sem dapibus tempor sed vel orci. ',
	'success',
	true,
	true
);

class pretty_cli
{
	private $_pcli;
	static $_instance;
	
	private function __clone() {}
	
	private function __construct()
	{
		// Set up shell colors
		$this->foreground['black'] = '0;30';
		$this->foreground['dark_grey'] = '1;30';
		$this->foreground['blue'] = '0;34';
		$this->foreground['light_blue'] = '1;34';
		$this->foreground['green'] = '0;32';
		$this->foreground['light_green'] = '1;32';
		$this->foreground['teal'] = '0;36';
		$this->foreground['light_cyan'] = '1;36';
		$this->foreground['red'] = '0;31';
		$this->foreground['light_red'] = '1;31';
		$this->foreground['purple'] = '0;35';
		$this->foreground['light_purple'] = '1;35';
		$this->foreground['dark_yellow'] = '0;33';
		$this->foreground['yellow'] = '1;33';
		$this->foreground['light_grey'] = '0;37';
		$this->foreground['white'] = '1;37';

		$this->background['black'] = '40';
		$this->background['red'] = '41';
		$this->background['green'] = '42';
		$this->background['yellow'] = '43';
		$this->background['blue'] = '44';
		$this->background['purple'] = '45';
		$this->background['teal'] = '46';
		$this->background['light_grey'] = '47';
		
		// borders
		$this->borders['double'] = '╔═╗║╚╝';
		$this->borders['thin'] = '┌─┐│└┘';
		$this->borders['thick'] = '┏━┓┃┗┛';
		$this->borders['curved'] = '╭─╮│╰╯';
		$this->borders['thin_dashed'] = '┌┄┐┆└┘';
		$this->borders['thin_dotted'] = '┌┈┐┊└┘';
		$this->borders['classic'] = '+-+|++';
		
		// set up defaults
		$this->default['error'] = array('fore' => 'black', 'back' => 'red');
		$this->default['success'] = array('fore' => 'black', 'back' => 'green');
		$this->default['warning'] = array('fore' => 'black', 'back' => 'yellow');
		
		// set up other defaults
		$this->box_width = 60;
		$this->border_type = 'double';
		$this->reset = "\033[0m";
	}
	
	/**
	 * create an instance of this class as a singleton
	 * @return pretty_cli
	 */
	public static function getInstance()
	{
		if(!(self::$_instance instanceof self))
			self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * create a message line or box with the specified parameters
	 * @param string $string the message you want to prettify
	 * @param string $type one of the default types, 'error', 'success', or 'warning' - this sets some default colours quickly
	 * @param bool $echo whether to output or return this string
	 * @param bool $boxed whether to draw a box around the string or not
	 * @param string $fore a foreground colour to use, from a predefined type
	 * @param string $back a background colour to use, from a predefined type
	 * @param mixed either echos or returns the string
	 */
	function msg($string, $type='message', $echo=false, $boxed=false, $fore='', $back='')
	{
		$this->len = strlen($string);
		$this->orig_string = $string;
		$this->string = $string;

		switch($type)
		{
			case 'error':
			case 'success':
			case 'warning':
			{
				$fore = $this->default[$type]['fore'];
				$back = $this->default[$type]['back'];
				break;
			}
			default:
			{
				$fore = isset($this->foreground[$fore])?$fore:$this->reset;
				$back = isset($this->background[$back])?$back:$this->reset;
			}
		}

		if($boxed)
			$this->string = $this->box($fore, $back, $this->border_type);
		else
			$this->string = $this->colourise_string($this->orig_string, $fore, $back);
		
		
		
		if($echo)
			echo "$this->string\n";
		else
			return $this->string;
	}
	
	/**
	 * set the colours used in one of the predefined default styles
	 * @param string $name the name of the default: e.g. 'error'
	 * @param string $foreground the name of the colour to use for the foreground
	 * @param string $background the name of the colour to use for the background
	 */
	public function set_default_colour($name, $foreground=null, $background=null)
	{
		if(!isset($this->default[$name]))
			return false;
			
		if(!is_null($foreground) && array_key_exists($foreground, $this->foreground))
			$this->default[$name]['fore'] = $foreground;

		if(!is_null($background) && array_key_exists($background, $this->background))
			$this->default[$name]['back'] = $background;
	}
	
	/**
	 * returns an array of the available colours for either foreground or background
	 * @param string $type either 'foreground' or 'background'
	 * @return array the list of available colours
	 */
	public function get_colours($type)
	{
		if(in_array($type, array('fore', 'back')))
		{
			$type = "{$type}ground";
			return array_keys($this->$type);
		}
	}
	
	/**
	 * return an array of the types of border that a box can use
	 * @return array
	 */
	public function get_box_types()
	{
		return array_keys($this->borders);
	}
	
	/**
	 * set a width for message boxes
	 * @param int $width the width of the message within a box
	 */
	public function set_box_width($width)
	{
		$this->box_width = intval($width);
	}
	
	/**
	 * set the style of the border to use on boxed messages to one of the predefined styles if it exists
	 * @param string $type the style of border, e.g. 'double'
	 */
	public function set_box_type($type)
	{
		if(isset($this->borders[$type]))
			$this->border_type = $type;
	}
	
	/**
	 * colours a single line string
	 * @param string $string the string to apply colour to
	 * @param string $fore the foreground colour to use
	 * @param string $back the background colour to use
	 * @return string the coloured string
	 */
	private function colourise_string($string, $fore, $back=null)
	{
		if($back && isset($this->background[$back]))
			$string = "\033[{$this->background[$back]}m$string";

		if(isset($this->foreground[$fore]))
			$string = "\033[{$this->foreground[$fore]}m$string";

		$string .= $this->reset;
		
		return $string;
	}
	
	/**
	 * draws a box around a string using the specified styles
	 * @param string $fore the foreground colour to apply to the string within the box
	 * @param string $back the background colour to apply to the string within the box
	 * @param string $border_type the style of border to apply to the string
	 * @returns string the boxed message
	 */
	private function box($fore, $back, $border_type='double')
	{
		$lines = $this->break_into_lines();
		
		$top_left = mb_substr($this->borders[$border_type], 0, 1, 'UTF-8');
		$top_bottom = mb_substr($this->borders[$border_type], 1, 1, 'UTF-8');
		$top_right = mb_substr($this->borders[$border_type], 2, 1, 'UTF-8');
		$side = mb_substr($this->borders[$border_type], 3, 1, 'UTF-8');
		$bottom_left = mb_substr($this->borders[$border_type], 4, 1, 'UTF-8');
		$bottom_right = mb_substr($this->borders[$border_type], 5, 1, 'UTF-8');
		
		$this->string = $top_left . str_repeat($top_bottom, $this->box_width+2) . "$top_right\n";
		
		foreach($lines as $line)
		{
			$this->string .= "$side ";
			$this->string .= $this->colourise_string(sprintf("%-".($this->box_width+1)."s", $line), $fore, $back);
			$this->string .= "$side\n";
		}

		$this->string .= $bottom_left . str_repeat($top_bottom, $this->box_width+2) . "$bottom_right\n";

		return $this->string;
	}
	
	/**
	 * breaks a long string into an array of lines based on the box width
	 * @return array
	 */
	private function break_into_lines()
	{
		$words = explode(' ', $this->string);
		$lines = array('');
		
		for($i=0; $i<count($words); $i++)
		{
			// first, check if any word is longer than the current box width
			if(strlen($words[$i]) > $this->box_width)
				$this->box_width = strlen($words[$i]);
		}
		
		for($i=0; $i<count($words); $i++)
		{
			if( strlen($lines[count($lines)-1] . ' ' . $words[$i]) <= $this->box_width )
				$lines[count($lines)-1] .= " {$words[$i]}";
			else
				$lines[] = $words[$i];
		}
		
		if(count($lines))
			$lines[0] = trim($lines[0]);
		
		return $lines;
	}
}
