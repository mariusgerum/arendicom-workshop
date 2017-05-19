<?php
	
	/**
	 * @param $value
	 *
	 * @return string
	 */
	function e($value) {
		return @htmlspecialchars($value, ENT_QUOTES, 'utf-8');
	}
	
	/**
	 * @param $value
	 *
	 * @return string
	 */
	function pre($value) {
		return "<pre>" . print_r($value, 1) . "</pre>";
	}
	
	/**
	 * @param $value
	 *
	 * @return bool
	 */
	function is_true($value) {
		if ( is_array($value) ) {
			foreach ( $value as $v ) {
				if ( $v !== true || $v === false ) {
					return false;
				}
			}
			
			return true;
		} else {
			if ( $value === true || $value !== false ) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Checks if value is / values are not false. Good for PDO::exec statements with multiple results (e.g. in
	 * transaction)
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	function not_false($value) {
		if ( is_array($value) ) {
			foreach ( $value as $v ) {
				if ( $v !== false ) {
					
				} else {
					return false;
				}
			}
			
			return true;
		} else {
			if ( $value !== false ) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Rounds float to 2 decimals
	 *
	 * @param $value
	 *
	 * @return float
	 */
	function round2($value) {
		return round(floatval($value), 2, PHP_ROUND_HALF_UP);
	}
	
	/**
	 * @param $value
	 *
	 * @return string
	 */
	function format_decimal($value) {
		if ( class_exists('Regex') ) {
			$value = Regex::makeFloat($value);
		}
		$value = round2($value);
		
		return number_format($value, 2, ',', '.');
	}
	
	/**
	 * @param $str
	 *
	 * @return float|int
	 */
	function calc_string($str) {
		if ( preg_match('/(\d+)(?:\s*)([\+\-\*\/])(?:\s*)(\d+)/', $str, $matches) !== false ) {
			$operator = $matches[2];
			
			switch ($operator) {
				case '+':
					$p = $matches[1] + $matches[3];
					break;
				case '-':
					$p = $matches[1] - $matches[3];
					break;
				case '*':
					$p = $matches[1] * $matches[3];
					break;
				case '/':
					$p = $matches[1] / $matches[3];
					break;
			}
			
			return $p;
		}
	}
	
	class Field_calculate {
		const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/';
		
		const PARENTHESIS_DEPTH = 10;
		
		/**
		 * @param $input
		 *
		 * @return int|mixed
		 */
		public function calculate($input) {
			if ( strpos($input, '+') != null || strpos($input, '-') != null || strpos($input, '/') != null || strpos($input, '*') != null ) {
				//  Remove white spaces and invalid math chars
				$input = str_replace(',', '.', $input);
				$input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input);
				
				//  Calculate each of the parenthesis from the top
				$i = 0;
				while (strpos($input, '(') || strpos($input, ')')) {
					$input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input);
					
					$i++;
					if ( $i > self::PARENTHESIS_DEPTH ) {
						break;
					}
				}
				
				//  Calculate the result
				if ( preg_match(self::PATTERN, $input, $match) ) {
					return $this->compute($match[0]);
				}
				
				return 0;
			}
			
			return $input;
		}
		
		/**
		 * @param $input
		 *
		 * @return int
		 */
		private function compute($input) {
			$compute = create_function('', 'return ' . $input . ';');
			
			return 0 + $compute();
		}
		
		/**
		 * @param $input
		 *
		 * @return int|string
		 */
		private function callback($input) {
			if ( is_numeric($input[1]) ) {
				return $input[1];
			} elseif ( preg_match(self::PATTERN, $input[1], $match) ) {
				return $this->compute($match[0]);
			}
			
			return 0;
		}
	}
	
	/**
	 * @param        $array
	 * @param        $key
	 * @param string $alt
	 *
	 * @return string
	 */
	function get($array, $key, $alt = "") {
		return ( isset( $aray[$key] ) ? $aray[$key] : $alt );
	}
	
	/**
	 * @param $haystack
	 *
	 * @return mixed
	 */
	function removeEmptyValues($haystack) {
		foreach ( $haystack as $key => $value ) {
			if ( is_array($value) ) {
				$haystack[$key] = array_remove_empty($haystack[$key]);
			}
			
			if ( empty( $haystack[$key] ) ) {
				unset( $haystack[$key] );
			}
		}
		
		return $haystack;
	}
	
	
	
	
	
	
	
	
	
?>