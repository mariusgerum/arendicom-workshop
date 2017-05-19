<?php
	
	/**
	 * Class Filesystem
	 */
	class Filesystem {
		
		const PERMISSION_USER_DIRECTORY = 750;
		const PERMISSION_USER_SUBDIRECTORY = 750;
		const PERMISSION_USER_SUBDIRECTORY_FILE = 0750;
		
		/**
		 * @param $file
		 *
		 * @return bool|string
		 */
		public static function readFile($file) {
			return file_get_contents($file);
		}
		
		/**
		 * @param $file
		 *
		 * @return bool
		 */
		public static function delete($file){
			return unlink($file);
		}
		
	}

?>