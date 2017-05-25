<?php
	
	declare(strict_types=1);
	
	/**
	 * PHP 7.1 introduces nullable types which can be used for
	 * function parameters and return types.
	 */
	
	# With nullable parameters this function accepts either a valid
	# integer or NULL
	function makeNum(?int $number) {
		return $number ?? 0;
	}
	
	# Integer
	echo makeNum(123) . "<br>";
	
	# Null
	echo makeNum(null) . "<br>";
	
	# Undeclared variable (this will output a "Notice: Undefined variable ...")
	# but also will print "0"
	echo makeNum($unknown) . "<br>";

?>