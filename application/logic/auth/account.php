<?php
	
	/**
	 * Login
	 */
	function login() {
		$email = Request::Post('email');
		$pass = Request::Post('pass');
		
		if ( $email != '' && $pass != '' ) {
			if ( Validator::isEmail($email) ) {
				if ( Auth::login(['email' => $email, 'password' => $pass]) ) {
					echo HTML::success("Login erfolgreich", "Du wirst weitergeleitet...<br><small style='color: #ffffff;'>Falls die automatische Weiterleitung nicht funktioniert, klicke bitte <a href='/'>hier</a></small>");
					echo "<script type='text/javascript'>setTimeout(function(){ location.href = '/'; }, 2000);</script>";
				} else {
					echo HTML::danger("Login fehlgeschlagen", "Benutzername und/oder Passwort ist nicht korrekt!");
				}
			} else {
				echo HTML::danger("Bitte gib eine <u>gültige</u> E-Mail Adresse ein.");
			}
		} else {
			echo HTML::danger("Bitte gib E-Mail Adresse und Passwort ein.");
		}
		
	}
	
	/**
	 *
	 */
	function forgot_password() {
		global $sysdb;
		if ( Validator::isEmail(Request::Post('email')) ) {
			Account::set($sysdb->query("SELECT * FROM `accounts` WHERE `email` = " . $sysdb->quote(strtolower(Request::Post('email'))))->fetch());
			if ( Account::exists() ) {
				if ( trim(Account::get('register_token')) == '' ) {
					$RecoverPasswordResult = Auth::RecoverPassword(Account::get('id'), Account::get('email'));
					if ( $RecoverPasswordResult === true ) {
						echo HTML::success("Erfolgreich", "Super, wir haben dir eine Mail geschickt. Öffne den darin enthaltenen Link, um dein Passwort zurückzusetzen.");
					} else {
						echo HTML::danger($RecoverPasswordResult);
					}
				} else {
					echo HTML::danger("Es scheint als wäre dieser Account noch nicht bestätigt. Bitte öffne den Bestätigungslink den wir dir in der Registrierungsmail gesendet haben.");
				}
			} else {
				echo HTML::danger("Leider existiert kein Account mit dieser E-Mail Adresse.<br><br>Hast du vergessen, mit welcher E-Mail Adresse du dich registriert hast? Dann kontaktiere bitte unseren Support, damit wir diesen Umstand schnell aufklären können:<br><br><i class='fa fa-envelope'></i> <a href='mailto:" . APP_NAME . " Support <" . MAIL_SUPPORT . ">'>" . MAIL_SUPPORT . "</a><!--<br><i class='fa fa-phone'></i> " . HOTLINE . "-->");
			}
		} else {
			echo HTML::danger('Bitte gib eine <u>gültige</u> E-Mail Adresse ein.');
		}
	}
	
	/**
	 *
	 */
	function register() {
		
		# Check name
		if ( Regex::match('/^\S+? \S+?( .+?)?$/i', Request::Post('voller_name')) ) {
			
			$Vorname = Regex::replace('/^(.+?) .+/i', '$1', Request::Post('voller_name'));
			$Nachname = Regex::replace('/^(.+?) (.+)/i', '$2', Request::Post('voller_name'));
			
			# Check company
			if ( Regex::match('/^.+$/i', Request::Post('firma')) || true ) {
				
				# Check email
				if ( Regex::match('/^\S+?\@\S+?\.\S+$/i', Request::Post('email')) ) {
					
					# Check password
					if ( Auth::checkPassword(Request::Post('passwort')) === true ) {
						if ( Request::Post('passwort') == Request::Post('passwort2') ) {
							
							if ( Request::Post('tnc') != '' ) {
								# Everything is fine
								
								$Data = [
									'email'          => strtolower(Request::post('email')),
									'passwort'       => Auth::hash(Request::Post('passwort')),
									'firma'          => Request::post('firma'),
									'vorname'        => $Vorname,
									'name'           => $Nachname,
									'register_token' => Auth::createToken(),
									'register_date'  => date('Y-m-d H:i:s')
								];
								
								$RegistrationResult = Auth::prepareRegistration($Data);
								if ( $RegistrationResult === true ) {
									echo HTML::success("Anmeldung erfolgreich!", "Wir haben dir eine E-Mail an deine eingegebene Adresse gesendet. Bitte öffne den darin enthaltenen Bestätigungslink, um deine Registrierung bei " . APP_NAME . " erfolgreich abzuschließen.<br><br>Bis gleich!");
								} else {
									echo HTML::danger("Fehlgeschlagen", (string)$RegistrationResult);
								}
								
								/*
								if ( Request::Post('subdomain', false) !== false ) {
									
								} else {
									echo "<div class=\"form-group\">";
									echo "<label class=\"control-label visible-ie8 visible-ie9\">Dein persönlicher Zugangslink</label>";
									echo "<div class=\"input-icon\">";
									echo "<i class=\"fa fa-user\"></i>";
									echo "<input class=\"form-control placeholder-no-fix\" type=\"text\" placeholder='Dein Link' name=\"subdomain\" title='Über diesen Link gelangst du direkt in dein persönliches " . APP_NAME . "' /></div>";
									echo "</div>";
								}
								*/
							} else {
								echo HTML::danger("Bitte bestätige die AGB.");
							}
							
						} else {
							echo HTML::danger("Die Passwörter scheinen nicht gleich zu sein. Bitte wiederhole das Passwort zum Abgleich.");
						}
					} else {
						echo HTML::danger(Auth::checkPassword(Request::Post('passwort')));
					}
				} else {
					echo HTML::danger("Bitte gib eine <u>gültige</u> E-Mail Adresse ein.");
				}
			} else {
				echo HTML::danger("Bitte gib den Namen deiner Firma ein.");
			}
		} else {
			echo HTML::danger("Bitte gib deinen vollen Namen (Vor- und Nachname) ein. Der Zweitname ist nicht erforderlich.");
		}
		
	}
	
	/**
	 * Recovers the users password and sets a new one
	 */
	function set_new_password() {
		
		# Check password
		if ( Auth::checkPassword(Request::Post('passwort')) === true ) {
			if ( Request::Post('passwort') == Request::Post('passwort2') ) {
				$Data = [
					'id'       => Request::Post('id'),
					'token_id' => Request::Post('token_id'),
					'passwort' => Request::Post('passwort')
				];
				$SetNewPasswordResult = Auth::SetNewPassword($Data);
				if ( $SetNewPasswordResult === true ) {
					echo HTML::success("Super!", "Du hast dein Passwort erfolgreich geändert und kannst dich <a href='/auth.login' style='color: #ffffff; text-decoration: underline;'>jetzt einloggen</a>.");
				} else {
					echo HTML::danger("Fehlgeschlagen", (string)$SetNewPasswordResult);
				}
				
			} else {
				echo HTML::danger("Die Passwörter scheinen nicht gleich zu sein. Bitte wiederhole das Passwort zum Abgleich.");
			}
		} else {
			echo HTML::danger(Auth::checkPassword(Request::Post('passwort')));
		}
		
	}
	
	/**
	 *
	 */
	function setup() {
		global $sysdb;
		if ( Request::Get('token', false) !== false ) {
			$t = Request::Get('token');
			$t = trim($t);
			if ( $t != '' ) {
				Account::set($sysdb->query("SELECT * FROM `accounts` WHERE `register_token` = " . $sysdb->quote($t))->fetch());
				if ( Account::exists()) {
					if ( Account::setup(Account::get('id')) ) {
						echo HTML::success("Erfolgreich!", "Alles bestens, dein Account ist fertig eingerichtet.<br><br>Du kannst dich <a href='/auth.login'>jetzt einloggen</a>");
					} else {
						echo HTML::danger("Fehlgeschlagen!", "Vermutlich ist dieser Account bereits eingerichtet.");
					}
					
				} else {
					echo HTML::danger("Fehlgeschlagen", "Dieser Account existiert nicht oder die Einrichtung wurde bereits erfolgreich durchgeführt.<br><br><br><a href='/auth.login' class='btn btn-primaryde'>Jetzt einloggen</a>");
				}
			}
		}
		
	}

?>