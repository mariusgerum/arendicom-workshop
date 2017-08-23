<?php
	
	/**
	 * Secure HTML output to prevent XSS
	 *
	 * @param $value
	 *
	 * @return string
	 */
	function e($value) {
		return @htmlspecialchars($value, ENT_QUOTES, 'utf-8');
	}
	
	/**
	 * Pretty array/objects output
	 *
	 * @param $value
	 *
	 * @return string
	 */
	function pre($value) {
		return "<pre>" . print_r($value, 1) . "</pre>";
	}

?>
