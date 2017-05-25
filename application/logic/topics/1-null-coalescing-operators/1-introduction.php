<?php
	
	/**
	 * The null-coalescing operator is a ternary-like operator
	 * that returns the first operand if it's not null.
	 *
	 * Note: null-coalescing operator doesn't care if the expression or
	 * value is evaluated to false.
	 */
	
	# Let's say we' like to assign a specific GET parameter, but
	# only if it's set (so its values isn't null), otherwise
	# let's assign some text.
	
	$name = $_GET['name'] ?? "name is not set";
	
	echo $name;

?>