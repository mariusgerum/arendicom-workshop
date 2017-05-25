<?php
	
	/**
	 * Unfortunetely, PHP does neither require nor support explicit
	 * type definitions when ->declaring<- a variable.
	 *
	 * But it provides us an awesome way to explicitly set the
	 * type definition for variables - in fact it's more a "conversion".
	 * This can either be done with the built-in functions intval(),
	 * strval(), floatval(), boolval() and so on, but i'd recommend
	 * to set types with paranthesis, because it's more common
	 * (see C or Java for example) and should not be done with "functions".
	 */
	
	
	$var = "123";
	echo gettype($var) . "<br>"; // String
	
	$var = (int)$var;
	echo gettype($var) . "<br>"; // Integer
	
	# !!! And THIS (code above) is the only right and proper way to
	# work with types. And (awesomeness starts here) you can use
	# this directly when declaring variables as well:
	
	$var = (int)123;
	
	# ... although it may seems like kind of unnecessary to use
	# this on declarations.
	# But, however, what happens here is actually declaring,
	# initialising AND converting the value of a variable before
	# the actual assignment.
	
	# By the way, when declaring variables, please DON'T use some
	# shitty mess like this one:
	
	$var = (int)"123";
	
	# You see, this makes no sense. Sure, it works. But ... just don't.

?>