<?php
	
	function edit() {
		global $db;
		
		if ( Request::Post('id') ) {
			$Order = new Order(Request::Post('id'));
			if ( $Order->exists() ) {
				if ( !$Order->isArchived() ) {
					if ( Request::Post('name') ) {
						if ( is_numeric(Request::Post('kunde')) ) {
							$Kunde = new Customer($Order->getCustomerID());
							if ( $Kunde->exists() ) {
								$stmt = "UPDATE `auftraege` SET ";
								$stmt .= "`name` = " . $db->quote(Request::Post('name')) . ", ";
								$stmt .= "`kunde` = " . $db->quote(Request::Post('kunde')) . "";
								$stmt .= " WHERE `id` = " . $db->quote(Request::Post('id'));
								if ( $db->exec($stmt) !== false ) {
									echo HTML::success("Erfolgreich!", "Die Änderungen wurden erfolgreich gespeichert.<br><br><p><a href='" . Routes::link('Offer', [ 'id' => $Order->id() ]) . "' class='btn btn-default'><i class='fa fa-edit'></i> Angebot für diesen Auftrag schreiben</a></p><p><a href='" . Routes::link('Invoice', [ 'id' => $Order->id() ]) . "' class='btn btn-default'><i class='fa fa-edit'></i> Rechnung für diesen Auftrag schreiben</a></p><p><a href='" . Routes::link('Orders.View') . "' class='btn btn-default'><i class='fa fa-book'></i> Zur Auftragsübersicht</a></p>");
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
				} else {
					echo HTML::danger("Nicht möglich!", "Der Auftrag ist archiviert und kann nicht mehr bearbeitet werden.");
				}
			} else {
				echo HTML::danger("Dieser Auftrag existiert nicht.");
			}
		} else {
			echo HTML::danger("Dieser Auftrag existiert nicht.");
		}
		
	}
	
	function form_edit() {
		global $db;
		
		$Order = new Order(Request::Get('id'));
		
		if ( !$Order->exists() ) {
			echo HTML::danger("Fehlgeschlagen!", "Dieser Auftrag existiert nicht!");
			
			return null;
		}
		
		if ( $Order->isArchived() ) {
			echo HTML::danger("Nicht möglich!", "Dieser Auftrag ist bereits archiviert und kann daher nicht mehr bearbeitet werden.");
			
			return null;
		}
		
		$Auftragsnummer = $Order->getOrderNumber();
		
		?>
		
		<h4>Auftrag bearbeiten</h4>
		
		<form id="frmAuftragBearbeiten" method="POST">
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
						<input class="form-control" placeholder="Auftragsbetreff" type="text" name="name" value="<?php echo e($Order->getName()); ?>" autofocus>
					</div>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12">
					<small>Kunde zuweisen (oder einen
						<a href="javascript:;" class='ajax' data-x-dismiss='modal' data-toggle="modal" data-target="#stack2" data-action="customers.create.form_create" data-rc=".rc-stack2" data-url="&opt=update-customer-list"><i class='fa fa-user-plus'></i>neuen Kunden erstellen</a>)
					</small>
					<span class="rc-customer-select">
						<?php select_customers_field($Order->getCustomerID()); ?>
					</span>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12 rc-auftrag-bearbeiten">
				
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-12 text-right">
					<input type="hidden" name="id" value="<?php echo e($Order->id()); ?>">
					<button type="button" class="btn btn-primary ajax-submit" data-action="orders.edit.edit" data-rc=".rc-auftrag-bearbeiten" data-form="#frmAuftragBearbeiten">
						<i class="fa fa-save"></i> Speichern
					</button>
				</div>
			</div>
		
		</form>
		
		<script type="text/javascript">$('#frmCustomerList').selectpicker('refresh');</script>
		
		<?php
	}
	
	/**
	 * @param bool $selected
	 */
	function select_customers_field($selected = false) {
		global $db;
		echo "";
		$Kunden = $db->query("SELECT `id`, `name` FROM `kunden`")->fetchAll();
		echo "<select id='frmCustomerList' class=\"bs-select form-control\" data-live-search=\"true\" data-size=\"8\" name='kunde'>";
		if ( !empty( $Kunden ) ) {
			echo "<option value=''>- Bitte auswählen -</option>";
			foreach ( $Kunden as $row ) {
				echo "<option value='" . $row['id'] . "'";
				if ( $selected !== false && is_numeric($selected) && $selected == $row['id'] ) {
					echo " selected";
				} else {
					if ( Request::Both('selected') == $row['id']) {
						echo " selected";
					}
				}
				
				echo ">" . e($row['name']) . "</option>";
			}
		} else {
			echo "<option value=''>- Keine vorhanden -</option>";
		}
		echo "</select>";
	}
	
	
	function manageStatus() {
		global $db;
		
		$Order = new Order(Request::Get('id'));
		
		if ( !$Order->exists() ) {
			echo HTML::danger("Fehlgeschlagen!", "Dieser Auftrag existiert nicht!");
			
			return null;
		}
		
		if ( $Order->isArchived() ) {
			echo HTML::danger("Nicht möglich!", "Dieser Auftrag ist bereits archiviert und kann daher nicht mehr bearbeitet werden.");
			
			return null;
		}
		
		$StatusChanged = false;
		$StatusBefore = false;
		if ( Request::Get('status', false) !== false ) {
			if ( is_numeric(Request::Get('status')) ) {
				$Order = new Order(Request::Get('id'));
				if ( $Order->exists() ) {
					if ( $db->exec("UPDATE `auftraege` SET `status` = " . $db->quote(Request::Get('status')) . " WHERE `id` = " . $db->quote($Order->id())) !== false ) {
						$StatusChanged = true;
						$StatusBefore = $Order->status();
						$StatusChangeMessage = "";
						if ( $StatusChanged ) {
							$OldStatus = Orders::getStatus($StatusBefore);
							if ( $OldStatus !== false ) {
								$StatusChangeMessage = "<small class='inline-block' style='float: right;'> <a href='javascript:;' class='ajax' data-action='orders.edit.manageStatus' data-rc='.rc-stack1' data-url='&id=" . $Order->id() . "&status=" . e($StatusBefore) . "' style='color: #eeeeee;' title='Status wieder auf &quot;" . $OldStatus['name'] . "&quot; setzen.'><i class='fa fa-undo'></i> Rückgängig machen</a></small>";
							} else {
								#echo HTML::danger("Fehlgeschlagen!", "Der vorhergehende Status konnte nicht ermittelt werden.");
							}
						} else {
							#echo HTML::info("Du hast in diesem Dialog noch keine Statusänderung vorgenommen.");
						}
						echo HTML::success("Status erfolgreich geändert!" . $StatusChangeMessage);
						$Order = new Order(Request::Get('id'));
					} else {
						echo HTML::danger("Fehlgeschlagen!", "Die Aktion konnte aufgrund eines Fehlers nicht ausgeführt werden");
					}
				} else {
					echo HTML::danger("Fehlgeschlagen!", "Dieser Auftrag existiert nicht!");
				}
			}
		}
		
		$Auftragsnummer = $Order->getOrderNumber();
		
		echo "<div class='rc-statusupdate'>";
		$Status = Orders::getStatus($Order->status(), $Order->id());
		if ( $Status !== false ) {
			?>
			<div class="portlet-body">
				<div class="tabbable-custom ">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_5_1" data-toggle="tab"> Status ändern </a>
						</li>
						<li>
							<a href="#tab_5_2" data-toggle="tab"> Erweitert </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_5_1">
							<?php
								
								echo "<h5><i class='fa fa-book'></i> Auftrag #" . $Auftragsnummer . " - " . e($Order->getName()) . "</h5>";
								echo "<br>";
								#echo "<div style='margin-top: 4px; padding: 2px 0px 4px 8px; border-left: 4px solid #4488cc;'>";
								echo HTML::info("Der Status des Auftrags ist <strong class='default-color'><i class='fa fa-" . $Status['icon'] . "'></i> " . $Status['name'] . "</strong><p style='margin-top: 16px;'><!--<i class='fa fa-info-circle default-blue'></i> -->" . $Status['text'] . "</p>", "", "note");
								#echo "</div>";
								
								if(!empty($Status['next'])){
									echo "<div><h4>&raquo; Status ändern:</h4></div>";
									
									echo "<table class='table no-border full-width va-middle'>";
									foreach ( $Status['next'] as $k => $Next ) {
										$NS = Orders::getStatus($Next);
										echo "<tr>";
										echo "<td>";
										echo "<strong>" . $NS['name'] . "</strong><br>";
										echo "<small>" . $NS['text_set'] . "</small>";
										echo "</td>";
										echo "<td class='text-right'>";
										echo "<a href='javascript:;' class='label statuslabel ajax' style='margin: 4px 0px; background-color: #" . $NS['background'] . "; color: #" . $NS['color'] . ";' data-action='orders.edit.manageStatus' data-rc='.rc-stack1' data-url='&id=" . $Order->id() . "&status=" . $Next . "'>";
										echo "<i class='fa fa-" . $NS['icon'] . "'></i> " . $NS['name'];
										echo "</a>";
										echo "</td>";
										echo "</tr>";
									}
									echo "</table>";
								}else{
									if($Status['archiv']){
										echo "<a href='javascript:;' class='btn btn-success ajax' data-action='orders.edit.archive' data-rc='.rc-stack2' data-url='&id=" . $Order->id() . "&confirm' data-toggle='modal' data-target='#stack2'><i class='fa fa-lock'></i> Auftrag archivieren</a>";
									}
								}
								
							
							?>
						</div>
						<div class="tab-pane" id="tab_5_2">
							<?php
								#echo HTML::info("Erweiterte Status-Funktionen", "", "note");
								echo "<fieldset><legend>Ein Schritt zurück</legend>";
								$PreviousStatus = Orders::getPreviousStatus($Order->status());
								if($PreviousStatus !== false && $Order->status() != 0){
									echo "Einen logischen Schritt zurückgehen und den Status von &quot;" . $Status['name'] . "&quot;zurück auf &quot;" . $PreviousStatus['name'] . "&quot; setzen.<br><br>";
									echo "Auf <a href='javascript:;' class='label statuslabel ajax' data-action='orders.edit.manageStatus' data-rc='.rc-stack1' data-url='&id=" . $Order->id() . "&status=" . $PreviousStatus['id'] . "' style='background-color: #" . $PreviousStatus['background'] . "; color: #" . $PreviousStatus['color'] . ";'><strong><i class='fa fa-" . $PreviousStatus['icon'] . "'></i> " . $PreviousStatus['name'] . "</strong></a> setzen.";
								}else{
									echo HTML::info("Das geht nicht wenn der Status &quot;" . $Status['name'] . "&quot; ist.");
								}
								echo "</fieldset>";
								
								
								echo "<fieldset><legend>Status zurücksetzen</legend>";
								$DefaultStatus = Orders::getStatus(0);
								echo "Du kannst den Status zurücksetzen auf &quot;" . $DefaultStatus['name'] . "&quot;. Zum Beispiel weil der Kunde sich umentschieden hat oder weil du für diesen Auftrag neu beginnen willst.<br>";
								echo "<br>Zurücksetzen auf <a href='javascript:;' class='label statuslabel ajax' data-action='orders.edit.manageStatus' data-rc='.rc-stack1' data-url='&id=" . $Order->id() . "&status=0' style='background-color: #" . $DefaultStatus['background'] . "; color: #" . $DefaultStatus['color'] . ";'><strong><i class='fa fa-" . $DefaultStatus['icon'] . "'></i> " . $DefaultStatus['name'] . "</strong></a > ";
								echo "</fieldset>";
								
								
								echo "<fieldset><legend>Auftrag archivieren</legend>";
								echo "Möchtest du den Auftrag archivieren?<br><br>";
								echo "<a href='javascript:;' class='btn btn-danger ajax' data-action='orders.edit.archive' data-rc='.rc-stack2' data-url='&id=" . $Order->id() . "' data-toggle='modal' data-target='#stack2'><i class='fa fa-lock'></i> Auftrag archivieren</a>";
								echo "</fieldset>";
							
							
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		} else {
			echo HTML::danger("Status ungültig!", "Es wurde versucht, ein nicht gültiger Status zu ändern . ");
		}
		echo " </div > ";
	}
	
	/**
	 *
	 */
	function archive() {
		global $db;
		
		if ( Validator::isNumeric(Request::Get('id')) ) {
			$Order = new Order(Request::Get('id'));
			if ( $Order->exists() ) {
				if ( $Order->isArchived() ) {
					echo HTML::danger("Nicht möglich!", "Dieser Auftrag ist bereits archiviert und kann daher nicht mehr bearbeitet oder erneut archiviert werden.");
				} else {
					
					$Auftragsnummer = $Order->getOrderNumber();
					
					if ( Request::confirmed() ) {
						$OrderID = $Order->id();
						if(Application::NO_ARCHIVE){
							$OrderID = 0;
						}
						# @todo implement function in Order class for this action
						if ( $db->exec("UPDATE `auftraege` SET `archiv` = '1' WHERE `id` = " . $db->quote($OrderID)) !== false ) {
							echo HTML::success("Erfolgreich!", "Der Auftrag wurde erfolgreich archiviert.");
						} else {
							echo HTML::danger("Fehlgeschlagen!", "Die gewünschte Aktion konnte nicht ausgeführt werden.");
						}
					} else {
						
						echo "<h4><i class='fa fa-archive'></i> Auftrag archivieren</h4>";
						echo "<div class='rc-archive'></div>";
						echo "<br>";
						echo "Du möchtest den Auftrag <strong>" . $Auftragsnummer . " - " . e($Order->getName()) . "</strong> archivieren.<br><br>";
						echo "<span class='text-danger'><i class='fa fa-warning'></i> Bitte beachte, dass der Auftrag danach nicht mehr bearbeitet oder reaktiviert werden kann.</span>";
						echo "<br><br>";
						echo "<strong>Du kannst den Auftrag bedenkenlos archivieren wenn:</strong><br>";
						echo "&raquo; dein Kunde die Rechnung bezahlt hat.<br>";
						echo "&raquo; der Auftrag abgelehnt oder abgebrochen wurde.<br><br>";
						echo "Alternativ kannst du den Status des Auftrags nochmal auf <strong>Neu</strong> zurücksetzen, um mit einem verbesserten Angebot versuchen, den Auftrag doch noch zu bekommen.";
						echo "<br><br>";
						echo "<a href='javascript:;' class='btn btn-danger ajax' data-action='orders.edit.archive' data-rc='.rc-archive' data-url='&id=" . $Order->id() . "&confirm'><i class='fa fa-lock'></i> Auftrag jetzt archivieren</a>";
						
					}
					
					
				}
			} else {
				echo HTML::danger("Fehlgeschlagen!", "Es wurde ein ungültiger Auftrag angegeben.");
			}
		} else {
			echo HTML::danger("Fehlgeschlagen!", "Es wurde kein Auftrag angegeben.");
		}
	}

?>