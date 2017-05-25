<?php
	
	/**
	 * Class Regex
	 */
	class Regex {
		
		/**
		 * @param $pattern
		 * @param $value
		 *
		 * @return int
		 */
		public static function match($pattern, $value) {
			return preg_match($pattern, $value);
		}
		
		/**
		 * @param $pattern
		 * @param $replacement
		 * @param $value
		 *
		 * @return mixed
		 */
		public static function replace($pattern, $replacement, $value) {
			return preg_replace($pattern, $replacement, $value);
		}
		
	}

?>