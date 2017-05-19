<?php
	
	function create() {
		global $db;
		
		if ( strlen(Request::Post('firma')) >= 1 || ( strlen(Request::Post('vorname')) >= 1 && strlen(Request::Post('nachname')) >= 1 ) ) {
			if ( ( Request::Post('vorname') != '' || Request::Post('nachname') != '' ) && Request::Post('anrede') == '' ) {
				echo HTML::danger("Bitte Anrede festlegen.");
				
				return null;
			}
			
			if ( Regex::match('/^\S+?\@\S+?\.\S+?$/i', Request::Post('email')) ) {
				if ( !Validator::isEmpty([ Request::Post('strasse'), Request::Post('plz'), Request::Post('ort') ]) ) {
					$name = Request::Post('name');
					if ( $name == '' ) {
						switch (true) {
							case Request::Post('firma') != '' && Request::Post('vorname') != '' && Request::Post('nachname') != '':
								$name = Request::Post('firma') . " - " . Request::Post('vorname') . " " . Request::Post('nachname');
								break;
							case Request::Post('firma') != '':
								$name = Request::Post('firma');
								break;
							case Request::Post('vorname') != '' && Request::Post('nachname') != '':
								$name = Request::Post('vorname') . " " . Request::Post('nachname');
								break;
						}
					}
					
					$Existing = $db->query("SELECT `name` FROM `kunden` WHERE LOWER(name) = " . $db->quote(strtolower($name)))->fetch();
					if ( isset( $Existing['name'] ) ) {
						echo HTML::danger("Fehlgeschlagen!", "Dieser Kunde existiert bereits.");
						
						return null;
					}
					
					
					if ( $db->exec("INSERT INTO `kunden` SET `name` = " . $db->quote($name) . ", `firma` = " . $db->quote(Request::Post('firma')) . ", `vorname` = " . $db->quote(Request::Post('vorname')) . ", `nachname` = " . $db->quote(Request::Post('nachname')) . ", `email` = " . $db->quote(Request::Post('email')) . ", `anrede` = " . $db->quote(Request::Post('anrede')) . ", `strasse` = " . $db->quote(Request::Post('strasse')) . ", `plz` = " . $db->quote(Request::Post('plz')) . ", `ort` = " . $db->quote(Request::Post('ort'))) !== false ) {
						$additional = "";
						if ( Request::Both('opt') == 'update-customer-list' ) {
							$additional = "<br><br><a href='javascript:;' class='ajax' data-action='orders.create.select_customers_field' data-rc='.rc-customer-select' data-dismiss='modal' data-url='&selected=" . $db->lastInsertId() . "'>Hier klicken</a> um diesen Kunden für den Auftrag auszuwählen.";
						}
						echo HTML::success("Erfolgreich!", "Der neue Kunde &raquo;" . e($name) . "&laquo; wurde erfolgreich angelegt." . $additional);
					} else {
						echo HTML::danger("Es ist ein Fehler aufgetreten.");
					}
				}else{
					echo HTML::danger("Bitte Adresse angeben", "Die Adresse des Kunden wird später auf den Formularen (Angebot, Rechnung, ...) angezeigt und stellt eine Komponente dar, die auf rechtsgültigen Dokumenten nicht fehlen darf.");
				}
				
				
			} else {
				echo HTML::danger("Bitte gib eine <u>gültige</u> E-Mail Adresse ein.");
			}
			
		} else {
			echo HTML::danger("Entweder Firma oder Vorname und Nachname müssen ausgefüllt werden.");
		}
		
	}
	
	function form_create() {
		global $db;
		# @todo Anschrift
		?>
		
		<div class="row form-group">
			<div class="col-md-12 rc-form-create-customer">
			
			</div>
		</div>
		
		<div class="portlet-body">
			<form id="frmKundeErstellen" method="POST">
				<div class="tabbable-custom ">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#create_customer_tab_1" data-toggle="tab"> Kunde </a>
						</li>
						<li>
							<a href="#create_customer_tab_2" data-toggle="tab"> Kontakt </a>
						</li>
						<li>
							<a href="#create_customer_tab_3" data-toggle="tab"> Unternehmen </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="create_customer_tab_1">
							<h4>Kunde erstellen</h4>
							<?php /*
							<div class="row form-group">
								<div class="col-md-12">
									<small>Anzeigename
										<small>(<a href="javascript:;" onClick="bootbox.alert('Der Anzeigename dient zur systeminternen Darstellung des Kunden - zum Beispiel in der Auftragsübersicht oder in der Kundenverwaltung.<br><br>Du kannst das Feld leer lassen. In dem Fall wird dieses Feld automatisch aus dem Firmennamen sowie dem Vor- und Nachnamen zusammengesetzt.');">Was ist das?</a>)
										</small>
									</small>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-star"></i>
										</span>
										<input class="form-control" placeholder="Anzeigename" type="text" name="name" autofocus>
									</div>
								</div>
							</div>
							*/ ?>
							<div class="row form-group">
								<div class="col-md-12">
									<small>Firma</small>
									<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-building-o"></i>
						</span>
										<input class="form-control" placeholder="Firma" type="text" name="firma">
									</div>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-md-6 col-sm-12">
									<small>Anrede</small>
									<select class="form-control" name="anrede">
										<option value="">- Bitte auswählen -</option>
										<option value="Herr">Herr</option>
										<option value="Frau">Frau</option>
									</select>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-md-6 col-sm-12">
									<small>Vorname</small>
									<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
										<input class="form-control" placeholder="Vorname" type="text" name="vorname">
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<small>Name</small>
									<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
										<input class="form-control" placeholder="Name" type="text" name="nachname">
									</div>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-md-12 col-sm-12">
									<small>Straße, Nr.</small>
									<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
										<input class="form-control" placeholder="Straße, Nr." type="text" name="strasse">
									</div>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-md-4 col-sm-12">
									<small>PLZ</small>
									<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
										<input class="form-control" placeholder="PLZ" type="text" name="plz">
									</div>
								</div>
								<div class="col-md-8 col-sm-12">
									<small>Ort</small>
									<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
										<input class="form-control" placeholder="Ort" type="text" name="ort">
									</div>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-md-12">
									<small>E-Mail</small>
									<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</span>
										<input class="form-control" placeholder="E-Mail" type="text" name="email">
									</div>
								</div>
							</div>
						
						</div>
						<div class="tab-pane" id="create_customer_tab_2">
							<?php
								echo HTML::info("Hier kannst du <b>optional</b> weitere Kontaktmöglichkeiten erfassen.", "", 'note');
							?>
						</div>
						<div class="tab-pane" id="create_customer_tab_3">
							<?php
								# @todo Erweitere Funktionen für Kunden
								echo HTML::info("Demnächst verfügbar", "", "note");
							?>
						</div>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-md-12 right">
						<?php
							if ( Request::Both('opt') == 'update-customer-list' ) {
								echo "<input type='hidden' name='opt' value='update-customer-list'>";
							}
						?>
						<button type="button" class="btn btn-primary ajax-submit" data-action="customers.create.create" data-rc=".rc-form-create-customer" data-form="#frmKundeErstellen">
							<i class="fa fa-user-plus"></i> Kunde erstellen
						</button>
					</div>
				</div>
			
			</form>
		</div>
		
		<?php
	}

?>