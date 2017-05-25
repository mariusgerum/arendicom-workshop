<?php
	
	/**
	 * The spaceship-operator compares to expressions and returns one out
	 * of three possible values: -1, 0 or 1 which respectively determines
	 * if the first expression is less, equal or greater than the second expression.
	 */
	
	# The spaceship-expression is written as "<=>". Ahoy
	echo (5 <=> 5) . "<br>";
	echo (5 <=> 10) . "<br>";
	echo (10 <=> 5) . "<br>";
	
	# According to the php.net manual, comparisons with the spaceship-operator
	# are performed like PHP's usual type comparison rules.
	echo ("a" <=> "a") . "<br>";
	echo ("a" <=> "z") . "<br>";
	echo ("z" <=> "a") . "<br>";
	
	echo (1.0 <=> 1.0) . "<br>";
	echo (1.0 <=> 1.5) . "<br>";
	echo (1.5 <=> 1.0) . "<br>";

?>