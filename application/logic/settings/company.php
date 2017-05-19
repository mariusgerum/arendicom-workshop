<?php
	
	/**
	 *
	 */
	function logos(){
		$Logos = Files::getLogos();
		if($Logos !== null){
			echo "<table class='table table striped'>";
			echo "<tr><th>Datei</th><th class='text-right'>Optionen</th></tr>";
			foreach($Logos as $Logo){
				echo "<tr>";
				
				echo "<td>" . e($Logo['datei']) . "</td>";
				
				echo "<td class='text-right'>";
				echo "<a href='javascript:;' title='Bild anschauen' class='btn btn-sm btn-default text-primary ajax' data-action='settings.company.display_logo' data-url='id=" . e($Logo['id']) . "' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1'><i class='fa fa-eye'></i></a>";
				echo "<a href='javascript:;' title='Bild löschen' class='btn btn-sm btn-default text-danger ajax' data-action='settings.company.remove_logo' data-url='id=" . e($Logo['id']) . "' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1'><i class='fa fa-trash'></i></a>";
				echo "</td>";
				
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	
	function remove_logo(){
		echo "<div class='rc-confirm-logo-removal'>";
		if(Request::confirmed()){
			$Logo = Files::getLogo(Request::Get('id'));
			if($Logo !== false){
				if(Files::remove($Logo['id'], './application/files/' . Account::id() . '' . $Logo['datei'])){
					echo HTML::success("Erfolgreich!", "Die Logo-Datei wurde gelöscht.");
				}else{
					echo HTML::danger("Fehlgeschlagen", "Leider konnte die Datei nicht gelöscht werden.");
				}
			}else{
				echo HTML::danger("Fehler", "Das Logo kann nicht gelöscht werden, weil es nicht existiert.");
			}
		}else{
			$Logo = Files::getLogo(Request::Get('id'));
			if($Logo !== false){
				echo HTML::info("Bild löschen", "Bist du sicher, dass du das Bild <u>" . e($Logo['datei']) . "</u> löschen willst?", "note");
				echo "<div><img src='" . $Logo['url'] . "' alt='Logo kann nicht angezeigt werden' style='max-height: 100px;'></div><br>";
				echo "<a href='javascript:;' class='btn btn-danger ajax' data-action='settings.company.remove_logo' data-url='id=" . e($Logo['id']) . "&confirmed' data-rc='.rc-confirm-logo-removal'><i class='fa fa-trash'></i> Ja, bitte das Bild löschen</a>";
			}else{
				echo HTML::danger("Fehler", "Das Logo kann nicht gelöscht werden, weil es nicht existiert.");
			}
		}
		echo "</div>";
	}
	
	function display_logo(){
		
		$Logo = Files::getLogo(Request::Get('id'));
		if($Logo !== false){
			$logo_file = $Logo['datei'];
			$logo_file = Regex::replace('/^\/+/i', '', $logo_file);
			$file = './application/files/' . Account::id() . '/' . $logo_file;
			if(file_exists($file)){
				echo "<img src='" . $Logo['url'] . "' alt='Logo kann nicht angezeigt werden' style='max-width: 100%;'>";
			}else{
				echo HTML::danger("Fehler", "Das gewünschte Bild kann nicht angezeigt werden, weil es nicht existiert.");
			}
		}else{
			echo HTML::danger("Fehler", "Das gewünschte Bild kann nicht angezeigt werden, weil es nicht existiert.");
		}
	}
	
	/**
	 *
	 */
	function upload_logo(){
		if(Request::Files('logo', false) !== false && isset($_FILES['logo']['name'])){
			
			$fp = '/images/' . Request::Files('logo')['name'];
			$file ='./application/files/' . Account::id() . $fp;
			
			if(Request::Files('logo')['error'] == 0){
				if(file_exists($file) && sha1_file($file) == sha1_file(Request::Files('logo')['tmp_name'])){
					echo HTML::info("Nicht nötig", "Die Datei existiert bereits.");
				}else{
					if(move_uploaded_file(Request::Files('logo')['tmp_name'], $file)){
						$res1 = chmod($file, Filesystem::PERMISSION_USER_SUBDIRECTORY_FILE);
						$res2 = Files::add($fp, 'logo');
						if($res1 !== false && $res2 !== false){
							echo HTML::success("Das Logo wurde erfolgreich hochgeladen.");
						}else{
							echo HTML::danger("Fehler", "Beim Hochladen der Datei ist ein Fehler aufgetreten.");
						}
					}else{
						echo HTML::danger("Fehler", "Beim Hochladen der Datei ist ein Fehler aufgetreten.");
					}
				}
			}else{
				echo HTML::danger("Keine Daten", "Bitte wähle das gewünschte Bild aus, das hochgeladen werden soll.");
			}
		}else{
			echo HTML::danger("Keine Daten", "Bitte wähle das gewünschte Bild aus, das hochgeladen werden soll.");
		}
	}

?>