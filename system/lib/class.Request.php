<?php
	
	class Request {
		
		private static $page = null;
		private static $pages = [];
		
		/**
		 * Initialization
		 */
		public static function init() {
			self::trimData();
			if (self::Get('page') != '') {
				$p = self::Get('page');
				$p = Regex::replace('/[^a-z0-9\/]/i', '', $p);
				$p = Regex::replace('/\/+/i', '/', $p);
				self::$page = $p;
				self::$pages = explode('/', self::$page);
			}
		}
		
		/**
		 * Trim data
		 */
		public static function trimData() {
			array_walk_recursive($_GET, 'trim');
			array_walk_recursive($_POST, 'trim');
			array_walk_recursive($_REQUEST, 'trim');
			array_walk_recursive($_SESSION, 'trim');
			array_walk_recursive($_COOKIE, 'trim');
		}
		
		/**
		 * @return null|string
		 */
		public static function page() {
			return self::$page ?? DEFAULT_PAGE;
		}
		
		/**
		 * @param int $key
		 *
		 * @return mixed|null|string
		 */
		public static function getPage($key = 0){
			return self::$pages[$key] ?? self::page();
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		public static function Get($key, $alt = "") {
			return isset($_GET[$key]) ? $_GET[$key] : $alt;
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		public static function Post($key, $alt = "") {
			return isset($_POST[$key]) ? $_POST[$key] : $alt;
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		public static function Both($key, $alt = "") {
			return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $alt;
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		public static function Cookie($key, $alt = "") {
			return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $alt;
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		public static function Session($key, $alt = "") {
			return isset($_SESSION[$key]) ? $_SESSION[$key] : $alt;
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		public static function Files($key, $alt = "") {
			return isset($_FILES[$key]) ? $_FILES[$key] : $alt;
		}
		
	}

?>