<?php
	
	/**
	 * Don't confuse null-coalescing operators with the
	 * if-shorthand-syntax (especially with the more-short-syntax "?:").
	 */
	
	# $x is clearly not defined at this point
	$var = $x ?? "x is not set";
	
	echo $var . "<br>";
	
	# So let's take a look at the PHP if-shorthand syntax.
	# This will create a "Notice: undefined variable":
	$var = ($x ? $x : "x is not set");
	
	# That's because the if-shorthand syntax checks if the first
	# expression ($x) evaluates to true or not. There's no code
	# that verifies if $x exists.
	
	# Therefore, the same notice also appears by using the questionmark-colon operator
	$var = $x ?: "x is not set";
	
	# But we can check for true or false
	$var = false ?: "is not true";
	echo $var . "<br>";
	
	/**
	 * Actually we cannot do the same with the ?: operator as with
	 * the null-coalescing operator
	 */
	
	# Let's declare $x for this example
	$x = "Hello world";
	$var = isset($x) ?: "x is not set";
	
	echo $var;
	
	# This cannot work because if $x is set, $var is not assigned with
	# the value of $x but with the expression evaluated through
	# isset (which can either be true or false). So as you cann see
	# in the output, $var has the value "1".

?>