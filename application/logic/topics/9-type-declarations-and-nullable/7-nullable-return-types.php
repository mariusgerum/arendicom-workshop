<?php
	
	declare(strict_types=1);
	
	/**
	 * Return types can also be marked as nullable
	 */
	
	/**
	 * Returns the given argument
	 *
	 * @param $value
	 *
	 * @return bool|null
	 */
	function returnArgs($value): ?bool {
		return $value;
	}
	
	# This will return null
	echo gettype(returnArgs(null)) . "<br>";
	
	# This will return boolean
	echo gettype(returnArgs(true)) . "<br>";
	
	# This will not, because its not null and not a boolean value
	echo gettype(returnArgs(0)) . "<br>";

?>