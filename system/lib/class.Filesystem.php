<?php
	
	
	/**
	 * Class Filesystem
	 */
	class Filesystem {
		
		/**
		 * Get file contents
		 *
		 * @param $file
		 *
		 * @return bool|string
		 */
		public static function readFile($file) {
			return file_get_contents($file);
		}
		
		/**
		 * Delete file
		 *
		 * @param $file
		 *
		 * @return bool
		 */
		public static function delete($file) {
			return unlink($file);
		}
		
		/**
		 * Returns the first matching file in a specific folder
		 *
		 * @param $path
		 * @param $pattern
		 *
		 * @return bool
		 */
		public static function matchingFileExists($path, $pattern) {
			
			$Directory = new RecursiveDirectoryIterator($path);
			$Iterator  = new RecursiveIteratorIterator($Directory);
			$Files     = new RegexIterator($Iterator, '/.+?\.php/i', RecursiveRegexIterator::MATCH);
			
			foreach ($Files as $file) {
				if (Regex::match($pattern, $file->getFilename())) {
					return $file->getFilename();
				}
			}
			
			return false;
		}
		
		/**
		 * Returns an array of all files in a specific folder
		 *
		 * @param $folder
		 *
		 * @return DirectoryIterator[]
		 */
		public static function getFiles($folder) {
			$Directory = new DirectoryIterator($folder);
			$Iterator  = new IteratorIterator($Directory);
			$Files     = new RegexIterator($Iterator, '/.+/i', RegexIterator::MATCH);
			
			$Result = [];
			
			foreach ($Files as $file) {
				if (Regex::match('/^\.\.?$/i', $file->getFilename())) {
					continue;
				}
				if (is_file($file->getPathname())) {
					$Result[] = [
						'filename' => $file->getFilename(),
						'pathname' => $file->getPathname(),
					];
				}
			}
			
			return $Result;
		}
		
		/**
		 * @param $folder
		 *
		 * @return DirectoryIterator[]
		 */
		public static function getFolders($folder) {
			
			# Use DirectoryIterator and RegexIterator
			$Directory = new \DirectoryIterator($folder);
			$Iterator  = new \IteratorIterator($Directory);
			$Files     = new \RegexIterator($Iterator, '/.+/i', \RegexIterator::MATCH);
			
			# This is where the results are stored (associative by filename and pathname)
			$Result = [];
			
			# Iterate through results
			foreach ($Files as $file) {
				
				# Check if current result is "." or ".." and skip
				if (Regex::match('/^\.\.?$/i', $file->getFilename())) {
					continue;
				}
				
				# Check if result is a directory and not a file
				if (is_dir($file->getPathname())) {
					
					# Push results into $Result array
					$Result[] = [
						'filename' => $file->getFilename(),
						'pathname' => $file->getPathname(),
					];
				}
			}
			
			return $Result;
		}
		
	}


?>