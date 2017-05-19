<?php
	
	/**
	 * Class DT
	 */
	class DT {
		
		/**
		 * @var array
		 */
		private static $DaysOfWeek = [
			
			# German
			'de' => [
				'Montag',
				'Dienstag',
				'Mittwoch',
				'Donnerstag',
				'Freitag',
				'Samstag',
				'Sonntag'
			],
			
			# English / UK / american
			'en' => [
				'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
				'Sunday'
			]
		];
		
		private static $BeforeDaysText = [
			'de' => [
				'today'            => 'heute, ',
				'yesterday'        => 'gestern, ',
				'before_yesterday' => 'vorgestern, ',
				'default'          => 'am '
			]
		];
		
		/**
		 * @param $ts
		 *
		 * @return mixed
		 */
		public static function getBeforeDaysText($ts) {
			if ( $ts > time() ) {
				return self::$BeforeDaysText[LocaleSettings::getLanguage()]['default'];
			}
			
			$tsd = Timestamp::fromDate($ts);
			
			switch (true) {
				case ( date('Ymd', $ts) == date('Ymd') ):
					return self::$BeforeDaysText[LocaleSettings::getLanguage()]['today'];
					break;
				case ( ( Timestamp::fromDate(time()) - $tsd ) == ( 60 * 60 * 24 ) ):
					return self::$BeforeDaysText[LocaleSettings::getLanguage()]['yesterday'];
					break;
				case ( ( Timestamp::fromDate(time()) - $tsd ) == ( 60 * 60 * 24 * 2 ) ):
					return self::$BeforeDaysText[LocaleSettings::getLanguage()]['before_yesterday'];
					break;
				case ( ( Timestamp::fromDate(time()) - $tsd ) <= ( 60 * 60 * 24 * 14 ) ):
					return self::$DaysOfWeek[LocaleSettings::getLanguage()][intval(date("N", $ts)) - 1] . ", den ";
					break;
				default:
					return self::$BeforeDaysText[LocaleSettings::getLanguage()]['default'];
					break;
			}
			
		}
		
		/**
		 * @param bool $timestamp
		 *
		 * @return mixed
		 */
		public static function getDayOfWeek($timestamp = false) {
			$ts = time();
			if ( $timestamp !== false ) {
				$ts = $timestamp;
			}
			
			return self::$DaysOfWeek[LocaleSettings::getLanguage()][intval(date("N", $ts)) - 1];
		}
		
		/**
		 * @param        $_ts1
		 * @param        $_ts2
		 * @param string $unit
		 *
		 * @return float|int|number
		 */
		public static function diff($_ts1, $_ts2, $unit = 's') {
			$diff = $_ts1 - $_ts2;
			$diff = abs($diff);
			
			switch ($unit) {
				case 's':
					return $diff;
					break;
				case 'w':
					return $diff / 60 / 60 / 24 / 7;
					break;
				case 'd':
					return $diff / 60 / 60 / 24;
					break;
				case 'H':
					return $diff / 60 / 60;
					break;
				case 'i':
					return $diff / 60;
					break;
				default:
					return $diff;
					break;
			}
			
			return $diff;
			
		}
		
	}
	
	
	/* ====================================================================== */
	/* ====================================================================== */
	/* ====================================================================== */
	/* ====================================================================== */
	
	
	/**
	 * Class Timestamp
	 */
	class Timestamp {
		
		/**
		 * @return int
		 */
		public static function now() {
			return time();
		}
		
		/**
		 * @return int
		 */
		public static function tomorrow() {
			return time() + ( 60 * 60 * 24 );
		}
		
		/**
		 * @return int
		 */
		public static function yesterday() {
			return time() - ( 60 * 60 * 24 );
		}
		
		/**
		 * @param $days
		 *
		 * @return int
		 */
		public static function beforeDays($days) {
			return time() - ( 60 * 60 * 24 * $days );
		}
		
		/**
		 * @param $days
		 *
		 * @return int
		 */
		public static function inDays($days) {
			return time() + ( 60 * 60 * 24 * $days );
		}
		
		/**
		 * @param $ts
		 *
		 * @return false|int
		 */
		public static function fromDate($ts) {
			return strtotime(date("Y-m-d", $ts));
		}
		
	}
	
	use Timestamp as TS;

?>