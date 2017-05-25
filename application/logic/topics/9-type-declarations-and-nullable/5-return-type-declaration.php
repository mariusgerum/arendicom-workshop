<?php
	
	declare(strict_types=1);
	
	/**
	 * Type declaration also works for function return values.
	 */
	
	/**
	 * Returns true if $number is negative
	 *
	 * @param float $number
	 *
	 * @return bool
	 */
	function isNegativeNumber(float $number): bool {
		return ($number < 0);
	}
	
	$num = -5;
	
	echo $num . " is " . (isNegativeNumber($num) ? '' : 'not') . " a negative number.<br>";
	
	# Let's see what happens when the return value doesn't match
	
	/**
	 * Returns the passed argument
	 *
	 * @param $value
	 *
	 * @return string
	 */
	function returnString($value): string {
		return $value;
	}
	
	# This works:
	echo returnString("some text") . "<br>";
	
	# This works
	echo returnString((string)123) . "<br>";
	
	# And this works too
	echo returnString((string)true) . "<br>";
	
	# This will end up with a fatal error, because the function is forced to
	# return a value of another type as "string":
	echo returnString(123) . "<br>";

?>