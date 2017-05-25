<?php
	
	/**
	 * We all know PHPs weakest point: strict types. So it comes that
	 * PHP makes use of implicit type conversion (and declaration).
	 *
	 * By declaring a variable, PHP determines its type by the context
	 * in which these variable is used and/or initialised.
	 *
	 * The first code example is about of what happens internally when
	 * declaring and initialising a value:
	 */
	
	# String
	$var = "123";
	echo gettype($var) . "<br>";
	
	# Integer
	$var = 123;
	echo gettype($var) . "<br>";
	
	# Float / double
	$var = 123.0;
	echo gettype($var) . "<br>";
	
	# Boolean
	$var = false;
	echo gettype($var) . "<br>";
	
	/**
	 * As said above, PHP converts the type of a variable in the context in
	 * which it is used - even if the variable has been declared with another
	 * type before.
	 */
	
	$str = "1";
	echo gettype($str) . "<br>"; // String
	
	$str++;
	echo gettype($str) . "<br>"; // Integer now
	
	$str /= 3;
	echo gettype($str) . "<br>"; // Now a float/double
	
	/**
	 * That's some fascinating but still fucked up magic, because that's not
	 * how types should be used (or better said "not" used) - although
	 * it's a pretty comfy way to do so, which, on the other hand, doesn't
	 * really support programmers with writing clean and awesome code.
	 * In most other programming languages the programmer is forced to learn
	 * correct type handling from the bottom.
	 */

?>