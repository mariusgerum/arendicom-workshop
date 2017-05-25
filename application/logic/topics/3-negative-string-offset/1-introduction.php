<?php
	
	/**
	 * I'm sure you already knew that a char in a string
	 * is accessible over its index. PHP version 7.1 and up
	 * allows us to pass a negative string offset.
	 */
	
	$str = "Hello world!";
	
	echo "Last char of str is &quot;" . $str[-1] . "&quot;.<br>";
	
	# The same is also possible with plain strings:
	echo "Next-to-last char of &quot;abcdef&quot; is &quot;" . "abcdef"[-2] . "&quot;.<br>";
	
	# This will be automatically parsed in strings as well:
	echo "First char of str is $str[0].<br>";
	
	# However, i'd recommend to always use the curly-syntax for string interpolations or
	# alternatively, concatenate strings with expressions.
	echo "First char of str is {$str[0]}.<br>";

?>