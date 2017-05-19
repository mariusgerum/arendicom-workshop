<?php
	
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
		
		/**
		 * @param       $value
		 * @param float $alt
		 *
		 * @return float|string
		 */
		public static function formatPrice($value, $alt = 0.0) {
			$value = self::makeFloat($value);
			if(is_float($value) || is_int($value)){
				return format_decimal($value) . " &euro;";
			}
			return $alt;
		}
		
		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		public static function RemoveSpaces($value) {
			return str_replace(' ', '', $value);
		}
		
		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		public static function makeFloat($value) {
			$value = trim($value);
			$value = self::replace('/[^0-9,.\-+]/i', '', $value);
			$value = self::replace('/^(\+|\-)?([0-9]+?)\.([0-9]+?)\,([0-9]+)$/i', '$1$2$3.$4', $value);
			$value = self::replace('/^(\+|\-)?([0-9]+?)\,([0-9]+)$/i', '$1$2.$3', $value);
			
			$value = @floatval($value);
			
			if ( is_float($value) ) {
				return $value;
			}
			
			return false;
		}
		
		/**
		 * @param $value
		 *
		 * @return bool|int|mixed|string
		 */
		public static function makeInt(&$value) {
			$value = trim($value);
			$value = self::replace('/[^0-9,.\-+]/i', '', $value);
			$value = self::replace('/^(\+|\-)?([0-9]+?)\.([0-9]+?)\,([0-9]+)$/i', '$1$2$3.$4', $value);
			$value = self::replace('/^(\+|\-)?([0-9]+?)\,([0-9]+)$/i', '$1$2.$3', $value);
			
			$value = @intval($value);
			
			if ( is_int($value) ) {
				return $value;
			}
			
			return false;
		}
		
	}

?>