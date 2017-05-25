<?php
	
	/**
	 * There are 2 methods to execute statements in the database:
	 *
	 * - query()  For select statements and fetching rows
	 * - exec()   For insert, update or delete statements
	 */
	
	# exec() returns one out of three possible values:
	# - The number of affected rows during an insert, update or delete
	# - 0 if no rows has been affected
	# - null if an error occured
	
	# INSERT example
	$res = $db->exec("INSERT INTO `test` SET `test` = 'Hello'");
	echo pre($res);
	
	# Get last insert id
	$lid = $db->lastInsertId();
	
	# Update the row we juts created
	$res = $db->exec("UPDATE `test` SET `test` = 'Hello world!' WHERE `id` = '{$lid}'");
	echo pre($res);
	
	# So let's see what we got there and fetch all rows:
	$Data = $db->query("SELECT * FROM `test`")->fetchAll();
	echo pre($Data);

?>