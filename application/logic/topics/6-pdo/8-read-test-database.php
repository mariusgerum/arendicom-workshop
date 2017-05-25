<?php
	
	$Data = $db->query("SELECT * FROM `test`")->fetchAll();
	
	if ($Data) {
		echo pre(htmlspecialchars(print_r($Data, 1), ENT_QUOTES, 'utf-8'));
	} else {
		echo "Database doesn't have any rows yet.";
	}

?>