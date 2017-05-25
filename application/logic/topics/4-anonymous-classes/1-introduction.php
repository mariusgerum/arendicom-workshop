<?php
	
	/**
	 * In PHP version 7 you can use anonymous classes
	 * as throwaway-objects. Therefore a "new class" can
	 * be passed to a method or function.
	 */
	class A {
		
		/**
		 * This function expects some value of unknown type (so
		 * obviously this could be a class) and returns its
		 * property "SomeProperty".
		 *
		 * Note that we're using the null-coalescing operator ;)
		 *
		 * @param $someClass
		 *
		 * @return mixed
		 */
		public function doSomething($someClass) {
			return $someClass->SomeProperty ?? "Property &quot;SomeProperty&quot; not found in argument of type " . gettype($someClass) . ".";
		}
		
	}
	
	# Make an object (instance) of \A ...
	$A = new \A();
	
	# ... and call doSomething(...)
	echo $A->doSomething(new class {
		public $SomeProperty = 123;
	});
	
	echo "<br>";
	
	# Do the same with some other value
	echo $A->doSomething("Hello World!");
	
	# Yeah, cool stuff ... let's never ever talk about that
	# anonymous classes thingy ... sshhhhh

?>