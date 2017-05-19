<?php
	
	require_once DIR . '/system/database/data.php';
	
	class Database extends PDO {
		
		/**
		 * Database constructor.
		 *
		 * @param      $use
		 * @param bool $setnull
		 */
		public function __construct($use, $setnull = false) {
			global $DatabaseCredentials;
			
			if ( !isset( $DatabaseCredentials[$use] ) ) {
				ErrorHandling::error("Database configuration error.");
			}
			if(strpos($DatabaseCredentials[$use]['database'], '{{DATABASE}}') !== false){
				$DatabaseCredentials[$use]['database'] = str_replace('{{DATABASE}}', self::getDatabaseName(), $DatabaseCredentials[$use]['database']);
			}
			
			try {
				parent::__construct("mysql:host=" . $DatabaseCredentials[$use]['host'] . ";dbname=" . $DatabaseCredentials[$use]['database'] . ";charset=utf8", $DatabaseCredentials[$use]['username'], $DatabaseCredentials[$use]['password'], $DatabaseCredentials[$use]['options']);
			} catch (PDOException $e) {
				if(DEBUG){
					echo pre($e);
				}
				ErrorHandling::error("Database connection could not be established.");
			}
		}
		
		/**
		 * @return string
		 */
		public static function getDatabaseName(){
			return DB_PREFIX . ( DB_INIT_ID + Account::id() );
		}
		
		/**
		 * @param $id
		 *
		 * @return string
		 */
		public static function getTableName($id){
			return DB_PREFIX . ( DB_INIT_ID + $id );
		}
		
		/**
		 * Setup a customer database
		 *
		 * @param int   $id
		 * @param bool  $force
		 *
		 * @return bool
		 */
		public static function Setup($id, $force = false) {
			global $sysdb;
			
			Account::set($sysdb->query("SELECT * FROM `accounts` WHERE `id` = " . $sysdb->quote($id))->fetch());
			if ( Account::exists() ) {
				$Database = self::getTableName($id);
				
				if(!$force){
					# Checks if this database already exists
					$Existing = $sysdb->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $Database . "'")->fetch();
					if ( isset( $Existing['SCHEMA_NAME'] ) ) {
						if ( $Existing['SCHEMA_NAME'] == $Database ) {
							# Account already exists
							return false;
						}
					}
				}
				
				
				# Load setup scheme
				$Scheme = file_get_contents('./system/database/schemes/setup.sql');
				
				# Set database placeholders
				$Scheme = str_replace('{{DATABASE}}', $Database, $Scheme);
				$Scheme = str_replace('{{FULL_NAME}}', Account::get('vorname') . " " . Account::get('name'), $Scheme);
				$Scheme = str_replace('{{EMAIL}}', Account::get('email'), $Scheme);
				$Scheme = str_replace('{{PASSWORD}}', Account::get('passwort'), $Scheme);
				$Scheme = str_replace('{{COMPANY}}', Account::get('firma'), $Scheme);
				
				# Make statements array
				$Statements = explode(PHP_EOL, $Scheme);
				
				$sysdb->beginTransaction();
				$Results = [];
				foreach ( $Statements as $stmt ) {
					if ( Regex::match('/^$|^\-\- /i', trim($stmt)) ) {
						continue;
					}
					
					# Execute query
					$Results[] = $sysdb->exec($stmt);
					
				}
				
				# Remove token and activate account
				$sysdb->exec("UPDATE `fastbilling`.`accounts` SET `register_submit_date` = '" . date("Y-m-d H:i:s") . "', `register_token` = '', `confirmed` = '1' WHERE `id` = " . $sysdb->quote(Account::get('id')));
				
				if ( not_false($Results) ) {
					
					# Commit sql commands
					$sysdb->commit();
					
					return true;
				} else {
					
					# Roll sql commands back
					$sysdb->rollBack();
					
					return false;
				}
				
			}
			
		}
		
		/**
		 * Returns the last id of a record in specified table
		 *
		 * @param     $table
		 * @param int $alt
		 *
		 * @return int
		 */
		public static function getLastInsertId($table, $alt = 0){
			global $db;
			$lid = $db->query("SELECT `id` FROM `" . $table . "` ORDER BY `id` DESC LIMIT 1")->fetch();
			if($lid['id']){
				return $lid['id'];
			}
			return $alt;
		}
		
		/**
		 * @param        $table
		 * @param string $where
		 * @param string $fields
		 *
		 * @return mixed
		 */
		public static function getData($table, $where = "", $fields = "*"){
			global $db;
			if($where != ''){
				$where = trim($where);
				$where = " " . $where . " ";
			}
			
			$columns = "";
			if(is_string($fields)){
				if($fields == '*'){
					$columns = $fields;
				}else{
					$columns = "`" . $fields . "`";
				}
			}
			if(is_array($fields)){
				foreach($fields as $field){
					$columns .= "`" . $field . "`, ";
				}
				$columns = Regex::replace('/\, ?$/i', '', $columns);
			}
			$stmt = "SELECT " . $columns . " FROM `" . $table . "`" . $where;
			return $db->query($stmt)->fetchAll();
		}
		
		private static $AllTables = [
			'angebot',
			'auftraege',
			'einheiten',
			'einstellungen',
			'firma',
			'kunden',
			'mail_templates',
			'mwst',
			'rabatte',
			'rechnung',
			'report',
			'status',
			'sysmsg',
			'token',
			'ttyp',
		];
		
		/**
		 * @param $tables
		 *
		 * @return array
		 */
		public static function getDataFromTables($tables){
			global $db;
			
			if(is_string($tables) && $tables = '*'){
				$tables = self::$AllTables;
			}
			
			$AllData = [];
			
			if(is_array($tables)){
				foreach($tables as $table){
					$res = $db->query("SELECT * FROM `" . $table . "`")->fetchAll();
					$AllData[$table] = $res;
				}
			}
			
			return $AllData;
			
		}
		
		/**
		 * @return string
		 */
		public static function getHexDump(){
			$res = self::getDataFromTables('*');
			$str = serialize($res);
			$h = bin2hex($str);
			// $h = chunk_split($h, 256, '%');
			return $h;
		}
		
		/**
		 * @param        $table
		 * @param string $where
		 *
		 * @return array
		 */
		public static function getLast($table, $where = "WHERE 1"){
			global $db;
			if($where != ''){
				$where = trim($where);
				$where = " " . $where . " ";
			}
			return $db->query("SELECT * FROM `" . $table . "`" . $where . " LIMIT 1")->fetch();
		}
		
		/**
		 * @param        $table
		 * @param        $id
		 * @param string $fields
		 * @param string $uid
		 *
		 * @return mixed
		 */
		public static function getRecord($table, $id, $fields = '*', $uid = 'id'){
			global $db;
			$where = "";
			if(Auth::TokenRequired($table)){
				$where .= " AND `token` = " . $db->quote(Auth::getToken());
			}
			
			$columns = "";
			if(is_string($fields)){
				if($fields == '*'){
					$columns = $fields;
				}else{
					$columns = "`" . $fields . "`";
				}
			} 
			if(is_array($fields)){
				foreach($fields as $field){
					$columns .= "`" . $field . "`, ";
				}
				$columns = Regex::replace('/\, ?$/i', '', $columns);
			}
			
			return $db->query("SELECT " . $columns . " FROM `" . $table . "` WHERE `" . $uid . "` = " . $db->quote($id) . $where)->fetch();
		}
		
		/**
		 * @param        $table
		 * @param bool   $id
		 * @param string $field
		 *
		 * @return bool
		 */
		public static function hasEntries($table, $id = false, $field = ''){
			global $db;
			$where = "";
			if($id !== false && is_numeric($id)){
				$f = 'id';
				if($field != ''){
					$f = $field;
				}
				$where = " WHERE `" . $f . "` = " . $db->quote($id);
			}
			$res = $db->query("SELECT `id` FROM `" . $table . "` " . $where . " LIMIT 1")->fetch();
			if(isset($res['id'])){
				return true;
			}
			return false;
		}
		
		/**
		 * @param $table
		 */
		public static function dropTable($table){
			global $sysdb;
			$sysdb->exec("DROP DATABASE IF EXISTS " . $table);
		}
		
		/**
		 * @param $table
		 * @param $field
		 * @param $value
		 *
		 * @return bool
		 */
		public static function isDuplcateEntry($table, $field, $value){
			global $db;
			$res = $db->query("SELECT COUNT(" . $field . ") AS cnt FROM `" . $table . "` WHERE `" . $field . "` = " . $db->quote($value) . " LIMIT 1")->fetch();
			if($res !== false && isset($res['cnt'])){
				if($res['cnt'] > 0){
					return true;
				}
			}
			return false;
		}
		
		/**
		 * @param $table
		 * @param $field
		 * @param $value
		 * @param $this_id
		 *
		 * @return bool
		 */
		public static function DuplicateEntryExists($table, $field, $value, $this_id){
			global $db;
			$res = $db->query("SELECT COUNT(" . $field . ") AS cnt FROM `" . $table . "` WHERE `" . $field . "` = " . $db->quote($value) . " AND `id` != " . $db->quote($this_id) . " LIMIT 1")->fetch();
			if($res !== false && isset($res['cnt'])){
				if($res['cnt'] > 0){
					return true;
				}
			}
			return false;
		}
		
		/**
		 * @param $id
		 * @param $scheme
		 *
		 * @return bool
		 */
		public static function loadScheme($id, $scheme) {
			global $sysdb;
			
			Account::set($sysdb->query("SELECT * FROM `accounts` WHERE `id` = " . $sysdb->quote($id))->fetch());
			if ( Account::exists() ) {
				$Database = self::getTableName($id);
				
				# Load setup scheme
				if(!file_exists('./system/database/schemes/' . $scheme . '.sql')){
					return false;
				}
				$Scheme = file_get_contents('./system/database/schemes/' . $scheme . '.sql');
				
				# Set database placeholders
				$Scheme = str_replace('{{DATABASE}}', $Database, $Scheme);
				$Scheme = str_replace('{{FULL_NAME}}', Account::get('vorname') . " " . Account::get('name'), $Scheme);
				$Scheme = str_replace('{{EMAIL}}', Account::get('email'), $Scheme);
				$Scheme = str_replace('{{PASSWORD}}', Account::get('passwort'), $Scheme);
				$Scheme = str_replace('{{COMPANY}}', Account::get('firma'), $Scheme);
				
				# Make statements array
				$Statements = explode(PHP_EOL, $Scheme);
				
				$sysdb->beginTransaction();
				$Results = [];
				foreach ( $Statements as $stmt ) {
					if ( Regex::match('/^$|^\-\- /i', trim($stmt)) ) {
						continue;
					}
					
					# Execute query
					$Results[] = $sysdb->exec($stmt);
					
				}
				
				# Remove token and activate account
				# Added Results assignment 2017-02-17
				$Results[] = $sysdb->exec("UPDATE `fastbilling`.`accounts` SET `register_submit_date` = '" . date("Y-m-d H:i:s") . "', `register_token` = '', `confirmed` = '1' WHERE `id` = " . $sysdb->quote(Account::get('id')));
				
				if ( not_false($Results) ) {
					
					# Commit sql commands
					$sysdb->commit();
					
					return true;
				} else {
					
					# Roll sql commands back
					$sysdb->rollBack();
					
					return false;
				}
				
			}
			
		}
		
		/**
		 * @param $value
		 *
		 * @return string
		 */
		public static function escape($value){
			global $sysdb;
			return $sysdb->quote($value);
		}
		
		public static function execute($value){
			global $db;
			return $db->exec($value);
		}
		
		/**
		 * @param $table
		 * @param $id
		 *
		 * @return mixed
		 */
		public static function delete($table, $id){
			global $db;
			return $db->exec("DELETE FROM `" . $table . "` WHERE `id` = " . $db->quote($id));
		}
		
	}

?>