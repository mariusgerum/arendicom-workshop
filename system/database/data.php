<?php
	
	/**
	 * Database credentials and settings
	 */
	$DatabaseCredentials = [
		
		# System
		'system' => [
			'host' => 'localhost',
			'username' => 'fbsystem',
			'password' => 'ymuBNL8WVi9J8EcBRRZ5pOdeJonfpwJi3vT2ORzNFBhzFfZRt6drl0kxPUtFAr1h',
			'database' => 'fastbilling',
			'options' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL,
				PDO::ATTR_ERRMODE => (DEBUG ? PDO::ERRMODE_WARNING : PDO::ERRMODE_SILENT),
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]
		],
		
		# User
		'user' => [
			'host' => 'localhost',
			'username' => 'fbuser',
			'password' => 'ePU8maV8HbjQn16bPcQJEaz8PRoLwljIglVJ9l00FMpgF4WGHW4ipQ4Zrhxb3dhD',
			'database' => '{{DATABASE}}',
			'options' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL,
				PDO::ATTR_ERRMODE => (DEBUG ? PDO::ERRMODE_WARNING : PDO::ERRMODE_SILENT),
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]
		]
	
	];

?>