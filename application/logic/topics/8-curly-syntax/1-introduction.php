<?php
	
	/**
	 * The so-called curly syntax is an awesome way to "embed" scalar variables,
	 * arrays and even objects with a string representation in your preferred
	 * string output method (echo, print, ... whatever) by wrapping them into
	 * curly braces {}.
	 *
	 * There are some rules
	 * - The $-sign has to be the very-next char after the opening "{"
	 * - To use the $-sign literally, it can be escaped (\$)
	 * - Type conversion or expressions won't work
	 * - Constants (both declared with define or class constants) won't work
	 *
	 * It simply depends on your own preferences wheter to use
	 * curly-syntax or concatenation (which provides the flexibility for
	 * expressions).
	 */
	
	$var = "World";
	echo "Hello {$var}!<br>";
	
	# This won't work as expected (because of the space):
	echo "Hello { $var}!<br>";
	
	# Actually this works too, but i'd not recommend to use it
	# that way:
	echo "Hello ${var}!<br>";
	
	# Example with arrays
	$arr = ['World', 'Universe'];
	echo "Hello {$arr[1]}!<br>";
	
	# ... with multi-dimensional arrays
	
	$mdArray = [
		[
			'name' => 'John',
		],
	];
	
	echo "Hello {$mdArray[0]['name']}!<br>";
	
	# And with objects:
	
	class Test {
		
		public $str = "World";
		public $arr = ['World', 'Universe'];
		
	}
	
	$Test = new \Test();
	
	echo "Hello {$Test->str}!<br>";
	echo "Hello {$Test->arr[1]}!<br>";

?>