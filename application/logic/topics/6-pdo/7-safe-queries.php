<?php
	
	/**
	 * If you're into security (you really should) you can either use prepared
	 * statements or escape inputs with the quote() method to prevent your
	 * database being fucked up by sql injection.
	 */
	
	# Let's say this is some value from GET
	$userinput = "<b>Bold</b> for later XSS and sql-injection: '; DELETE FROM test;";
	
	# Make it safe:
	$db->exec("INSERT INTO `test` SET `test` = " . $db->quote($userinput));
	
	# That's it - your database is safe now.
	
	# Now let's print this in a safe way
	$Data = $db->query("SELECT * FROM `test` WHERE `id` = " . $db->quote($db->lastInsertId()))->fetch();
	echo htmlspecialchars($Data['test'], ENT_QUOTES, 'utf-8');
	
	# This is all you have to do to prevent XS and sql injection. There's nothing more.

?>