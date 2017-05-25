<?php
	
	declare(strict_types=1);
	
	/**
	 * You can't pass float values to a function who expects
	 * an int, but you can pass an int to a function that
	 * expects a float.
	 */
	
	/**
	 * Returns float as int
	 *
	 * @param float $num
	 *
	 * @return float
	 */
	function justReturn(float $num) {
		return $num;
	}
	
	echo justReturn(5) . "<br>";
	
	# That's because an incoming integer can be handled as
	# a float (so 5 becomes 5.0).

?>