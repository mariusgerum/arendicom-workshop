<?php
	
	/**
	 * Variables can also be assigned by reference.
	 */
	
	$a = "Hello world!";
	
	echo $a . "<br>";
	
	# Now let's declare $b and reference it to $a
	$b = &$a;
	$b = "some text";
	
	echo $a . "<br>";
	echo $b . "<br>";
	
	# Each variable has a so-called "pointer" which refers to the exact
	# address in memory where its value is actually stored.
	# With an usual assignment you just make a copy of this value and
	# pointer. But by using a variable by referencing to another variable,
	# you change the pointer of the existing variable in a way it
	# points to your new declared one.

?>