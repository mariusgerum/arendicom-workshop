<?php
	
	# Start session
	@session_start();
	
	
	# DIR
	define('DIR', '.');
	
	# Require autoloader
	require_once DIR . '/system/config/class.Autoloader.php';
	
	# Autoloading magic
	$Autoloader = new Autoloader();
	$Autoloader->register();
	
	# Debug mode prints error messages and stuff
	define('DEBUG', true);
	
	if (DEBUG) {
		@ini_set('display_errors', 1);
		@error_reporting(E_ALL);
	}
	
	# Maintenance mode
	define('MAINTENANCE', false);
	
	if (MAINTENANCE || file_exists('./.maintenance')) {
		exit("Maintenance ... please try again later.");
	}
	
	require_once DIR . '/system/config/functions.php';
	
	# Sections Separator
	define('DS', DIRECTORY_SEPARATOR);
	
	# AjAX delay
	define('AJAX_DELAY', 160000);
	
	# Default page
	define('DEFAULT_PAGE', 'welcome');
	define('DEFAULT_TEMPLATE', 'default');
	
	/**
	 * php.ini settings
	 */
	ini_set('memory_limit', '256M');
	ini_set('max_execution_time', 60);
	ini_set('post_max_size', '8M');
	ini_set('upload_max_filesize', '8M');
	
	# Load request handler
	Request::init();

?>