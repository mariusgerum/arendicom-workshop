<?php
	
	function text_templates() {
		if ( Settings::updateSettings('mail_templates', [ 'angebot', 'auftragsbest', 'lieferschein', 'rechnung' ], $_POST) ) {
			echo HTML::success("Einstellungen wurden erfolgreich gespeichert");
		} else {
			echo HTML::danger("Die Einstellungen konnten nicht gespeichert werden.");
		}
	}
	
	function ordersettings() {
		
		if ( !Regex::match('/^([0-9]+)$/i', Request::Post('nummer_inkrement')) ) {
			echo HTML::danger("Der Zählerwert muss eine gültige Zahl sein (keine negative Zahl und keine Buchstaben)");
			
			return null;
		}
		
		if ( !Regex::match('/^([0-9][0-9]?)$/i', Request::Post('nullen')) ) {
			echo HTML::danger("Die Anzahl an Nullstellen sollte eine gültige maximal zweistellige Zahl sein.)");
			
			return null;
		}
		
		if ( !Regex::match('/.*\%(nid|id|nr|jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('a_format')) ) {
			echo HTML::danger("Das Format für die Angebots-Nr. ist ungültig. Es muss in jedem Fall die Auftragsnummer darin auftauchen (Platzhalter %ID%, %NID%, %JID% o.ä.) sonst ist keine Eindeutigkeit gewährleistet.");
			
			return null;
		}
		
		if ( !Regex::match('/.*\%(nid|id|nr|jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('ab_format')) ) {
			echo HTML::danger("Das Format für die Auftragsbestätigungs-Nr. ist ungültig. Es muss in jedem Fall die Auftragsnummer darin auftauchen (Platzhalter %ID%, %NID%, %JID% o.ä.) sonst ist keine Eindeutigkeit gewährleistet.");
			
			return null;
		}
		
		if ( !Regex::match('/.*\%(nid|id|nr|jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('l_format')) ) {
			echo HTML::danger("Das Format für die Lieferschein-Nr. ist ungültig. Es muss in jedem Fall die Auftragsnummer darin auftauchen (Platzhalter %ID%, %NID%, %JID% o.ä.) sonst ist keine Eindeutigkeit gewährleistet.");
			
			return null;
		}
		if ( !Regex::match('/.*\%(nid|id|nr|jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('sr_format')) ) {
			echo HTML::danger("Das Format für die Servicereport-Nr. ist ungültig. Es muss in jedem Fall die Auftragsnummer darin auftauchen (Platzhalter %ID%, %NID%, %JID% o.ä.) sonst ist keine Eindeutigkeit gewährleistet.");
			
			return null;
		}
		if ( !Regex::match('/.*\%(nid|id|nr|jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('r_format')) ) {
			echo HTML::danger("Das Format für die Rechnungs-Nr. ist ungültig. Es muss in jedem Fall die Auftragsnummer darin auftauchen (Platzhalter %ID%, %NID%, %JID% o.ä.) sonst ist keine Eindeutigkeit gewährleistet.");
			
			return null;
		}
		
		
		/* Jahresnummern */
		if ( Regex::match('/.*\%(jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('a_format')) ) {
			if ( !Regex::match('/.*\%((datum|date)[12345]|jahr|year|j|jjjj)\%.*/i', Request::Post('a_format')) ) {
				echo HTML::danger("Wenn du die Nummern jährlich neu setzen möchtest, musst du in deinem Angebots-Nr. Format einen der Datums-Platzhalter verwenden, in dem das Jahr enthalten ist.");
				
				return null;
			}
		}
		if ( Regex::match('/.*\%(jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('ab_format')) ) {
			if ( !Regex::match('/.*\%((datum|date)[12345]|jahr|year|j|jjjj)\%.*/i', Request::Post('ab_format')) ) {
				echo HTML::danger("Wenn du die Nummern jährlich neu setzen möchtest, musst du in deinem Auftragsbestätigungs-Nr. Format einen der Datums-Platzhalter verwenden, in dem das Jahr enthalten ist.");
				
				return null;
			}
		}
		if ( Regex::match('/.*\%(jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('l_format')) ) {
			if ( !Regex::match('/.*\%((datum|date)[12345]|jahr|year|j|jjjj)\%.*/i', Request::Post('l_format')) ) {
				echo HTML::danger("Wenn du die Nummern jährlich neu setzen möchtest, musst du in deinem Lieferschein-Nr. Format einen der Datums-Platzhalter verwenden, in dem das Jahr enthalten ist.");
				
				return null;
			}
		}
		if ( Regex::match('/.*\%(jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('sr_format')) ) {
			if ( !Regex::match('/.*\%((datum|date)[12345]|jahr|year|j|jjjj)\%.*/i', Request::Post('sr_format')) ) {
				echo HTML::danger("Wenn du die Nummern jährlich neu setzen möchtest, musst du in deinem Servicereport-Nr. Format einen der Datums-Platzhalter verwenden, in dem das Jahr enthalten ist.");
				
				return null;
			}
		}
		if ( Regex::match('/.*\%(jahr(id|nr)|j(z|n|zn|nz)?(id|nr))\%.*/i', Request::Post('r_format')) ) {
			if ( !Regex::match('/.*\%((datum|date)[12345]|jahr|year|j|jjjj)\%.*/i', Request::Post('r_format')) ) {
				echo HTML::danger("Wenn du die Nummern jährlich neu setzen möchtest, musst du in deinem Rechnungs-Nr. Format einen der Datums-Platzhalter verwenden, in dem das Jahr enthalten ist.");
				
				return null;
			}
		}
		
		if ( Settings::updateSettings('einstellungen', [ 'nummer_inkrement', 'nullen', 'auftragsnummer_format', 'a_format', 'ab_format', 'l_format', 'sr_format', 'r_format' ], $_POST) !== false ) {
			echo HTML::success("Einstellungen wurden erfolgreich gespeichert.<br><br><a class='btn btn-sm btn-default ajax' href='javascript:;' data-toggle='modal' data-target='#stack1' data-rc='.rc-stack1' data-action='application.numbers_preview'><i class='fa fa-eye'></i> Vorschau der Nummernkreise</a>");
		} else {
			echo HTML::danger("Die Einstellungen konnten nicht gespeichert werden.");
		}
	}
	
	function companysettings() {
		
		if ( !Regex::match('/^(herr|frau)$/i', Request::Post('anrede')) ) {
			echo HTML::danger("Anrede ist kein gültiger Wert.");
			
			return null;
		}
		
		if ( empty(Request::Post('firma')) ) {
			echo HTML::danger("Firma ist ein Pflichtfeld.");
			
			return null;
		}
		
		if ( empty(Request::Post('vorname')) ) {
			echo HTML::danger("Vorname ist ein Pflichtfeld.");
			
			return null;
		}
		
		if ( empty(Request::Post('name')) ) {
			echo HTML::danger("Nachname ist ein Pflichtfeld.");
			
			return null;
		}
		
		if ( !is_numeric(Request::Post('position')) ) {
			$_POST['position'] = '1';
		}
		
		if ( Settings::updateAccount([ 'firma', 'anrede', 'vorname', 'name', 'strasse', 'nr', 'plz', 'ort', 'email_firma', 'telefon', 'position', 'handelsregisternr', 'steuernummer', 'steuer_id', 'ust_id', 'ustva_intervall', 'kleinunternehmerregelung' ], $_POST) !== false ) {
			echo HTML::success("Einstellungen wurden erfolgreich gespeichert.");
		} else {
			echo HTML::danger("Die Einstellungen konnten nicht gespeichert werden.");
		}
		
	}
	
	/**
	 *
	 */
	function designsettings() {
		if ( Settings::updateSettings('einstellungen', [ 'container_layout', 'submenu_style' ], $_POST) !== false ) {
			echo HTML::success("Einstellungen wurden erfolgreich gespeichert.");
		} else {
			echo HTML::danger("Die Einstellungen konnten nicht gespeichert werden.");
		}
	}

?>