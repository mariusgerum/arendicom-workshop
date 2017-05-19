<?php
	
	/**
	 * Class ErrorHandling
	 */
	class ErrorHandling {
		
		/**
		 * Trigger error
		 * @param      $message
		 * @param bool $exit
		 */
		public static function error($message, $exit = true){
			if($exit){
				exit($message);
			}else{
				echo "<p>Error: {$message}</p>";
			}
		}
		
	}

?>