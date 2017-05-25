<?php
	
	/**
	 * Connections can be established by creating an instance of the
	 * PDO base class. Therefore, a DSN (data source name) has to be
	 * passed to the constructor as well as the database user and
	 * password. The 4th argument with options turns out to be a
	 * pretty useful thing to do.
	 *
	 * Note: You'll find this in index.php with $db PDO instance for
	 * all following examples
	 */
	
	# Data source name
	$my_dsn = "mysql:host=localhost;dbname=test;charset=utf8";
	
	# Some options
	$pdo_options = [
		# Natural case
		\PDO::ATTR_CASE               => \PDO::CASE_NATURAL,
		
		# Error mode
		\PDO::ATTR_ERRMODE            => (DEBUG ? \PDO::ERRMODE_WARNING : \PDO::ERRMODE_SILENT),
		
		# Fetch mode (associative array or object is the best choice in most cases)
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
	];
	
	$pdo = null;
	
	try {
		# Make an object of PDO base class
		$pdo = new \PDO($my_dsn, 'test', 'YUmV0l7R46c1vbiZ6BXyZ8So2pdFR');
	} catch (\Exception $e) {
		exit($e->getMessage());
	}
	
	/**
	 * NOTE: For all database examples there is a database "test" with
	 * table "test" and fields "id" (auto_increment, primary)
	 * and "test" (varchar(4096)
	 */
	
?>