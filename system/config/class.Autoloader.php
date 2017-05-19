<?php
	
	/**
	 * Class Autoloader
	 */
	class Autoloader {
		
		private $namespace;
		
		/**
		 * Autoloader constructor.
		 *
		 * @param null $_namespace
		 */
		public function __construct($_namespace = null) {
			$this->namespace = $_namespace;
		}
		
		/**
		 *
		 */
		public function register() {
			spl_autoload_register([ $this, 'load' ]);
		}
		
		/**
		 * @param $name
		 */
		public function load($name) {
			if ( $this->namespace !== null ) {
				$name = str_replace($this->namespace . '\\', '', $name);
			}
			
			$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
			
			$path = '.';
			
			$Types = [
				'class',
				'interface',
				'abstract'
			];
			
			$Files = [];
			
			foreach($Types as $Type){
				$Files[] = $path . '/system/lib/' . $Type . '.' . $name . '.php';
			}
			
			foreach ( $Files as $file ) {
				if ( file_exists($file) ) {
					require_once $file;
				}
			}
			
		}
		
	}