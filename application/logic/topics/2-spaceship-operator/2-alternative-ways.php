<?php
	
	/**
	 * If we want to do the same with PHP version lower than 7, we can
	 * do that using a few if-statements or with if shorthand-syntax.
	 */
	
	# The following, nested if shorthand-syntax does exactly the same as
	# the spaceship-operator does - although this looks a bit weird somehow.
	# However, this is the shortest alternative solution for
	# lazy f*cks programmers usually are:
	
	$var = 5;
	echo($var == 10 ? 0 : ($var < 10 ? -1 : 1));
	
	echo "<br>";
	
	# Actually we could use this logic and put it in a nice,
	# re-usable function to have the same functionality in
	# PHP 5.x applications as the spaceship operator provides
	# with PHP 7.
	
	/**
	 * Returns -1, 0 or 1
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	function spaceship($a, $b) {
		return ($a == $b ? 0 : ($a < $b ? -1 : 1));
	}
	
	echo spaceship(5, 10);
	
	# Of course you can write several if statements or switch-case blocks,
	# but ... nah, you're awesome, aren't you?

?>