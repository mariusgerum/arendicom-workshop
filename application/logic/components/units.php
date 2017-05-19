<?php
	
	/**
	 *
	 */
	function loadUnits() {
		
		echo "<div class='rc-unit-list'></div>";
		
		echo "<table class='table table-striped fb-table va-middle'>";
		echo "<tr><th class='text-center'>Standard</th><th>Name</th><th class='text-right'>Optionen</th></tr>";
		foreach ( Application::getUnits() as $Unit ) {
			/* @var \Unit $Unit */
			echo "<tr>";
			
			# Check if default unit
			echo "<td class='text-center va-middle'>";
			if ( $Unit->isDefault() ) {
				echo "<i class='fa fa-check-square-o' style='color: #222222; font-size: 16px;'></i>";
			} else {
				echo "<a href='javascript:;' class='ajax' data-action='components.units.set_default' data-url='id=" . $Unit->id() . "' data-rc='.rc-unit-list' data-tc='.trigger-on-default-change'><i class='fa fa-square-o' style='color: #cccccc; font-size: 16px;'></i></a>";
			}
			echo "</td>";
			
			# Name
			echo "<td>" . e($Unit->getName()) . "</td>";
			
			# Options
			echo "<td class='text-right'>";
			echo "<a class='btn btn-default btn-sm ajax' data-action='components.units.form_edit' data-url='id=" . $Unit->id() . "' data-toggle='modal' data-target='#stack1' data-rc='.rc-stack1'><i class='fa fa-pencil'></i> <span class='hidden-xs'>Bearbeiten</span></a>";
			echo "<a class='btn btn-danger btn-sm ajax' data-action='components.units.deleteUnit' data-url='id=" . $Unit->id() . "' data-toggle='modal' data-target='#stack1' data-rc='.rc-stack1'><i class='fa fa-trash'></i> <span class='hidden-xs'>Löschen</span></a>";
			echo "</td>";
			
			echo "</tr>";
		}
		echo "</table>";
		
	}
	
	/**
	 *
	 */
	function mass_assignment() {
		global $db;
		if ( Request::Post('unit1', false) != false && Request::Post('unit2', false) != false ) {
			$Unit1 = new Unit(Request::Post('unit1'));
			$Unit2 = new Unit(Request::Post('unit2'));
			if ( $Unit1->exists() && $Unit2->exists() ) {
				if ( $Unit1->id() != $Unit2->id() ) {
					if ( $Unit1->isUsed() ) {
						
						$Orders = Orders::getActiveOrders('id', 'desc', "AND (`status` = '1' OR `status` = '0')");
						if ( $Orders !== false ) {
							/* @var \Unit $Order */
							
							$res = true;
							foreach ( $Orders as $Order ) {
								# @todo same for delivery notes and invoices
								$res1 = $db->exec("UPDATE `angebot` SET `einheit` = " . $db->quote($Unit2->id()) . " WHERE `auftrag` = " . $db->quote($Order->id()) . " AND `einheit` = " . $db->quote($Unit1->id()));
								if ( $res1 === false ) {
									$res = false;
									break;
								}
							}
							if ( $res !== false ) {
								$changed = intval($res1);
								echo HTML::success("Die Zuweisungen wurden erfolgreich vorgenommen. Es wurden insgesamt <strong>" . e($changed) . "</strong> Positionen aktualisiert.");
							} else {
								echo HTML::danger("Es ist ein Fehler aufgetreten.");
							}
						}
					} else {
						echo HTML::danger("Die Einheit <strong>" . e($Unit1->getName()) . "</strong> wird in keiner Position verwendet.");
					}
				}else{
					echo HTML::warning("Die Einheiten sind identisch.");
				}
			} else {
				echo HTML::danger("Die Einheit / Einheiten existieren nicht (mehr).");
			}
		} else {
			echo HTML::danger("Die 2 erforderlichen Einheiten wurden nicht übergeben.");
		}
	}
	
	/**
	 *
	 */
	function form_mass_assignment() {
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12 rc-unit-mass-assignment'>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo HTML::info("Info", "Mit der Massen-Zuweisung kannst du schnell alle Zuweisungen von Einheiten in Angebots- oder Rechnungspositionen auflösen und eine andere Einheit zuweisen.<br><br><i class='fa fa-warning'></i> Bitte beachte, dass das Auswirkungen auf alle Positionen in <strong>betreffenden, aktiven</strong> Aufträgen hat. Positionen aus bereits archivierten Aufträgen sind davon natürlich nicht betroffen, ebenso Aufträge, zu denen der Kunde bereits ein Angebot bekommen hat.");
		echo "</div>";
		echo "</div>";
		
		echo "<form id='frmUnitMassAssignment' method='POST'>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label class='form-label' for='Unit1'>Ändere alle Positionen mit der Einheit:</label>";
		echo "<select name='unit1' id='Unit1' class='form-control'>";
		foreach ( Application::getUnits() as $Unit ) {
			/* @var \Unit $Unit */
			if ( !$Unit->isUsed() ) {
				#continue;
			}
			echo "<option value='" . e($Unit->id()) . "'>" . e($Unit->getName()) . "</option>";
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label class='form-label' for='Unit2'>... und weise stattdessen folgende zu:</label>";
		echo "<select name='unit2' id='Unit2' class='form-control'>";
		foreach ( Application::getUnits() as $Unit ) {
			/* @var \Unit $Unit */
			echo "<option value='" . e($Unit->id()) . "'>" . e($Unit->getName()) . "</option>";
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<a class='btn btn-primary ajax-submit' data-form='#frmUnitMassAssignment' data-action='components.units.mass_assignment' data-rc='.rc-unit-mass-assignment'><i class='fa fa-gear'></i> Jetzt neu zuweisen</a>";
		echo "</div>";
		echo "</div>";
		
		echo "</form>";
	}
	
	/**
	 *
	 */
	function set_default() {
		if ( isset($_GET['id']) ) {
			$Unit = new Unit(Request::Get('id'));
			if ( $Unit->exists() ) {
				if ( $Unit->setDefault() ) {
					#echo HTML::success("Erfolgreich!", "Die Einheit <strong>" . e($Unit->getName()) . "</strong> wurde als Standard festgelegt.");
				} else {
					echo HTML::danger("Fehlgeschlagen.", "Leider ist ein unbekannter Fehler aufgetreten.");
				}
			}
		}
	}
	
	/**
	 *
	 */
	function edit() {
		if ( isset($_GET['id']) ) {
			$Unit = new Unit(Request::Get('id'));
			if ( $Unit->exists() ) {
				if ( $Unit->id() == 1 ) {
					echo HTML::warning("Nicht möglich", "Die Einheit <strong>" . e($Unit->getName()) . "</strong> ist die Standardeinheit und kann nicht geändert werden.");
				} else {
					if ( $Unit->isUsed() ) {
						echo HTML::danger("Nicht möglich", "Die Einheit kann nicht geändert werden, da sie in Verwendung ist.");
					} else {
						if ( trim(Request::Post('name')) != '' ) {
							if ( !Database::DuplicateEntryExists('einheiten', 'name', Request::Post('name'), $Unit->id()) ) {
								if ( $Unit->update([ 'name' ], $_POST) !== false ) {
									echo HTML::success("Erfolgreich aktualisiert.", "Die Einheit wurde erfolgreich geändert.");
								} else {
									echo HTML::danger("Fehlgeschlagen", "Die Einheit konnte leider nicht geändert werden.");
								}
							} else {
								echo HTML::danger("Fehlgeschlagen", "Eine Einheit mit dem Namen <strong>" . e(Request::Post('name')) . "</strong> existiert bereits.");
							}
							
						} else {
							echo HTML::danger("Name ist ein Pflichtfeld.", "Bitte gib einen Namen für die Einheit ein.");
						}
					}
				}
			}
		}
	}
	
	function form_edit() {
		if ( isset($_GET['id']) ) {
			$Unit = new Unit(Request::Get('id'));
			if ( $Unit->exists() ) {
				if ( $Unit->id() == 1 ) {
					echo HTML::warning("Nicht möglich", "Die Einheit <strong>" . e($Unit->getName()) . "</strong> ist die Standardeinheit und kann nicht geändert werden.");
				} else {
					if ( $Unit->isUsed() ) {
						echo HTML::warning("Nicht möglich", "Die Einheit kann nicht geändert werden, da sie in Verwendung ist.");
					} else {
						
						echo "<div class='row form-group'>";
						echo "<div class='col-md-12 rc-edit-unit'>";
						echo "</div>";
						echo "</div>";
						
						echo "<form id='frmEditUnit' method='POST'>";
						
						echo "<div class='row form-group'>";
						echo "<div class='col-md-12'>";
						echo "<label class='form-label' for='UnitName'>Name der Einheit</label>";
						echo "<input class='form-control' id='UnitName' placeholder='Name der Einheit' name='name' value='" . e($Unit->getName()) . "'>";
						echo "</div>";
						echo "</div>";
						
						echo "<div class='row form-group'>";
						echo "<div class='col-md-12'>";
						echo "<a class='btn btn-primary ajax-submit' data-form='#frmEditUnit' data-action='components.units.edit' data-url='id=" . $Unit->id() . "' data-rc='.rc-edit-unit'><i class='fa fa-save'></i> Speichern</a>";
						echo "</div>";
						echo "</div>";
						
						echo "</form>";
					}
				}
			} else {
				echo HTML::danger("Fehlgeschlagen", "Die angegebene Einheit existiert nicht (mehr).");
			}
		} else {
			echo HTML::danger("Das funktioniert nicht!", "Es wurde keine Einheit ausgewählt.");
		}
		
	}
	
	/**
	 *
	 */
	function create() {
		if ( trim(Request::Post('name')) != '' ) {
			if ( !Database::isDuplcateEntry('einheiten', 'name', Request::Post('name')) ) {
				if ( Application::createUnit(Request::Post('name')) !== false ) {
					echo HTML::success("Erfolgreich aktualisiert.", "Die Einheit wurde erfolgreich erstellt.");
				} else {
					echo HTML::danger("Fehlgeschlagen", "Die Einheit konnte leider nicht erstellt werden.");
				}
			} else {
				echo HTML::danger("Fehlgeschlagen", "Eine Einheit mit dem Namen <strong>" . e(Request::Post('name')) . "</strong> existiert bereits.");
			}
			
		} else {
			echo HTML::danger("Fehlgeschlagen", "Bitte gib einen Namen ein.");
		}
	}
	
	/**
	 *
	 */
	function form_create() {
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12 rc-create-unit'>";
		echo "</div>";
		echo "</div>";
		
		echo "<form id='frmCreateUnit' method='POST'>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<label class='form-label' for='UnitName'>Name der Einheit</label>";
		echo "<input class='form-control' id='UnitName' placeholder='Name der Einheit' name='name' autofocus>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row form-group'>";
		echo "<div class='col-md-12'>";
		echo "<a class='btn btn-primary ajax-submit' data-form='#frmCreateUnit' data-action='components.units.create' data-rc='.rc-create-unit'><i class='fa fa-save'></i> Einheit erstellen</a>";
		echo "</div>";
		echo "</div>";
		
		echo "</form>";
		
	}
	
	/**
	 * Remove unit
	 */
	function deleteUnit() {
		if ( Request::confirmed() ) {
			if ( isset($_GET['id']) ) {
				$Unit = new Unit(Request::Get('id'));
				if ( $Unit->exists() ) {
					if ( $Unit->id() == 1 ) {
						echo HTML::warning("Nicht möglich", "Die Einheit <strong>" . e($Unit->getName()) . "</strong> ist die Standardeinheit und kann nicht entfernt werden.");
					} else {
						if ( $Unit->isUsed() ) {
							echo HTML::warning("Nicht möglich", "Die Einheit kann nicht gelöscht werden, da sie in Verwendung ist.");
						} else {
							if ( $Unit->delete() ) {
								$SysUnit = new Unit(1);
								$SysUnit->setDefault();
								echo HTML::success("Erfolgreich!", "Die Einheit <strong>" . e($Unit->getName()) . "</strong> wurde erfolgreich gelöscht.");
							} else {
								echo HTML::danger("Fehlgeschlagen", "Das Löschen der Einheit ist fehlgeschlagen.");
							}
						}
					}
				} else {
					echo HTML::danger("Fehlgeschlagen", "Die angegebene Einheit existiert nicht (mehr).");
				}
			} else {
				echo HTML::danger("Das funktioniert nicht!", "Es wurde keine Einheit ausgewählt.");
			}
		} else {
			
			echo "<div class='rc-delete-unit'>";
			echo "<i class='fa fa-warning'></i> Die Einheit wird gelöscht und kann nicht wiederhergestellt werden. Bist du sicher?<br><br>";
			echo "<a class='btn btn-danger  ajax' data-action='components.units.deleteUnit' data-url='id=" . Request::Get('id') . "&confirmed' data-rc='.rc-delete-unit'><i class='fa fa-trash'></i> Löschen</a>";
			echo "</div>";
			
		}
		
		
	}

?>