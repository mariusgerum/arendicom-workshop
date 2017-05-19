<?php
	
	function loadOrders() {
		
		# @todo add the following:
		
		$where = "";
		if(Regex::match('/^[0-9\,]+$/i', Request::Get('status'))){
			$where = "AND status IN (" . Request::Get('status') . ")";
		}
		
		$Orders = Orders::getActiveOrders('id', 'desc', $where);
		
		if ($Orders) {
			/* @var \Order $Order */
			foreach ($Orders as $Order) {
				
				$Kunde = new Customer($Order->getCustomerID());
				
				$POffer = $Order->getOfferPricing();
				
				echo "<tr>";
				
				echo "<td><label class=\"mt-checkbox mt-checkbox-single mt-checkbox-outline\"><input class=\"group-checkable\" data-set=\"\" type=\"checkbox\" name='order_" . $Order->id() . "'><span></span></label></td>";
				echo "";
				
				
				echo "<td class='text-center'>" . $Order->number() . "</td>";
				echo "<td class='text-left'>";
				echo "<!--<i class='fa fa-info-circle default-blue cursor-pointer' onClick=\"$('.order-details-" . $Order->id() . "').toggle();\"></i> --><strong class='cursor-pointer' onClick=\"$('.order-details-" . $Order->id() . "').toggle();\">" . e($Order->getName()) . "</strong>";
				echo "<div class='order-details order-details-" . $Order->id() . "' hidden>";
				echo "<p title='Erstellt am " . date('d.m.Y H:i:s', $Order->getCreated()) . " Uhr'><i class='fa fa-calendar fa-fw'></i> Erstellt am " . date("d.m.Y", $Order->getCreated()) . " um " . date("H:i", $Order->getCreated()) . " Uhr</p>";
				echo "<p><i class='fa fa-handshake-o fa-fw'></i> Angebotspreis: <strong>" . Regex::formatPrice($Order->getOfferPricing()->getBrutto()) . "</strong></p>";
				echo "<p><i class='fa fa-money fa-fw'></i> Rechnungsbetrag: <strong>" . Regex::formatPrice(rand(10, 2000) / rand(2, 8)) . "</strong></p>";
				echo "</div>";
				echo "</td>";
				echo "<td class=''>" . e($Kunde->getName()) . "</td>";
				
				if ($Order->status() == '0') {
					echo "<td class='text-right'>";
				}
				if ($Order->hasStatus([1, 2, 3, 4, 5, 6, 7, 8])) {
					echo "<td class='text-right popovers' data-container='body' data-trigger='hover' data-html='true' data-placement='left' data-content='Netto: " . Regex::formatPrice($Order->getOfferPricing()->getNetto()) . "<br>Brutto: <strong>" . Regex::formatPrice($Order->getOfferPricing()->getBrutto()) . "</strong>' data-original-title='Preis'>";
					echo Regex::formatPrice($Order->getOfferPricing()->getBrutto());
				}
				if ($Order->status() >= 9) {
					echo "<td class='text-right'>";
					# @todo ab Rechnung versendet
				}
				echo "</td>";
				
				echo "<td class='text-center va-middle'>";
				$Status = Orders::getStatus($Order->status());
				if ($Status !== false) {
					echo "<a href='javascript:;' class='label label-warning statuslabel ajax' style='background-color: #" . $Status['background'] . "; color: #" . $Status['color'] . ";' data-action='orders.edit.manageStatus' data-rc='.rc-stack1' data-url='&id=" . $Order->id() . "' data-toggle='modal' data-target='#stack1'>";
					echo "<i class='fa fa-" . $Status['icon'] . "'></i> " . $Status['name'];
					echo "</a>";
				} else {
					echo "<a href='javascript:;' class='btn btn-default btn-sm' style='background-color: #cc0022; color: #ffffff;'>";
					echo "<i class='fa fa-close'></i>";
					echo "</a>";
				}
				/*
				for($i = 0; $i < 13; $i++){
					$Status = Orders::getStatus($i);
					if($Status !== false){
						echo "<a href='javascript:;' class='btn btn-default form-control' style='background-color: #" . $Status['background'] . "; color: #" . $Status['color'] . ";'>";
						echo "<i class='fa fa-" . $Status['icon'] . "'></i> " . $Status['name'];
						echo "</a>";
					}else{
						echo "<a href='javascript:;' class='btn btn-default btn-sm' style='background-color: #cc0022; color: #ffffff;'>";
						echo "<i class='fa fa-close'></i>";
						echo "</a>";
					}
					echo "<br><br>";
				}
				*/
				
				echo "</td>";
				echo "<td class='text-center'>";
				echo "<a title='Bearbeitungsmaske für Angebote, Rechnungen usw.' href='" . Routes::link('offer', ['id' => $Order->id()]) . "' class='btn btn-default'><i class='fa fa-file-text-o'></i></a>";
				echo "<a title='Diesen Auftrag bearbeiten' href='javascript:;' class='btn btn-default ajax' data-action='orders.edit.form_edit' data-rc='.rc-stack1' data-toggle='modal' data-target='#stack1' data-url='&id=" . e($Order->id()) . "'><i class='fa fa-edit'></i></a>";
				echo "</td>";
				
				echo "</tr>";
			}
		}
	}

?>