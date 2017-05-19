<?php
	
	function platzhalter() {
		?>
		<table class="table table-striped tbl-platzhalter full-width">
			<thead>
				<tr>
					<th>Platzhalter</th>
					<th>Beschreibung</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<strong>Kunden-spezifisch</strong>
					</td>
				</tr>
				<tr>
					<td>%ANREDE%</td>
					<td>Die Kunden-Anrede (z.B. "Sehr geehrter Herr Max Mustermann")</td>
				</tr>
				<tr>
					<td>%KUNDE Firma%</td>
					<td>Der Firmenname des Kunden</td>
				</tr>
				<tr>
					<td>%KUNDE VORNAME%</td>
					<td>Der Vorname des Kunden</td>
				</tr>
				<tr>
					<td>%KUNDE NACHNAME%</td>
					<td>Der Nachname des Kunden</td>
				</tr>
				<tr>
					<td>%KUNDENNR%</td>
					<td>Die Kundennummer des Kunden</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<strong>Auftrags-spezifisch</strong>
					</td>
				</tr>
				<tr>
					<td>%AUFTRAGSNR%</td>
					<td>Die Auftragsnummer</td>
				</tr>
				<tr>
					<td>%AUFTRAGSBETREFF%</td>
					<td>Der Auftragsbetreff</td>
				</tr>
				<tr>
					<td>%ANR%</td>
					<td>Angebotsnummer</td>
				</tr>
				<tr>
					<td>%LNR%</td>
					<td>Lieferschein-Nummer</td>
				</tr>
				<tr>
					<td>%ABNR%</td>
					<td>Auftragsbestätigung-Nummer</td>
				</tr>
				<tr>
					<td>%RNR%</td>
					<td>Rechnungsnummer</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<strong>Firmen-Daten (betrifft <u>deine</u> Firma)</strong>
					</td>
				</tr>
				<tr>
					<td>%FIRMA NAME%</td>
					<td>Der Name deiner Firma
						<small>(<?php echo e(Account::get('firma', 'Muster GmbH')); ?>)</small>
					</td>
				</tr>
				<tr>
					<td>%FIRMA VORNAME%</td>
					<td>Dein Vorname
						<small>(<?php echo e(Account::get('vorname'), 'Max'); ?>)</small>
					</td>
				</tr>
				<tr>
					<td>%FIRMA NACHNAME%</td>
					<td>Dein Nachname
						<small>(<?php echo e(Account::get('nachname', 'Mustermann')); ?>)</small>
					</td>
				</tr>
				
				<tr>
					<td>%FIRMA EMAIL%</td>
					<td>Deine E-Mail Adresse
						<small>(<?php echo e(Account::get('email', 'max.muster@mann.de')); ?>)</small>
					</td>
				</tr>
				
				<tr>
					<td>%FIRMA TELEFON%</td>
					<td>Deine Telefonnummer
						<small>(<?php echo e(Account::get('telefon', '+49 (0) 89 123 456')); ?>)</small>
					</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<strong>Allgemein</strong>
					</td>
				</tr>
				
				<tr>
					<td>%JAHR%</td>
					<td>Aktuelles Jahr
						<small>(z.B. <?php echo date('Y'); ?>)</small>
					</td>
				</tr>
				<tr>
					<td>%MONAT%</td>
					<td>Aktueller Monat
						<small>(z.B. <?php echo date('m'); ?>)</small>
					</td>
				</tr>
				<tr>
					<td>%TAG%</td>
					<td>Aktueller Tag
						<small>(z.B. <?php echo date('d'); ?>)</small>
					</td>
				</tr>
				<tr>
					<td>%WOCHENTAG%</td>
					<td>Aktueller Tag der Woche (Mo - Fr)
						<small>(z.B. <?php echo DT::getDayOfWeek(time()); ?>)</small>
					</td>
				</tr>
			
			</tbody>
		</table>
		<?php
	}
	
	
	function nummernkreise() {
		
		echo "<h3>Nummernkreise</h3>";
		echo "<strong>Startwert</strong>";
		echo "<div>Lege einen Startwert fest, um deine Auftragsnummern nicht mit &quot;1&quot; (Startwert &quot;0&quot;) sondern z.B. mit &quot;496&quot; (Startwert &quot;495&quot;) beginnen zu lassen.<br><a href='javascript:;' class='btn btn-sm btn-primary ajax' data-action='application.nummer_inkrement' data-toggle='modal' data-target='#stack2' data-rc='.rc-stack2'>&raquo; Details hierzu</a></div>";
		echo "<br>";
		
		echo "<strong>Nullen-Auffüller</strong>";
		echo "<div>Du kannst die Auftragsnummer auf eine gewünschte Anzahl von Stellen mit Nullen auffüllen.<br><a href='javascript:;' class='btn btn-sm btn-primary ajax' data-action='application.nullen' data-toggle='modal' data-target='#stack2' data-rc='.rc-stack2'>&raquo; Details hierzu</a></div>";
		echo "<br>";
		
		echo "<strong>Nummern-Format</strong>";
		echo "<div>Das Anzeigeformat von Auftrags-, Angebots- oder Rechnungsnummer, so wie sie auch auf den PDF-Dokumenten angezeigt wird.<br><a href='javascript:;' class='btn btn-sm btn-primary ajax' data-action='application.nummer_format' data-toggle='modal' data-target='#stack2' data-rc='.rc-stack2'>&raquo; Details hierzu</a></div>";
		
	}
	
	function nummer_inkrement() {
		echo "<h3>Nummernkreise</h3>";
		echo "<strong>Startwert</strong>";
		echo "<div>Im System ist die erste Nummer die 1 (das heißt der Startwert ist auf 0). Von " . APP_NAME . " voreingestellt ist der Startwert &quot;1000&quot;, somit hat dein erster Auftrag die Auftragsnummer <strong>1001</strong>.<br>Du kannst den Startwert nach Belieben anpassen, was beispielsweise Sinn machst, wenn du die Auftragsnummern aus deinem vorherigen System fortführen möchtest.<br>Sagen wir dein letzter Auftrag hatte die Auftragsnummer &quot;123&quot;, dann gibst du hier als Startwert auch &quot;123&quot; ein, sodass dein erster Auftrag in " . APP_NAME . " die Nummer &quot;124&quot; hat.<br><br><strong>Beispiele:</strong><br><p>&raquo; Trägst du eine &quot;0&quot; ein, lautet deine erste Auftragsnummer &quot;1&quot;</p><p>&raquo; Trägst du &quot;1000&quot; ein, lautet deine erste Auftragsnummer &quot;1001&quot;</p></div>";
		
	}
	
	function nullen() {
		echo "<h3>Nummernkreise</h3>";
		echo "<strong>Auftragsnummer-Zähler</strong>";
		echo "<div>Leg fest, ob du die Auftragsnummer bis zu einer gewünschten Anzahl mit Nullstellen auffüllen willst.<br><br><strong>Beispiele:</strong><p>Deine Auftragsnummer ist &quot;123&quot; und du willst diese auf 5 Stellen mit Nullen auffüllen, dann wird daraus &quot;00123&quot;</p><p>Deine Auftragsnummer ist &quot;1009&quot; und du willst diese auf 8 Stellen mit Nullen auffüllen, dann wird daraus &quot;00001009&quot;</p></div>";
		
	}
	
	function nummer_format() {
		echo "<h3>Nummernkreise</h3>";
		echo "<strong>Nummer-Format</strong>";
		echo "<div>Das Anzeigeformat von Auftrags-, Angebots- oder Rechnungsnummer, so wie sie auch auf den PDF-Dokumenten angezeigt wird.</div>";
		echo "<br>";
		?>
		<table class="table table-striped tbl-platzhalter full-width">
			<thead>
				<tr>
					<th>Platzhalter</th>
					<th>Beschreibung</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>%ID%</td>
					<td>Die generelle Auftragsnummer, die zusammengesetzt ist aus Zählerwert und interner ID, die mit 1 beginnt.</td>
				</tr>
				<tr>
					<td>%JID%</td>
					<td>Wie %ID%, nur dass der Zähler jährlich zurückgesetzt wird - unabhängig von Zähler oder Nullstellen. Für diese Option
						<u>muss</u> das Jahr im Format vorhanden sein (%J%) oder eine der kompletten Datums-Platzhalter (z.B. %DATUM1%, %DATUM2% etc.)
					</td>
				</tr>
				<tr>
					<td>%JZID%</td>
					<td>Wie %ID%, nur dass der Zähler jährlich zurückgesetzt wird - unter Berücksichtigung des Zählers und ohne aufgefüllte Nullen. Für diese Option
						<u>muss</u> das Jahr im Format vorhanden sein (%J%) oder eine der kompletten Datums-Platzhalter (z.B. %DATUM1%, %DATUM2% etc.)
					</td>
				</tr>
				<tr>
					<td>%JNID%</td>
					<td>Wie %ID%, nur dass der Zähler jährlich zurückgesetzt wird - unabhängig vom Zähler und mit aufgefüllten Nullen. Für diese Option
						<u>muss</u> das Jahr im Format vorhanden sein (%J%) oder eine der kompletten Datums-Platzhalter (z.B. %DATUM1%, %DATUM2% etc.)
					</td>
				</tr>
				<tr>
					<td>%JZNID%</td>
					<td>Wie %ID%, nur dass der Zähler jährlich zurückgesetzt wird - unter Berücksichtigung des Zählers und mit aufgefüllten Nullen. Für diese Option
						<u>muss</u> das Jahr im Format vorhanden sein (%J%) oder eine der kompletten Datums-Platzhalter (z.B. %DATUM1%, %DATUM2% etc.)
					</td>
				</tr>
				<tr>
					<td>%NID%</td>
					<td>Die Auftragsnummer mit den aufgefüllten Nullen.</td>
				</tr>
				<tr>
					<td>%DATUM1%</td>
					<td>Aktuelles Datum, im Format <?php echo date("Y-m-d"); ?></td>
				</tr>
				<tr>
					<td>%DATUM2%</td>
					<td>Aktuelles Datum, im Format <?php echo date("Ymd"); ?></td>
				</tr>
				<tr>
					<td>%DATUM3%</td>
					<td>Aktuelles Datum, im Format <?php echo date("d-m-Y"); ?></td>
				</tr>
				<tr>
					<td>%DATUM4%</td>
					<td>Aktuelles Datum, im Format <?php echo date("Y-m"); ?></td>
				</tr>
				<tr>
					<td>%DATUM5%</td>
					<td>Aktuelles Datum, im Format <?php echo date("Ym"); ?></td>
				</tr>
				<tr>
					<td>%J%</td>
					<td>Aktuelles Jahr, 4-stellig (z.B. <?php echo date("Y"); ?>)</td>
				</tr>
				<tr>
					<td>%M%</td>
					<td>Aktueller Monat, ohne führende Null (z.B. 2 (Februar) oder 10 (Oktober) etc.)</td>
				</tr>
				<tr>
					<td>%MM%</td>
					<td>Aktueller Monat, mit führender Null (z.B. 02 (Februar) oder 10 (Oktober) etc.)</td>
				</tr>
				<tr>
					<td>%T%</td>
					<td>Aktueller Tag, mit führender Null (z.B. 2 oder 10 etc.)</td>
				</tr>
				<tr>
					<td>%TT%</td>
					<td>Aktueller Tag, ohne führende Null (z.B. 02 oder 10 etc.)</td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	
	function numbers_preview() {
		
		?>
		<div class="btn-group">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;"> Vorschau auswählen ...
				<i class="fa fa-angle-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a class='ajax' href='javascript:;' data-rc='.rc-numbers-preview' data-action='application.numbers_preview_c' data-url="pid=1">
						Dein nächster Auftrag
					</a>
				</li>
				<li>
					<a class='ajax' href='javascript:;' data-rc='.rc-numbers-preview' data-action='application.numbers_preview_c' data-url="pid=2">
						Dein 100. Auftrag
					</a>
				</li>
				<li>
					<a class='ajax' href='javascript:;' data-rc='.rc-numbers-preview' data-action='application.numbers_preview_c' data-url="pid=3">
						Der erste Auftrag im neuen Jahr (<?php echo date("Y")+1; ?>)
					</a>
				</li>
				<li>
					<a class='ajax' href='javascript:;' data-rc='.rc-numbers-preview' data-action='application.numbers_preview_c' data-url="pid=4">
						Der 20. Auftrag im nächsten Jahr (<?php echo date("Y")+1; ?>)
					</a>
				</li>
			</ul>
		</div>
		
		<div class="row form-group">
			<div class="col-md-12 rc-numbers-preview">
			
			</div>
		</div>
		
		<?php
		
		#echo "<a class='btn btn-sm btn-default ajax' href='javascript:;' data-toggle='modal' data-target='#stack1' data-rc='.rc-stack1' data-action='application.numbers_preview'><i class='fa fa-eye'></i> Vorschau der Nummernkreise</a>";
		
	}
	
	function numbers_preview_c() {
				
		$Data = [];
		$text = "";
		
		switch (Request::Get('pid')) {
			case 1:
				$text = "Die Nummern für den nächsten Auftrag, den du erstellen wirst.";
				$lid = Database::getLastInsertId('auftraege');
				$Order = new Order($lid);
				$rank = 0;
				if($Order->exists()){
					$rank = $Order->getAnnualRank();
				}
				$rank += 1;
				$nid = $lid + 1;
				$N = new Numbers($nid, $rank);
				$Data['nid'] = $nid;
				$Data['nr'] = $N->getNumber();
				$Data['a_nr'] = $N->getFormat(Settings::get('a_format'));
				$Data['ab_nr'] = $N->getFormat(Settings::get('ab_format'));
				$Data['l_nr'] = $N->getFormat(Settings::get('l_format'));
				$Data['sr_nr'] = $N->getFormat(Settings::get('sr_format'));
				$Data['r_nr'] = $N->getFormat(Settings::get('r_format'));
				break;
			case 2:
				$text = "Die Nummern für den 100. Auftrag den du erstellst";
				$N = new Numbers(100, 100);
				$Data['nid'] = 100;
				$Data['nr'] = $N->getNumber();
				$Data['a_nr'] = $N->getFormat(Settings::get('a_format'));
				$Data['ab_nr'] = $N->getFormat(Settings::get('ab_format'));
				$Data['l_nr'] = $N->getFormat(Settings::get('l_format'));
				$Data['sr_nr'] = $N->getFormat(Settings::get('sr_format'));
				$Data['r_nr'] = $N->getFormat(Settings::get('r_format'));
				break;
			case 3:
				$text = "Der erste Auftrag, den du im nächsten Jahr (" . (date("Y")+1) . ") erstellst (in der Annahme, dass das dein 200. Auftrag ist).";
				$N = new Numbers(200, 1);
				$Data['nid'] = 200;
				$Data['nr'] = $N->getNumber();
				$Data['a_nr'] = $N->getFormat(Settings::get('a_format'), strtotime((date('Y')+1).'-01-01'));
				$Data['ab_nr'] = $N->getFormat(Settings::get('ab_format'), strtotime((date('Y')+1).'-01-01'));
				$Data['l_nr'] = $N->getFormat(Settings::get('l_format'), strtotime((date('Y')+1).'-01-01'));
				$Data['sr_nr'] = $N->getFormat(Settings::get('sr_format'), strtotime((date('Y')+1).'-01-01'));
				$Data['r_nr'] = $N->getFormat(Settings::get('r_format'), strtotime((date('Y')+1).'-01-01'));
				break;
			case 4:
				$text = "Der 20. Auftrag, den du im nächsten Jahr (" . (date("Y")+1) . ") erstellst (in der Annahme, dass das dein 220. Auftrag ist und dieser am 16.06." . (date("Y")+1) . ".";
				$N = new Numbers(220, 1);
				$Data['nid'] = 220;
				$Data['nr'] = $N->getNumber();
				$Data['a_nr'] = $N->getFormat(Settings::get('a_format'), strtotime((date('Y')+1).'-06-16'));
				$Data['ab_nr'] = $N->getFormat(Settings::get('ab_format'), strtotime((date('Y')+1).'-06-16'));
				$Data['l_nr'] = $N->getFormat(Settings::get('l_format'), strtotime((date('Y')+1).'-06-16'));
				$Data['sr_nr'] = $N->getFormat(Settings::get('sr_format'), strtotime((date('Y')+1).'-06-16'));
				$Data['r_nr'] = $N->getFormat(Settings::get('r_format'), strtotime((date('Y')+1).'-06-16'));
				break;
			default:
				echo "";
				return null;
				break;
		}
		
		if ( Numbers::isConflict() ) {
			$nn = new Numbers(Orders::getNextNumber());
			echo HTML::danger("Achtung!", "Es scheint einen Konflikt mit den Nummern zu geben - offenbar existiert ein <b>Auftrag mit der Auftragsnummer " . $nn->getNumber() . "</b> bereits, das heißt dass du deinen nächsten Auftrag vermutlich nicht erstellen kannst. Bitte passe die Nummernkreise-Einstellungen an und achte darauf, dass es keinen Konflikt mit Nummern existierender Aufträge geben kann.<br><br><a href='/Settings/Orders&msg=conflict' class='btn btn-default'><i class='fa fa-gear'></i> Nummernkreise anpassen</a>");
			
		}
		
		echo "<br>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo HTML::info("Info", $text, 'note');
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label>Auftragsnummer: ID (" . $Data['nid'] . ") + " . e(Settings::get('nummer_inkrement')) . "</label>";
		echo "<input type='text' class='form-control' value='" . e($Data['nr']) . "' disabled>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label>Angebots-Nr.: " . e(Settings::get('a_format')) . "</label>";
		echo "<input type='text' class='form-control' value='" . e($Data['a_nr']) . "' disabled>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label>Auftragsbestätigungs-Nr.: " . e(Settings::get('ab_format')) . "</label>";
		echo "<input type='text' class='form-control' value='" . e($Data['ab_nr']) . "' disabled>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label>Lieferschein-Nr.: " . e(Settings::get('l_format')) . "</label>";
		echo "<input type='text' class='form-control' value='" . e($Data['l_nr']) . "' disabled>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label>Servicereport-Nr.: " . e(Settings::get('sr_format')) . "</label>";
		echo "<input type='text' class='form-control' value='" . e($Data['sr_nr']) . "' disabled>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label>Rechnungs-Nr.: " . e(Settings::get('r_format')) . "</label>";
		echo "<input type='text' class='form-control' value='" . e($Data['r_nr']) . "' disabled>";
		echo "</div>";
		echo "</div>";
		
	}

?>