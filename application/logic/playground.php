<?php
	
	declare(strict_types=1);
	
	function test($value): string {
		return $value;
	}
	
	echo test((string)123);

?>