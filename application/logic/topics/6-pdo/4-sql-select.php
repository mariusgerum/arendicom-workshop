<?php
	
	/**
	 * There are a few methods to fetch rows from a database/table:
	 *
	 * - fetch()        Fetches one single row.
	 * - fetchAll()     Fetches all records according to the PDO fetch_mode
	 * - fetchColumn()  Fetches a single column from the next row of a result-set
	 * - fetchObject()  Fetches the next row and returns an object
	 *
	 * The current fetchMode (array, object, much more...) can be set either by
	 * using setFetchMode() for the current statement, with this awesome
	 * setAttribute() method that applies to all actions or as previously shown
	 * passed directly to the PDO constructor as $options argument.
	 *
	 * More:
	 * setAttribute()     http://php.net/manual/de/pdo.setattribute.php
	 * fetchAll()         http://php.net/manual/de/pdostatement.fetchall.php
	 * fetchColumn()      http://php.net/manual/de/pdostatement.fetchcolumn.php
	 * fetch()            http://php.net/manual/de/pdostatement.fetch.php
	 * fetchObject()      http://php.net/manual/de/pdostatement.fetch.php
	 * setFetchMode()     http://php.net/manual/de/pdostatement.setfetchmode.php
	 */
	
	# Fetch a single row
	# As you can see there is no WHERE clause, so it fetches the first row
	# according to current sorting algorithm (can be set in database or
	# using the ORDER BY clause)
	# Values are directly accessible from an associative array
	$Data = $db->query("SELECT * FROM `test`")->fetch();
	echo pre($Data);
	# Print test field
	echo $Data['test'] . "<br>";
	
	# Fetch all rows
	$Data = $db->query("SELECT * FROM `test`")->fetchAll();
	echo pre($Data);
	# Print test field of the first row:
	echo $Data[0]['test'] . "<br>";
	
	# Fetch object
	$Data = $db->query("SELECT * FROM `test`")->fetchObject();
	echo pre($Data);
	# Print test field
	echo $Data->test;

?>