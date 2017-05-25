<?php
	
	/**
	 * Of course null-coalescing operators can be evaluated inline
	 */
	
	echo "Your name is " . ($_GET['name'] ?? "unfortunately unknown") . ".";

?>