<?php
	
	function loadCustomers(){
		global $db;
		$Kunden = $db->query("SELECT * FROM `kunden` ORDER BY `id` DESC")->fetchAll();
		if($Kunden){
			foreach($Kunden as $row){
				
				echo "<tr>";
				
				echo "<td><input type='checkbox' name='customer_{$row['id']}'</td>";
				echo "<td class='text-right'>" . e($row['id']) . "</td>";
				echo "<td class='text-left'>";
				echo "<i class='fa fa-info-circle default-blue cursor-pointer' onClick=\"$('.customer-details-" . $row['id'] . "').toggle();\"></i> " . e($row['name']) . "";
				echo "<div class='order-details customer-details-" . $row['id'] . "' hidden>";
				echo "<p><i class='fa fa-fw fa-user'></i> " . e(ucfirst($row['anrede'])) . " " . e($row['vorname']) . " " . e($row['nachname']);
				
				/*
				if(strtolower($row['anrede']) == 'herr'){
					echo " &nbsp; <i class='fa fa-mars' style='color: rgba(32, 32, 32, 0.5);'></i>";
				}
				if(strtolower($row['anrede']) == 'frau'){
					echo " &nbsp; <i class='fa fa-venus' style='color: rgba(32, 32, 32, 0.5);'></i>";
				}
				*/
				
				echo "</p>";
				echo "<p><i class='fa fa-fw fa-building-o'></i> " . e($row['firma']) . "</p>";
				echo "<p><i class='fa fa-fw fa-envelope'></i> <a href='mailto:" . e($row['email']) . "'>" . e($row['email']) . "</a></p>";
				echo "<p><i class='fa fa-fw fa-phone'></i> " . e($row['rufnummer_firma']) . "</p>";
				#echo "<p title='Erstellt am " . date('d.m.Y H:i:s', strtotime($row['erstellt'])) . " Uhr'><i class='fa fa-calendar fa-fw'></i> Erstellt am " . date("d.m.Y", strtotime($row['erstellt'])) . " um " . date("H:i", strtotime($row['erstellt'])) . " Uhr</p>";
				#echo "<p><i class='fa fa-handshake-o fa-fw'></i> Angebotspreis: <strong>" . Regex::formatPrice(rand(10, 2000) / rand(2, 8)) . "</strong></p>";
				#echo "<p><i class='fa fa-money fa-fw'></i> Rechnungsbetrag: <strong>" . Regex::formatPrice(rand(10, 2000) / rand(2, 8)) . "</strong></p>";
				echo "</div>";
				echo "</td>";
				
				# @todo Zeige Kunden-Umsätze (einstellbar ob für Jahr, Monat oder Insgesamt)
				# @todo ggf. info-circle symbol raus nehmen aus Kundenname und Auftragsname und den Text anklickbar machen
				
				echo "<td class='text-center table-actions'>";
				echo "<a href='javascript:;' title='Kunden-Informationen anzeigen' class='btn btn-default ajax' data-action='customers.view.informations' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1' data-url='&id=" . e($row['id']) . "'><i class='fa fa-info-circle'></i></a>";
				echo "<a href='javascript:;' title='Kunde bearbeiten' class='btn btn-default ajax' data-action='customers.edit.form_edit' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1' data-url='&id=" . e($row['id']) . "'><i class='fa fa-edit'></i></a>";
				echo "</td>";
				
				echo "</tr>";
			}
		}
	}
	
	function informations(){
		# @todo informations
	}

?>