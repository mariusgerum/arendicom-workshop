<?php
	
	declare(strict_types=1);
	
	/**
	 * This also works for the scaler type "string". The passed
	 * argument hat to be a valid string or at least wrapped in
	 * double or single quotes.
	 */
	
	/**
	 * Returns first char of a string
	 *
	 * @param string $str
	 *
	 * @return mixed
	 */
	function getFirstChar(string $str) {
		return $str[0];
	}
	
	# This works
	echo getFirstChar("Test") . "<br>";
	
	
	/**
	 * You can pass variables of scalar types int and float as long as
	 * they're wrapped in double-quotes or they were casted before.
	 */
	
	# An integer, obviously
	$number = intval(123);
	
	# And yes, this works. It wouldn't if there were no quotes.
	# Note: this is just an example of how definitely NOT to work
	# with strict_types (bad practice).
	echo getFirstChar("$number") . "<br>";
	
	# The same works with explicit type casting:
	# Note: this solution is fine and safe to use
	echo getFirstChar(strval($number)) . "<br>";
	
	# Or try that one - simply depends on your preference of type casting
	echo getFirstChar((string)$number) . "<br>";

?>