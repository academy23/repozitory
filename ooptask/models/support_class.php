<?php
/**
 *
 * Class with helpful functions
 * @author Misha
 *
 */
class Support {
	
	public static function getSelect($text, $var) {
		$sel=' selected="selected" ';
		if (strstr($text, $var)){
			$pos = strpos($text, $var);
			$start = substr($text, 0, $pos);
			$end = substr($text, $pos, 1000000000);
			$text = $start.$sel.$end;
			return $text;
		}
	}

	public static function unixDate($date) {
		return strtotime($d);
	}
}
?>