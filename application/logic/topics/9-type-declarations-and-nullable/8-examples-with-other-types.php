<?php
	
	/**
	 * As mentioned before, class type declarations can be used since PHP 5.0:
	 */
	
	class Test {
		
		public $var = 123;
		
	}
	
	function getClassVar(\Test $t) {
		return $t->var;
	}
	
	$Test = new \Test();
	echo getClassVar($Test) . "<br>";

?>