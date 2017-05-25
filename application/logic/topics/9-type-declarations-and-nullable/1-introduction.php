<?php
	
	declare(strict_types=1);
	
	/**
	 * Type declaration means the explicit declaration of a variable
	 * or function parameter with a specific type.
	 *
	 * Since version 5.0 PHP supports type declarations for classes
	 * or interfaces (and self). Array type is implemented since
	 * version 5.1.0 and callable since 5.4.0.
	 *
	 * With PHP 7.0 scalar types are supported as well:
	 * - bool
	 * - int
	 * - float
	 * - string
	 *
	 * ==== How to activate strict types?
	 * To activate strict type declaration the declare statement
	 * must be used, and it has to be the VERY FIRST STATEMENT in
	 * a script (see above).
	 * There's one more benefit of using strict_types: your IDE
	 * (e.g. NetBeans or PhpStorm) automatically recognizes if you
	 * are messing around when passing arguments to a function
	 * or method.
	 *
	 * ==== Could / should we enable strict types for E-SHOP-DIRECT?
	 * Don't you dare even thinking about something like that!
	 * Enabling strict_types in ESHOPDIRECT would immediately open the
	 * gate to a new dimension of demonic hell - only "thanks" to PHPs
	 * sloppy use of type declarations and implicit-casting this
	 * whole bunch of mess can be handled.
	 * That's no ones but PHPs fault, just saying ;)
	 * But it'd be a desirable achievement, so let's keep this in mind.
	 *
	 * ==== IMPORTANT THINGS
	 * - Typehints and -declarations can only be successful applied when
	 *   strict_types are enabled.
	 * - Do not confuse "bool" with "boolean" ;)
	 * - PHP does no implicit type conversion when strict_types are enabled
	 *
	 */
	
	# An example with integer:
	
	/**
	 * Returns negative number
	 *
	 * @param int $num
	 *
	 * @return int
	 */
	function makeNegative(int $num) {
		return (abs($num) * -1);
	}
	
	# Works like a charm
	echo makeNegative(5) . "<br>";
	
	# This is not allowed
	echo makeNegative("5") . "<br>";
	
	# With strict types enabled, PHP doesn't even implicit cast
	# types, so passing a float is also not allowed
	# (Of course you can't see the output because the code
	# above threw a fatal error already - but you can trust me)
	echo makeNegative(5.0);

?>