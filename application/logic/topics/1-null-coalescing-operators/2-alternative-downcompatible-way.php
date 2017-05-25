<?php
	
	/**
	 * In PHP versions below 7.x you can reach the same behavior
	 * by using the if shorthand-syntax:
	 */
	
	$name = (isset($_GET['name']) ? $_GET['name'] : "name is not set");
	
	echo $name . "<br>";
	
	# As previously told, the null-coalescing operator does neither care about
	# nor evaluate to a boolean value.
	
	$val = false;
	
	# Now check the difference. First we use the default if shorthand-syntax:
	var_dump($val ? "val is evaluated to true" : "val is evaluated to false");
	
	echo "<br>";
	
	# The ?? operator, on the other hand, determines only if the value or expression
	# evaluates to null:
	var_dump($val ?? "val is null");
	echo "<br>";
	var_dump($unknown ?? "unknown is null");

?>