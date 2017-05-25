<?php
	
	declare(strict_types=1);
	
	/**
	 * Returns "Yes" or "No" depending on boolean argument
	 *
	 * @param bool $bool
	 *
	 * @return string
	 */
	function YesOrNo(bool $bool) {
		return $bool ? 'Yes' : 'No';
	}
	
	echo YesOrNo(true) . "<br>";
	echo YesOrNo(false) . "<br>";
	
	# And here again, this works with explicit type casting for strings ...
	echo YesOrNo((bool)"Not an empty string") . "<br>";
	echo YesOrNo((bool)"") . "<br>";
	
	# ... for integers
	echo YesOrNo((bool)1) . "<br>";
	echo YesOrNo((bool)0) . "<br>";
	
	# ... for arrays
	echo YesOrNo((bool)['some value']) . "<br>";
	echo YesOrNo((bool)[]) . "<br>";
	
	# ... and so on

?>