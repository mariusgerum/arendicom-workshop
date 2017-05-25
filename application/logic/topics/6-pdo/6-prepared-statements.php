<?php
	
	/**
	 * PDO supports prepared statements (like mysqli does).
	 */
	
	# Prepare a statement
	$stmt = $db->prepare("INSERT INTO `test` SET `test` = :test_value");
	
	# Bind values to it
	$stmt->bindValue(':test_value', 'Some text');
	
	# Execute the statement
	$stmt->execute();
	
	# There's one more solution to bind values to prepared statements,
	# using bindParam(). The difference is that the variable is bound as
	# a reference.
	
	$value = "abc";
	$stmt = $db->prepare("INSERT INTO `test` SET `test` = :test_value");
	$stmt->bindParam(':test_value', $value);
	$value = "123";
	# This will insert "123".
	$stmt->execute();

?>