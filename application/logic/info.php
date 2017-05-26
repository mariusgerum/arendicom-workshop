<?php
	
	/**
	 * Menu
	 */
	function menu() {
		echo "<a href='javascript:;' class='topic-example ajax' data-action='info.show_phpinfo' data-rc='.rc-topic-content'>PHP info</a>";
		echo "<a href='javascript:;' class='topic-example ajax' data-action='info.server_info' data-rc='.rc-topic-content'>Server info</a>";
	}
	
	/**
	 * phpinfo
	 */
	function show_phpinfo() {
		phpinfo();
	}
	
	/**
	 * Serverinfo
	 */
	function server_info() {
		echo pre($_SERVER);
	}
	
	/**
	 *
	 */
	function setfw() {
		if (!isset($_SESSION['fw'])) {
			$_SESSION['fw'] = true;
		} else {
			unset($_SESSION['fw']);
		}
	}

?>