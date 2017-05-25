<?php
	
	/**
	 * Check some of these awesome fetch modes:
	 */
	
	# Numeric indexing
	echo pre($db->query("SELECT * FROM `test`")->fetch(PDO::FETCH_NUM));
	
	# Both numeric and associative indexing
	echo pre($db->query("SELECT * FROM `test`")->fetch(PDO::FETCH_BOTH));
	
	# Lazy
	echo pre($db->query("SELECT * FROM `test`")->fetch(PDO::FETCH_LAZY));
	
	# Fetch as object
	echo pre($db->query("SELECT * FROM `test`")->fetch(PDO::FETCH_OBJ));
	
	# Serialized fetch
	echo pre($db->query("SELECT * FROM `test`")->fetch(PDO::FETCH_SERIALIZE));
	
	# Associative array indexing
	echo pre($db->query("SELECT * FROM `test`")->fetch(PDO::FETCH_ASSOC));
	
	/**
	 * And much, much more ...
	 * Check the PDO constants: http://php.net/manual/en/pdo.constants.php
	 */

?>