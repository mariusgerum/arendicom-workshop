<?php
	
	/**
	 * Class Template
	 * Template handler class
	 */
	class Template {
		
		protected $html = "";
		
		/**
		 * Loads page template
		 *
		 * @param null $tpl
		 *
		 * @return string
		 */
		public function __construct($tpl = null) {
			$tpl = $tpl ?? DEFAULT_TEMPLATE;
			
			$file = DIR . '/application/templates/page/' . $tpl . '.php';
			
			ob_start();
			if (file_exists($file)) {
				require_once $file;
			}
			$this->html = ob_get_contents();
			ob_end_clean();
			
		}
		
		/**
		 * @param int $pagelevel
		 */
		public function renderPage($pagelevel = 0) {
			
			$content = $this->getPageContent($pagelevel);
			
			$this->html = Regex::replace('/<\!\-\- *?\{\{content\}\} *?\-\->/i', $content, $this->html);
			
			echo $this->html;
		}
		
		/**
		 * Returns current page content
		 *
		 * @param int $pagelevel
		 *
		 * @return string
		 */
		protected function getPageContent($pagelevel = 0) {
			$file = DIR . '/application/content/' . Request::getPage($pagelevel) . '.php';
			if (file_exists($file)) {
				
				$html = "";
				ob_start();
				if (file_exists($file)) {
					require_once $file;
				}
				$html = ob_get_contents();
				ob_end_clean();
				
				return $html;
			}
			return "";
		}
		
	}

?>