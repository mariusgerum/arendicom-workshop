<?php
	
	require_once './system/config/core.php';
	
	/**
	 * Database connection
	 */
	
	# Data source name
	$dsn = "mysql:host=localhost;dbname=test;charset=utf8";
	
	# Some options
	$options = [
		# Natural case
		\PDO::ATTR_CASE               => \PDO::CASE_NATURAL,
		
		# Error mode
		\PDO::ATTR_ERRMODE            => (DEBUG ? \PDO::ERRMODE_WARNING : \PDO::ERRMODE_SILENT),
		
		# Fetch mode (associative array or object is the best choice in most cases)
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
	];
	
	$db = null;
	
	try {
		# Make an object of PDO base class
		$db = new \PDO($dsn, 'test', 'YUmV0l7R46c1vbiZ6BXyZ8So2pdFR', $options);
	} catch (\Exception $e) {
		exit($e->getMessage());
	}
	
	/**
	 * =====================
	 * AjAX handler
	 * =====================
	 */
	if ( isset( $_GET['ajax'] ) ) {
		if ( isset( $_GET['action'] ) ) {
			
			usleep(AJAX_DELAY);
			$Action = Request::Both('action');
			$Actions = explode('.', Request::Both('action'));
			if ( count($Actions) >= 2 ) {
				$function = $Actions[count($Actions) - 1];
				array_pop($Actions);
				$path = implode('/', $Actions);
				
				if ( file_exists('./application/logic/' . $path . '.php') ) {
					require_once DIR . '/application/logic/' . $path . '.php';
					if ( function_exists($function) ) {
						call_user_func($function);
						
					}
				} else {
					echo HTML::danger("Fehlgeschlagen!", "Die angeforderte Seite konnte nicht geöffnet werden.");
					if ( DEBUG ) {
						HTML::danger("Datei " . $path . " existiert nicht!");
					}
				}
				
			}
		}
		
		return null;
	}
	
	# Load template and render page
	$Template = new \Template();
	$Template->renderPage();
	
?>