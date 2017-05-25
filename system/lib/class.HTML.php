<?php
	
	class HTML {
		
		private static $fixed = false;
		
		/**
		 * @param        $title
		 * @param string $value
		 *
		 * @return string
		 */
		public static function success($title, $value = "") {
			$text = "";
			if ($value == '') {
				$text = $title;
			} else {
				$text = "<strong>" . $title . "</strong><br>" . $value;
			}
			$f = self::$fixed;
			self::$fixed = "";
			
			return "<div class='alert alert-success" . $f . "'><i class='fa fa-check'></i> {$text}</div>";
		}
		
		/**
		 * @param        $title
		 * @param string $value
		 * @param string $type Type of alert [alert|note]
		 *
		 * @return string
		 */
		public static function info($title, $value = "", $type = 'alert') {
			$text = "";
			if ($value == '') {
				$text = $title;
			} else {
				$text = "<strong>" . $title . "</strong><br>" . $value;
			}
			$f = self::$fixed;
			self::$fixed = "";
			
			return "<div class='" . $type . " " . $type . "-info" . $f . "'><i class='fa fa-info-circle'></i> {$text}</div>";
		}
		
		/**
		 * @param        $title
		 * @param string $value
		 *
		 * @return string
		 */
		public static function danger($title, $value = "") {
			$text = "";
			if ($value == '') {
				$text = $title;
			} else {
				$text = "<strong>" . $title . "</strong><br>" . $value;
			}
			$f = self::$fixed;
			self::$fixed = "";
			
			return "<div class='alert alert-danger" . $f . "'><i class='fa fa-exclamation-circle'></i> {$text}</div>";
		}
		
		/**
		 * @param        $title
		 * @param string $value
		 *
		 * @return string
		 */
		public static function warning($title, $value = "") {
			$text = "";
			if ($value == '') {
				$text = $title;
			} else {
				$text = "<strong>" . $title . "</strong><br>" . $value;
			}
			$f = self::$fixed;
			self::$fixed = "";
			
			return "<div class='alert alert-warning" . $f . "'><i class='fa fa-warning'></i> {$text}</div>";
		}
		
	}

?>