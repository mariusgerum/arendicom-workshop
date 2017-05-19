<?php
	
	function create() {
		global $db;
		
		if ( Request::Post('name') ) {
			if ( is_numeric(Request::Post('kunde')) ) {
				$Kunde = new Customer(Request::Post('kunde'));
				if ( $Kunde->exists() ) {
					$stmt = "INSERT INTO `auftraege` SET ";
					$stmt .= "`name` = " . $db->quote(Request::Post('name')) . ", ";
					$stmt .= "`kunde` = " . $db->quote($Kunde->id()) . ", ";
					$stmt .= "`archiv` = " . $db->quote(0) . ", ";
					$stmt .= "`status` = " . $db->quote(0) . ",";
					$stmt .= "`token` = " . $db->quote(Auth::createToken()) . "";
					
					if ( Numbers::isConflict() ) {
						echo HTML::danger("Achtung!", "Es scheint einen Konflikt mit den Nummern zu geben. Bitte passe die Nummernkreise-Einstellungen an und achte darauf, dass es keinen Konflikt mit Nummern existierender Aufträge geben kann.");
						
						return null;
					}
					
					if ( $db->exec($stmt) !== false ) {
						echo HTML::success("Erfolgreich!", "Der Auftrag wurde erfolgreich erstellt.<br><br><p><a href='" . Routes::link('Offer', [ 'id' => $db->lastInsertId() ]) . "' class='btn btn-default'><i class='fa fa-edit'></i> Angebot für diesen Auftrag schreiben</a></p><p><a href='" . Routes::link('Invoice', [ 'id' => $db->lastInsertId() ]) . "' class='btn btn-default'><i class='fa fa-edit'></i> Rechnung für diesen Auftrag schreiben</a></p><p><a href='" . Routes::link('Orders.View') . "' class='btn btn-default'><i class='fa fa-book'></i> Zur Auftragsübersicht</a></p>");
						
						$thisOrder = new Order($db->lastInsertId());
						$N = new Numbers($thisOrder->id(), $thisOrder->getAnnualRank());
						$q = "UPDATE `auftraege` SET ";
						$q .= "`nr` = " . $db->quote($N->getNumber()) . ", ";
						$q .= "`a_nr` = " . $db->quote($N->getFormat(Settings::get('a_format'))) . ", ";
						$q .= "`ab_nr` = " . $db->quote($N->getFormat(Settings::get('ab_format'))) . ", ";
						$q .= "`l_nr` = " . $db->quote($N->getFormat(Settings::get('l_format'))) . ", ";
						$q .= "`sr_nr` = " . $db->quote($N->getFormat(Settings::get('sr_format'))) . ", ";
						$q .= "`r_nr` = " . $db->quote($N->getFormat(Settings::get('r_format'))) . "";
						$q .= " WHERE `id` = " . $db->quote($thisOrder->id()) . "";
						if ( $db->exec($q) !== false ) {
							
						} else {
							$q2 = "UPDATE `auftraege` SET ";
							$q2 .= "`nr` = " . $db->quote(sha1(time())) . ", ";
							$q2 .= "`a_nr` = " . $db->quote('A-' . sha1(time())) . ", ";
							$q2 .= "`ab_nr` = " . $db->quote('AB-' . sha1(time())) . ", ";
							$q2 .= "`l_nr` = " . $db->quote('L-' . sha1(time())) . ", ";
							$q2 .= "`sr_nr` = " . $db->quote('SR-' . sha1(time())) . ", ";
							$q2 .= "`r_nr` = " . $db->quote('R-' . sha1(time())) . "";
							$q2 .= " WHERE `id` = " . $db->quote($thisOrder->id()) . "";
							@$db->exec($q2);
						}
						
					} else {
						echo HTML::danger("Fehlgeschlagen!", "Leider ist beim Ausführen der Aktion ein Fehler aufgetreten. Wir bemühen uns um eine scnellstmögliche Lösung des Problems.");
					}
					
					
				} else {
					echo HTML::danger("Dieser Kunde existiert nicht (mehr).");
				}
			} else {
				echo HTML::danger("Es wurde ein ungültiger Kunde ausgewählt");
			}
		} else {
			echo HTML::danger("Bitte gib einen kurzen Auftragsbetreff ein.");
		}
		
	}
	
	function form_create() {
		global $db;
		
		$id = 1;
		$LastInsertID = Database::getLastInsertId('auftraege');
		if ( intval($LastInsertID) >= 1 ) {
			$id = $LastInsertID + 1;
		}
		
		$N = new Numbers($id);
		$Auftragsnummer = $N->getNumber();
		
		if ( Numbers::isConflict() ) {
			$nn = new Numbers(Orders::getNextNumber());
			echo HTML::danger("Achtung!", "Es scheint einen Konflikt mit den Nummern zu geben - offenbar existiert ein <b>Auftrag mit der Auftragsnummer " . $nn->getNumber() . "</b> bereits. Bitte passen Sie die Nummernkreise-Einstellungen an und achten Sie darauf, dass es keinen Konflikt mit Nummern existierender Aufträge geben kann.<br><br><a href='/Settings/Orders&msg=conflict' class='btn btn-default'><i class='fa fa-gear'></i> Nummernkreise anpassen</a>");
			
			return null;
		}
		
		if ( Application::sysmsg('nummernkreise') ) {
			echo HTML::info("Tipp!", "Möchtest du das Format der Auftragsnummer in den <i class='fa fa-gear'></i> <a href='" . Routes::link('Settings/Orders#Numbers') . "'>Nummernkreise-Einstellungen</a> ändern (empfohlen)?");
			#echo "<script type='text/javascript'>bootbox.alert(\"Es scheint als wäre das dein erster Auftrag. Deine erste Auftragsnummer wäre<br><b>" . $Auftragsnummer . "</b>.<br>Möchtest du das in den <i class='fa fa-gear'></i> <a href='" . Routes::link('Settings.Edit') . "'>Nummernkreise-Einstellungen</a> ändern (empfohlen)?\");</script>";
		}
		
		?>
		
		<h4>Auftrag erstellen</h4>
		
		<form id="frmAuftragErstellen" method="POST">
			<div class="row form-group">
				<div class="col-md-12">
					<small>Auftragsnummer</small>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-bolt fa-fw"></i>
						</span>
						<input class="form-control" placeholder="Auftragsnummer" type="text" value="<?= $Auftragsnummer; ?>" readonly>
					</div>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12">
					<small>Auftragsbetreff
						<a href="javascript:;" onClick="bootbox.alert('<h3>Auftragsname</h3>Wir finden, dass sich Namen besser merken lassen als Nummern. Gib hier also eine kurze Beschreibung des Auftrags an. Was möchte der Kunde?<br><br>Schreibe hier Dinge wie &quot;Malerarbeiten Südseite&quot;, &quot;PC-Angebot&quot; oder &quot;Wartungsarbeiten&quot;.<br><br>Die Bezeichnung wird auch in der Auftragsübersicht und auf Angebot / Rechnung (wenn du das willst) angezeigt.');"><i class="fa fa-question-circle default-blue"></i></a>
					</small>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-file-text-o fa-fw"></i>
						</span>
						<input class="form-control" placeholder="Auftragsbetreff" type="text" name="name" autofocus>
					</div>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12">
					<small>Kunde zuweisen (oder einen
						<a href="javascript:;" class='ajax' data-x-dismiss='modal' data-toggle="modal" data-target="#stack2" data-action="customers.create.form_create" data-rc=".rc-stack2" data-url="&opt=update-customer-list"><i class='fa fa-user-plus'></i>neuen Kunden erstellen</a>)
					</small>
					<span class="rc-customer-select">
						<?php select_customers_field(); ?>
					</span>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12 rc-auftrag-erstellen">
				
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12 text-right">
					<button type="button" class="btn btn-primary ajax-submit" data-action="orders.create.create" data-rc=".rc-auftrag-erstellen" data-form="#frmAuftragErstellen">Auftrag erstellen</button>
				</div>
			</div>
		
		</form>
		
		<script type="text/javascript">$('#frmCustomerList').selectpicker('refresh');</script>
		
		<?php
	}
	
	function select_customers_field() {
		global $db;
		echo "";
		$Kunden = $db->query("SELECT `id`, `name` FROM `kunden`")->fetchAll();
		echo "<select id='frmCustomerList' class='bs-select form-control' data-live-search='true' data-size='8' name='kunde'>";
		if ( !empty( $Kunden ) ) {
			echo "<option value=''>- Bitte auswählen -</option>";
			foreach ( $Kunden as $row ) {
				echo "<option value='" . $row['id'] . "'";
				if ( Request::Both('selected') == $row['id'] ) {
					echo " selected";
				}
				echo ">" . e($row['name']) . "</option>";
			}
		} else {
			echo "<option value=''>- Keine vorhanden -</option>";
		}
		echo "</select>";
	}

?>