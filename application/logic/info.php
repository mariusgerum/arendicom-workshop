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
	
	function playground() {
		
		$file = './application/logic/playground.php';
		
		if (file_exists($file)) {
			
			$code = file_get_contents($file);
			
			echo "<fieldset><legend>Code editor</legend>";
			echo "<form id='frmCodeEditor'>";
			
			echo "<div class='row form-group'>";
			echo "<div class='col-md-12'>";
			echo "<textarea class='form-control' name='code' rows='16' style=\"font-family: 'courier new';\">" . e($code) . "</textarea>";
			echo "</div>";
			echo "</div>";
			
			echo "<div class='row form-group'>";
			echo "<div class='col-md-6'>";
			echo "<a href='javascript:;' class='btn btn-success ajax-submit' data-action='info.save_code' data-rc='.rc-save-code' data-tc='.trigger-playground-execution' data-form='#frmCodeEditor'><i class='fa fa-save'></i> Save</a>";
			echo "</div>";
			echo "<div class='col-md-6 rc-save-code'>";
			echo "</div>";
			echo "</div>";
			
			echo "</form>";
			echo "</fieldset>";
			
			echo "<br>";
			
			echo "<fieldset><legend>Code output <small>(<a href='javascript:;' class='ajax trigger-playground-execution' data-action='info.exec_playground' data-rc='.playground-output'><i class='fa fa-refresh'></i> Refresh and execute</a>)</small></legend>";
			echo "<div class='row form-group'>";
			echo "<div class='col-md-12 playground-output'>";
			
			echo "</div>";
			echo "</div>";
			echo "</fieldset>";
		}
		
	}
	
	function save_code() {
		$file = './application/logic/playground.php';
		if (isset($_POST['code'])) {
			if(file_put_contents($file, $_POST['code']) !== false){
				echo "<div class='alert alert-success'>Successfully saved!</div>";
			}else{
				echo "<div class='alert alert-danger'>Something went wrong.</div>";
			}
		}else{
			echo "<div class='alert alert-danger'>Nothing has been submitted</div>";
		}
	}
	
	function exec_playground() {
		$file = './application/logic/playground.php';
		
		if (file_exists($file)) {
			require_once $file;
		}
	}

?>