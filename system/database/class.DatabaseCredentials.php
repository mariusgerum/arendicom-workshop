<?php
	
	namespace DataAccess;
	
	class DatabaseCredentials {
		
		/**
		 * Database credentials and settings
		 */
		private $DatabaseCredentials = [
			
			# test database
			'default' => [
				'host'     => 'localhost',
				'username' => 'test',
				'password' => 'YUmV0l7R46c1vbiZ6BXyZ8So2pdFRbui4JYxLHJOVFqn7GbTGrKGgyAfUvev0Il4',
				'database' => 'test',
				'options'  => [
					\PDO::ATTR_CASE               => \PDO::CASE_NATURAL,
					\PDO::ATTR_ERRMODE            => (DEBUG ? \PDO::ERRMODE_WARNING : \PDO::ERRMODE_SILENT),
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				],
			],
		
		];
		
		private $Credentials = [];
		
		/**
		 * Credentials constructor.
		 *
		 * @param $set
		 */
		public function __construct($set) {
			$this->Credentials = $this->DatabaseCredentials[$set] ?? [];
			
			return $this->Credentials ? true : false;
		}
		
		/**
		 * @return string
		 */
		public function exists() {
			return array_key_exists('host', $this->Credentials);
		}
		
		/**
		 * @param        $key
		 * @param string $alt
		 *
		 * @return string
		 */
		private function get($key, $alt = '') {
			return $this->Credentials[$key] ?: $alt;
		}
		
		/**
		 * @return string
		 */
		public function getHost() {
			return $this->get('host');
		}
		
		/**
		 * @return string
		 */
		public function getUsername() {
			return $this->get('username');
		}
		
		/**
		 * @return string
		 */
		public function getPassword() {
			return $this->get('password');
		}
		
		/**
		 * @return string
		 */
		public function getDatabase() {
			return $this->get('database');
		}
		
		/**
		 * @return string
		 */
		public function getOptions() {
			return $this->get('options', []);
		}
		
	}
	
	?>