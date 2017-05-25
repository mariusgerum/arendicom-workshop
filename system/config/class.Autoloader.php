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
		 * Register autoloader using SPL
		 */
		public function register() {
			spl_autoload_register([$this, 'load']);
		}
		
		/**
		 * @param $name
		 */
		public function load($name) {
			if ($this->namespace !== null) {
				$name = str_replace($this->namespace . '\\', '', $name);
			}
			
			$name = preg_replace('/.*?\\\/i', '', $name);
			
			# Some naming conventions
			$NameConventions = [
				'class.{name}.php',
				'{name}.class.php',
			];
			
			# Folders to search for classes
			$Folders = [
				'./system/lib/',
				'./system/database/',
			];
			
			$Files = [];
			
			foreach ($Folders as $Folder) {
				foreach ($NameConventions as $NC) {
					$filename = str_replace('{name}', $name, $NC);
					$Files[] = $Folder . $filename;
				}
			}
			
			foreach ($Files as $file) {
				if (file_exists($file)) {
					require_once $file;
				}
			}
			
		}
		
	}