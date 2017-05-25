<?php
	
	/**
	 * The PDO extension (PHP Data objects) provides a simple, consistent
	 * object-orientated access to multiple types of databases. In most
	 * cases, where mysql is used, the PDO_MYSQL driver is required.
	 * PDO is includet in PHP 5.1 (and as PECL extension available for PHP 5.0)
	 *
	 * The following drivers implement the PDO interface already:
	 * -------------------------------------------------------------
	 * PDO_CUBRID           Cubrid
	 * PDO_DBLIB            FreeTDS / Microsoft SQL Server / Sybase
	 * PDO_FIREBIRD         Firebird
	 * PDO_IBM              IBM DB2
	 * PDO_INFORMIX         IBM Informix Dynamic Server
	 * PDO_MYSQL            MySQL 3.x/4.x/5.x
	 * PDO_OCI              Oracle Call Interface
	 * PDO_ODBC             ODBC v3 (IBM DB2, unixODBC und win32 ODBC)
	 * PDO_PGSQL            PostgreSQL
	 * PDO_SQLITE           SQLite 3 und SQLite 2
	 * PDO_SQLSRV           Microsoft SQL Server / SQL Azure
	 * PDO_4D               4D
	 *
	 * PDO works with a "dataaccess abstraction layer" which allows
	 * programmers to connect to databases of different types.
	 *
	 * NOTE: PDO is not a dataBASE abstraction layer, that means you
	 * have to submit the sql statements by yourself. If you'd like to access
	 * multiple DBMS then take a look at doctrine.
	 *
	 */
	
	# Advantages:
	# - PDO forces a object-oriented usage
	# - Prepared statements has been improved
	# - Access to multiple databases management systems
	# - PDO throws catchable Exceptions
	# - Can be combined with SPL iterators

?>