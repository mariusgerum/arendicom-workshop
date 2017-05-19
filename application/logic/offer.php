<?php
	
	function loadOffer($options = []) {
		global $db;
		
		$Order = new Order(Request::Both('id'));
		
		if ( !$Order->exists() ) {
			echo HTML::danger("Auftrag konnte nicht gefunden werden.");
			
			return null;
		}
		
		$Offer = new Offer($Order->id());
		
		$Status = Orders::getStatus($Order->status());
		
		$Kunde = new Customer($Order->getCustomerID());
		if ( !$Kunde->exists() ) {
			echo HTML::danger("Kunde konnte nicht gefunden werden.");
			
			return null;
		}
		
		$Positionen = $Offer->getItems("ORDER BY `num` ASC");
		
		$Einheiten = Application::getUnits(true);
		$MwSt = Database::getData('mwst');
		
		ob_start();
		?>


        <div class="portlet light portlet-fit portlet-datatable">
            <div class="portlet-title">
                <div class="caption">
					<span class="caption-subject font-dark sbold uppercase">
						Angebot <?php echo $Offer->getNumber(); ?>
                        <span class="hidden-xs"></span>
					</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href="javascript:;" class="display-none alt-trigger ajax" data-action="offer.loadOffer" data-url="id=<?php echo e($Order->id()); ?>" data-rc=".rc-offer"></a>
                        <a href="javascript:;" class="btn btn-default ajax-submit trigger-on-modal-close" data-action="offer.saveOffer" data-form="#frmOffer" data-rc=".rc-offer">
                            <i class="fa fa-save"></i> Angebot speichern
                        </a>
                        <a href="javascript:;" class="btn btn-default ajax" data-action="offer.pdf_preview" data-rc=".rc-offer" data-url="id=<?php echo e($Order->id()); ?>">
                            <i class="fa fa-share"></i> Angebot fertigstellen
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <form method="POST" id="frmOffer" class="cfs">

            <input type="hidden" name="id" value="<?php echo $Order->id(); ?>">

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="portlet light document-portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <!--<i class="fa fa-user"></i>-->
                                Kunde
                            </div>
                            <div class="actions">
                                <a href='javascript:;' title='Kunde bearbeiten' class='btn btn-default fs-11 ajax' data-action='customers.edit.form_edit' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1' data-url='&id=<?php echo e($Kunde->id()); ?>'>
                                    <i class="fa fa-pencil"></i> Bearbeiten </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-1 name">
                                    <i class="fa fa-fw fa-building-o" style="color: #cccccc;"></i>
                                </div>
                                <div class="col-md-11 value" style="font-weight: normal;"> <?php echo e($Kunde->getCompany()); ?></div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-1 name">
                                    <i class="fa fa-fw fa-user" style="color: #cccccc;"></i>
                                </div>
                                <div class="col-md-11 value" style="font-weight: normal;">
									<?php
										echo e($Kunde->getFirstName());
										echo " ";
										echo e($Kunde->getLastName());
										echo " <small><a href='mailto:" . e($Kunde->getEmail()) . "'>" . e($Kunde->getEmail()) . "</a></small>";
									?>
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-1 name">
                                    <i class="fa fa-fw fa-map-marker" style="color: #cccccc;"></i>
                                </div>
                                <div class="col-md-11 value" style="font-weight: normal;"> <?php echo e($Kunde->getStreet()); ?>, <?php echo e($Kunde->getZip()); ?> <?php echo e($Kunde->getCity()); ?></div>
                            </div>
							<?php /*
						<div class="row static-info">
							<div class="col-md-1 name"><i class="fa fa-fw fa-envelope" style="color: #cccccc;"></i>
							</div>
							<div class="col-md-11 value" style="font-weight: normal;">
								<a href="mailto:<?php echo e($Kunde->getEmail()); ?>"><?php echo e($Kunde->getEmail()); ?></a>
							</div>
						</div>
                        */ ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="portlet light document-portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <!--<i class="fa fa-book"></i>-->
                                Auftragsdetails
                            </div>
                            <div class="actions">
                                <a href="javascript:;" class="btn btn-default btn-sm fs-11 ajax" data-action='orders.edit.form_edit' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1' data-url='&id=<?php echo e($Order->id()); ?>'>
                                    <i class="fa fa-pencil"></i> Bearbeiten </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-1 name">
                                    <i class="fa fa-book fa-fw" style="color: #dddddd;"></i>
                                </div>
                                <div class="col-md-11 value"> <?php echo e($Order->getOrderNumber()); ?> - <?php echo e($Order->getName()); ?>
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-1 name">
                                    <i class="fa fa-flag fa-fw" style="color: #dddddd;"></i>
                                </div>
                                <div class="col-md-11 value">
									<?php
										# @todo Feature: statuschange to "New" automatically changes to "Offer created". Provide turning off automatic statuschanges
										echo "<a href='javascript:;' class='label label-warning ajax' style='background-color: #" . $Status['background'] . "; color: #" . $Status['color'] . ";' data-action='orders.edit.manageStatus' data-rc='.rc-stack1' data-url='&id=" . $Order->id() . "' data-toggle='modal' data-target='#stack1'>";
										echo "<i class='fa fa-" . $Status['icon'] . "'></i> " . $Status['name'];
										echo "</a>";
									?>
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-1 name">
                                    <i class="fa fa-money fa-fw" style="color: #dddddd;"></i>
                                </div>
                                <div class="col-md-11 value">
									<?php
										echo "<span class='popovers' data-container='body' data-trigger='hover' data-html='true' data-placement='bottom' data-content='Brutto: " . Regex::formatPrice($Offer->getPriceBrutto()) . "<br>Netto: " . Regex::formatPrice($Offer->getPriceNetto()) . "' data-original-title='Preis'>";
										
										echo Regex::formatPrice($Offer->getPriceBrutto()) . " <small style='font-weight: 100;'>inkl. MwSt.</small>";
										
										echo "</span>";
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <!--<i class="fa fa-pencil"></i>-->
                                Angebotspositionen
                            </div>
                        </div>
                        <div class="portlet-body">
                            
                            <input type="text" class="form-control" name="einleitungstext" placeholder="Einleitungstext" value="<?php echo e($Offer->getIntroductionText()); ?>">
                            
                            <div class="table-responsive">
                                <table class="table table-hover positions-table no-border" id="PositionsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <!--<th></th>-->
                                            <th>Produkt / Dienstleistung</th>
                                            <th class="text-center">Menge</th>
                                            <th class="text-center">Einheit</th>
                                            <th class="text-center">MwSt</th>
                                            <th class="text-right">Preis</th>
                                            <th class="text-center">Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											
											
											if ( empty($Positionen) ) {
												if ( $Order->status() == '1' ) {
													$Order->setStatus(0);
												}
											} else {
												if ( $Order->status() == '0' ) {
													$Order->setStatus(1);
												}
												$PositionCount = 1;
												/* @var OfferItem $Item */
												foreach ( $Offer->getItems("ORDER BY `num` ASC") as $Item ) {
													
													echo "<tr id='PositionRow" . $PositionCount . "' class='row-" . $PositionCount . "'>";
													
													echo "<td id='TDReorder" . $PositionCount . "' class='pt-reorder sortable-handle text-center reorder' style='cursor: move;' title='" . $Item->getId() . "'>";
													echo "<i class='fa fa-sort' style='color: #cccccc;'></i> <span style='color: #222222;'>" . $PositionCount . ".</span>";
													echo "<input type='hidden' name='pos[]' value='" . $Item->getId() . "'>";
													echo "<input type='hidden' name='num[" . $Item->getId() . "]' value='" . $Item->getNum() . "'>";
													echo "</td>";
													
													// echo "<td class='text-center va-middle pt-check'><input type='checkbox' name='posid'></td>";
													
													# Titel und Positionstext
													echo "<td class='pt-position'>";
													echo "<input class='form-control bold' type='text' name='titel[" . $Item->getId() . "]' value='" . e($Item->getTitle()) . "' " . ( isset($options['new_item']) ? 'autofocus' : '' ) . " placeholder='Produkt / Leistung'>";
													echo "<div style='height: 8px;'></div>";
													echo "<textarea class='form-control autosizeme'  name='position[" . $Item->getId() . "]' placeholder='Detaillierte Beschreibung' rows='1'>" . e($Item->getText()) . "</textarea>";
													echo "</td>";
													
													# Menge
													echo "<td class='text-center pt-menge'>";
													echo "<input class='form-control auto-width inline-block text-center' type='text' name='menge[" . $Item->getId() . "]' value='" . e($Item->getQuantity()) . "'>";
													echo "</td>";
													
													# Einheit
													echo "<td class='text-center pt-einheit'>";
													/*
													?>
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-default">Einheit <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <?php
	                                                            foreach ( $Einheiten as $Einheit ) {
		                                                            # var \Unit $Einheit
		                                                            // echo "<option value='" . e($Einheit->id()) . "'";
		                                                            echo "<li><input type='radio' id='UnitID" . $Einheit->id() . "' name='einheit[" . $Item->getId() . "]' value='" . e($Einheit->id()) . "'><label for='UnitID" . $Einheit->id() . "' " . ($Einheit->id() == $Item->getUnit()->id() ? ' checked' : '') . ">" . e($Einheit->getName()) . "</label></li>";
		                                                            if ( $Einheit->id() == $Item->getUnit()->id() ) {
			                                                            // echo " selected";
		                                                            }
		                                                            // echo ">" . e($Einheit->getName()) . "</option>";
	                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
													<?php
													*/
													
													echo "<select class='form-control auto-width inline-block' name='einheit[" . $Item->getId() . "]'>";
													foreach ( $Einheiten as $Einheit ) {
														# var \Unit $Einheit
														echo "<option value='" . e($Einheit->id()) . "'";
														if ( $Einheit->id() == $Item->getUnit()->id() ) {
															echo " selected";
														}
														echo ">" . e($Einheit->getName()) . "</option>";
													}
													echo "</select>";
													
													echo "</td>";
													
													# MwSt
													echo "<td class='text-center pt-mwst'>";
													echo "<select class='form-control auto-width inline-block' name='mwst[" . $Item->getId() . "]'>";
													foreach ( $MwSt as $ST ) {
														echo "<option value='" . e($ST['id']) . "'";
														if ( $ST['id'] == $Item->getVatId() ) {
															echo " selected";
														}
														echo ">" . e($ST['name']) . "</option>";
													}
													echo "</select>";
													echo "</td>";
													
													# @todo customizable input steps (+1, +0.5, +?)
													echo "<td class='text-center pt-preis'><input class='form-control auto-width inline-block text-center' type='text' name='preis[" . $Item->getId() . "]' step='0.50' value='" . e($Item->Pricing()->getSinglePrice()) . "'></td>";
													
													echo "<td class='cell-actions'>";
													echo "<input type='hidden' id='PosTrash" . $Item->getId() . "' name='trash[" . $Item->getId() . "]' value='0'>";
													// echo "<div class='btn-group' role='group' aria-label='...'>";
													// echo "<a href='javascript:;' class='btn btn-primary btn-sm ajax' onClick=\"$('table tr.second-row-" . $PositionCount . "').toggle();\"><i class='fa fa-gear'></i></a>";
													echo "<a href='javascript:;' class='x-btn x-btn-primary x-btn-sm label label-default trigger-alt ajax-submit' data-action='offer.advanced_editing' data-url='id=" . $Item->id() . "' data-form='#frmOffer' data-toggle='modal' data-target='#stack1' data-rc='.rc-stack1'><i class='fa fa-gear'></i></a>";
													echo "<a href='javascript:;' class='x-btn x-btn-default x-btn-sm label label-default active ajax-submit' data-action='offer.saveOffer' data-url='duplicate=" . $Item->getId() . "' data-form='#frmOffer' data-rc='.rc-offer'><i class='fa fa-clone'></i></a>";
													echo "<a href='javascript:;' class='x-btn x-btn-danger x-btn-sm label label-default remove-position' onClick=\"jQuery('table tr.row-" . $PositionCount . "').toggleClass('trash'); jQuery('#PosTrash" . $Item->getId() . "').val(jQuery('#PosTrash" . $Item->getId() . "').val() == 1 ? 0 : 1);\"><i class='fa fa-trash'></i></a>";
													// echo "</div>";
													echo "</td>";
													
													echo "</tr>";
													
													$PositionCount++;
												}
											}
										
										
										?>
                                    </tbody>
                                </table>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
									<?php
										echo "<a href='javascript:;' class='btn btn-default btn-sm ajax-submit' data-action='offer.create_item' data-url='id=" . $Order->id() . "' data-form='#frmOffer' data-rc='.rc-offer'><i class='fa fa-plus-circle'></i> Position hinzufügen</a>";
									?>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
										<?php /*
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name"> Positionen:</div>
                                            <div class="col-md-3 value"> <?php echo count($Positionen); ?> </div>
                                        </div>
                                        */ ?>
                                        <div class="row x-static-info align-reverse">
                                            <div class="col-md-8 name"> Summe (Netto):</div>
                                            <div class="col-md-3 value right"> <?php echo Regex::formatPrice($Offer->getPriceNetto()); ?> </div>
                                        </div>
										<?php
											foreach ( $Order->getOfferPricing()->getVatPrices() as $VP ) {
												echo "<div class='row x-static-info align-reverse'>";
												echo "<div class='col-md-8 name'> Mehrwertsteuer: " . format_decimal($VP['vat']) . "% von " . Regex::formatPrice($VP['price']['netto']) . " </div>";
												echo "<div class='col-md-3 value right'> " . Regex::formatPrice($VP['price']['vat']) . "</div>";
												echo "</div>";
											}
										
										?>

                                        <div class="row x-static-info align-reverse">
                                            <div class="col-md-8 name"> Endbetrag (Brutto):</div>
                                            <div class="col-md-3 value right">
                                                <span style="border-bottom: 3px double #444444; padding-left: 4px;"> <?php echo Regex::formatPrice($Offer->getPriceBrutto()); ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <!--<i class="fa fa-pencil"></i>-->
                                Zusatzoptionen
                            </div>
                        </div>
                        <div class="portlet-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase"></span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#notice" class='bold' data-toggle="tab">Zusatztexte</a>
                                            </li>
                                            <li>
                                                <a href="#payment_conditions" class='bold' data-toggle="tab">Zahlungsbedingungen</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane with-padding active" id="notice">
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <small>Zusatztexte</small>
                                                        <textarea class="form-control autosizeme" rows="4" name="notiz_a"><?php echo e($Offer->getNotice()); ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small>Interne Notizen (für den Kunden nicht sichtbar)</small>
                                                        <textarea class="form-control autosizeme" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane with-padding active" id="payment_conditions">
                                                <div class="row form-group">
                                                
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row form-group">
                                <div class="col-md-12 right">
                                    <a href="javascript:;" class="btn btn-success ajax-submit trigger-on-modal-close" data-action="offer.saveOffer" data-form="#frmOffer" data-rc=".rc-offer">
                                        <i class="fa fa-save"></i> Angebot speichern
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>


        </form>
		
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		
		echo $content;
		
	}
	
	function saveOffer($options = []) {
		/* @var \PDO $db */
		global $db;
		
		
		if ( is_numeric(Request::Both('id')) ) {
			
			$Offer = new Offer(Request::Both('id'));
			
			if ( $Offer->exists() ) {
				
				# Save notice
				$Offer->update('notiz_a', Request::Post('notiz_a'));
				
				if ( is_array(Request::Post('pos')) ) {
					/* @var array $Pos */
					$Pos = Request::Post('pos');
					if ( isset($Pos[0]) ) {
						$db->beginTransaction();
						$Success = [];
						$num = 0;
						foreach ( $Pos as $pid ) {
							try {
								
								$Item = new OfferItem($pid);
								
								if ( !$Item->exists() ) {
									echo HTML::danger("Fehler", "Die Position existiert nicht.", "note");
									
									return null;
								}
								
								if ( Request::Post('trash')[$pid] == 1 && Request::Get('duplicate') != $pid ) {
									if ( $Item->removeItem() ) {
										continue;
									} else {
										echo HTML::danger("Fehlgeschlagen", "Die gewünschte(n) Position(en) konnte(n) nicht gelöscht werden.", "note");
									}
								}
								
								# Validate values
								$menge = Regex::makeFloat(Request::Post('menge')[$pid]);
								if ( $menge === false ) {
									echo HTML::danger("Fehlgeschlagen", "Menge ist ein ungültiger Wert.");
									$Success[] = false;
									continue;
								}
								
								$preis = Regex::makeFloat(Request::Post('preis')[$pid]);
								if ( $preis === false ) {
									echo HTML::danger("Fehlgeschlagen", "Preis ist ein ungültiger Wert.");
									$Success[] = false;
									continue;
								}
								
								$stmt = "UPDATE `angebot` SET ";
								$stmt .= "`num` = " . $db->quote($num) . ", ";
								$stmt .= "`titel` = " . $db->quote(Request::Post('titel')[$pid]) . ", ";
								$stmt .= "`position` = " . $db->quote(Request::Post('position')[$pid]) . ", ";
								$stmt .= "`menge` = " . $db->quote(Request::Post('menge')[$pid]) . ", ";
								$stmt .= "`einheit` = " . $db->quote(Request::Post('einheit')[$pid]) . ", ";
								$stmt .= "`mwst` = " . $db->quote(Request::Post('mwst')[$pid]) . ", ";
								$stmt .= "`preis` = " . $db->quote(Request::Post('preis')[$pid]) . "";
								$stmt .= " WHERE `id` = " . $db->quote($Item->id()) . " AND `auftrag` = " . $db->quote(Request::Post('id'));
								
								#echo $stmt . "<br>";
								$db->exec($stmt);
								$Success[] = true;
								
								$num++;
								
							} catch (Exception $e) {
								$Success[] = false;
							}
						}
						
						if ( is_numeric(Request::Get('duplicate')) ) {
							$DItem = new OfferItem(Request::Get('duplicate'));
							if ( $DItem->exists() ) {
								$DItem->duplicate();
							}
						}
						
						if ( !in_array(false, $Success) ) {
							HTML::setFixed();
							echo HTML::success("Dein Angebot wurde gespeichert.");
							$db->commit();
						} else {
							echo HTML::danger("Fehlgeschlagen", "Die Positionen konnten nicht gespeichert werden.");
							$db->rollBack();
						}
					}
				}
			}
			if ( !isset($options['no_offer_reload']) ) {
				loadOffer();
			}
		} else {
		
		}
		
	}
	
	/**
	 *
	 */
	function send_form() {
		
		$Offer = new Offer(Request::Get('id'));
		
		if ( !$Offer->exists() ) {
			echo HTML::danger("Das Angebot existiert nicht.");
			
			return "";
		}
		
		$Customer = $Offer->getCustomer();
		if ( !$Customer->exists() ) {
			echo HTML::danger("Der zugewiesene Kunde existiert nicht (mehr).");
			
			return "";
		}
		
		if ( !$Customer->hasEmail() ) {
			echo HTML::info("Für den Kunden ist keine E-Mail Adresse hinterlegt.", "", "note");
		}
		
		echo "<form method='POST' id='frmSendOffer'>";
		?>
        <div class="row form-group">
            <div class="col-md-12">
                <small>E-Mail</small>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input class="form-control" placeholder="E-Mail" type="text" name="email" value="<?php echo e($Customer->getEmail()); ?>">
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <small>Betreff</small>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-file-text-o"></i>
                    </span>
                    <input class="form-control" placeholder="E-Mail" type="text" name="subject" value="Angebot <?php echo e($Offer->getNumber()); ?> - <?php echo e($Offer->getName()); ?>">
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <small>Nachricht</small>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-file-text-o"></i>
                    </span>
                    <textarea class="form-control autosizeme" placeholder="Nachricht"><?php echo $Offer->getMailTemplate(); ?></textarea>
                </div>
                <small><i class="fa fa-info-circle"></i> Du kannst die Angebots-Mailvorlage in den
                    <a href="/Settings/Text-Templates#MailTemplates">Einstellungen bearbeiten</a>.
                </small>
            </div>
        </div>
		
		<?php
		echo "</form>";
	}
	
	/**
	 *
	 */
	function create_item() {
		
		saveOffer([ 'no_offer_reload' => true ]);
		
		$options = [];
		
		$Offer = new Offer(Request::Get('id'));
		if ( $Offer->exists() ) {
			$res = $Offer->createItem(true);
			if ( $res !== false ) {
				$options['new_item'] = $res;
				HTML::setFixed();
				echo HTML::success("Position wurde erstellt und dein Angebot automatisch gespeichert.");
			} else {
				echo HTML::danger("Fehlgeschlagen!", "Es konnte keine neue Position erstellt werden.", "note");
			}
		} else {
			echo HTML::danger("Fehlgeschlagen!", "Ungültiger Auftrag.", "note");
		}
		loadOffer($options);
	}
	
	
	/**
	 * @return null
	 */
	function advanced_editing() {
		
		saveOffer([ 'no_offer_reload' => true ]);
		
		$Item = new OfferItem(Request::Get('id'));
		if ( !$Item->exists() ) {
			echo HTML::danger("Fehlgeschlagen!", "Die Position existiert nicht (mehr).");
			
			return null;
		}
		
		$Offer = new Offer($Item->getOrderID());
		
		?>
        <div class="row form-group">
            <div class="col-md-12 rc-save-pos">

            </div>
        </div>

        <div class="portlet-body">
            <form id="frmSaveOfferItem" method="POST">
                <div class="tabbable-custom ">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#create_customer_tab_1" data-toggle="tab"> Position </a>
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
                            <h4>Position bearbeiten</h4>

                            <div class="row form-group">
                                <div class="col-md-6 col-sm-12">
                                    <small>Produkt / Leistung</small>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-file-text-o"></i>
                                        </span>
                                        <input class="form-control bold" placeholder="" type="text" name="titel" value="<?php echo e($Item->getTitle()); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-12">
                                    <small>Ausführliche Produkt- / Leistungsbeschreibung</small>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-file-text-o"></i>
                                        </span>
                                        <textarea class="form-control autosizeme" name="position"><?php echo e($Item->getText()); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6 col-sm-12">
                                    <small>Menge</small>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input class="form-control" placeholder="" type="text" name="menge" value="<?php echo e($Item->getQuantity()); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <small>Einheit</small>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </span>
										<?php
											$Einheiten = Application::getUnits();
											echo "<select class='form-control' name='einheit'>";
											foreach ( $Einheiten as $Einheit ) {
												/* @var \Unit $Einheit */
												echo "<option value='" . e($Einheit->id()) . "'";
												if ( $Einheit->id() == $Item->getUnit()->id() ) {
													echo " selected";
												}
												echo ">" . e($Einheit->getName()) . "</option>";
											}
											echo "</select>";
										?>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6 col-sm-12">
                                    <small>Steuer</small>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </span>
										<?php
											$MwSt = Database::getData('mwst');
											echo "<select class='form-control' name='mwst'>";
											foreach ( $MwSt as $ST ) {
												echo "<option value='" . e($ST['id']) . "'";
												if ( $ST['id'] == $Item->getVatId() ) {
													echo " selected";
												}
												echo ">" . e($ST['name']) . "</option>";
											}
											echo "</select>";
										?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <small>Einzelpreis</small>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eur"></i>
                                        </span>
                                        <input class="form-control" placeholder="" type="text" name="preis" step="0.01" value="<?php echo e($Item->getSinglePrice()); ?>">
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
								echo HTML::info("Demnächst verfügbar", "", "note");
							?>
                        </div>
                    </div>
                </div>
				
				<?php /* <a href="javascript:;" id='BtnReloadOffer' style="" data-action="offer.loadOffer" data-url="id=<?php echo e($Offer->id()); ?>" data-rc=".rc-offer">xxx</a> */ ?>

                <div class="row form-group">
                    <div class="col-md-12 right">
                        <button type="button" class="btn btn-primary ajax-submit" data-action="offer.save_advanced_editing" data-rc=".rc-save-pos" data-url='id=<?php echo e($Item->id()); ?>' data-form="#frmSaveOfferItem" data-tc="#BtnReloadOffer">
                            <i class="fa fa-save"></i> Speichern
                        </button>
                    </div>
                </div>

            </form>
        </div>
		<?php
	}
	
	function save_advanced_editing() {
		$Item = new OfferItem(Request::Get('id'));
		if ( $Item->exists() ) {
			
			$stmt = "UPDATE `angebot` SET ";
			$stmt .= "`position` = " . Database::escape(Request::Post('position')) . ", ";
			$stmt .= "`menge` = " . Database::escape(Request::Post('menge')) . ", ";
			$stmt .= "`einheit` = " . Database::escape(Request::Post('einheit')) . ", ";
			$stmt .= "`mwst` = " . Database::escape(Request::Post('mwst')) . ", ";
			$stmt .= "`preis` = " . Database::escape(Request::Post('preis')) . "";
			$stmt .= " WHERE `id` = " . Database::escape($Item->id());
			
			$res = Database::execute($stmt);
			if ( $res !== false ) {
				echo HTML::success("Erfolgreich!", "Die Änderungen an der Position wurden erfolgreich gespeichert.");
			} else {
				echo HTML::danger("Fehlgeschlagen!", "Die Änderungen konnten nicht gespeichert werden.");
			}
			
			
		} else {
			echo HTML::danger("Fehlgeschlagen!", "Diese Position gibt es nicht (mehr).");
		}
	}
	
	function pdf_preview() {
		$Offer = new Offer(Request::Get('id'));
		if ( !$Offer->exists() ) {
			echo HTML::danger("Fehlgeschlagen!", "Dieses Angebot existiert nicht(mehr).");
			
			return "";
		}
		
		?>
        <div class="portlet light portlet-fit portlet-datatable">
            <div class="portlet-title">
                <div class="caption">
					<span class="caption-subject font-dark sbold uppercase">
						Angebot <?php echo $Offer->getNumber(); ?>
                        <span class="hidden-xs"></span>
					</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href="javascript:;" class="btn btn-default ajax" data-action="offer.loadOffer" data-url="id=<?php echo $Offer->id(); ?>" data-rc=".rc-offer">
                            <i class="fa fa-pencil"></i> Angebot bearbeiten
                        </a>
                        <a href="javascript:;" class="btn btn-default ajax" data-action="offer.pdf_preview" data-rc=".rc-offer" data-url="id=<?php echo e($Offer->id()); ?>">
                            <i class="fa fa-share"></i> Angebot fertigstellen
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
				<?php
				
				
				?>
                <div style="display: block; margin: 16px auto; width: calc(100% - 132px);">
					
					<?php
						if ( $Offer->PDFExists() ) {
							$file = [];
							$file['name'] = $Offer->getOfferPdfFilename();
							$file['mtime'] = filemtime($file['name']);
							echo HTML::info("Info", "Das Angebot wurde zuletzt <i class='bold'>" . DT::getBeforeDaysText($file['mtime']) . date("d.m.Y", $file['mtime']) . " um " . date("H:i", $file['mtime']) . " Uhr</i> aktualisiert. Wenn du zwischenzeitlich Änderungen vorgenommen hast (Positionen hinzugefügt oder geändert), klicke auf &raquo;<strong>PDF neu erzeugen</strong>&laquo;.", "note");
						}
					?>

                    <div style="margin: 16px 0px;">
                        <a class="btn btn-primary ajax" data-action="offer.send_form" data-url="id=<?php echo e($Offer->id()); ?>" data-toggle="modal" data-target="#stack1" data-rc=".rc-modal"><i class="fa fa-paper-plane"></i> Angebot versenden</a>
                        <a class="btn btn-default" href="<?= $Offer->getOfferURL(""); ?>" target="_blank"><i class="fa fa-eye"></i> In neuem Tab ansehen</a>
                        <a class="btn btn-default" href="<?= $Offer->getOfferURL("download"); ?>" target="_blank"><i class="fa fa-download"></i> Herunterladen</a>
                        <!--<a class="btn btn-primary ajax" data-action="offer.renew_pdf" data-toggle="modal" data-target="#stack1" data-rc=".rc-modal"><i class="fa fa-reload"></i> Angebot versenden</a>-->
						<?php
							$RenewPDFToken = Auth::createToken();
							$_SESSION['renew_token'] = $RenewPDFToken;
						?>
                        <a class="btn btn-primary" href="javaScript:;" onClick="jQuery('iframe[name=offerframe]').attr('src', '<?= $Offer->getOfferURL("renew_token=" . $RenewPDFToken); ?>');"><i class="fa fa-refresh"></i> PDF neu erzeugen</a>
                    </div>
					
					<?php
						
						$pdf = $Offer->getOfferURL();
						echo $pdf;
						echo "<iframe src='" . $pdf . "' name='offerframe' style='width: 100%; min-height: 1500px;'></iframe>";
					
					?>


                </div>
            </div>
        </div>
		<?php
	}

?>