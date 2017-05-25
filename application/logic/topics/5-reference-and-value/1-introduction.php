<?php
	
	/**
	 * In most programming languages, values can be passed in
	 * two ways to a function:
	 * - by value
	 * - by reference
	 *
	 * You've been using some sorting-functions like "asort", and
	 * these (and some more) are processing the arguments by reference.
	 *
	 * Usually you pass arguments by value, which means that the function
	 * or method receives just a copy of the value.
	 *
	 * Passing arguments by reference means really moving a
	 * real variable into that function, where it may be modified.
	 * So passing arguments by reference affects the actual, real
	 * variable (or rather its value).
	 *
	 */
	
	$value = "Hello World! ";
	
	function test_by_value($arg) {
		$arg = $arg . $arg;
	}
	
	function test_by_reference(&$arg) {
		$arg = $arg . $arg;
	}
	
	echo $value . "<br>";
	
	test_by_value($value);
	
	echo $value . "<br>";
	
	test_by_reference($value);
	
	echo $value . "<br>";

?>