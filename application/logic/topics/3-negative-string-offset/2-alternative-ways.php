<?php
	
	/**
	 * The same behavior is also available in PHP
	 * versions lower than 7.1, in substr for example.
	 */
	
	# Getting the last char with substr
	$str = "Hello world!";
	echo "Last char of str is &quot;" . substr($str, -1, 1) . "&quot;.<br>";

?>