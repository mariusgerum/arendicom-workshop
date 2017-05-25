<?php
	
	function load() {
		global $db;
		$topic = Request::Get('topic');
		if ($topic != '') {
			$path = DIR . '/application/logic/topics/' . Request::Get('topic') . '/';
			if (file_exists($path) && is_dir($path)) {
				
				$Files = \Filesystem::getFiles($path);
				
				if (!empty($Files) && isset($Files[0])) {
					
					sort($Files);
					$i = 1;
					foreach ($Files as $File) {
						$name = str_replace('-', ' ', $File['filename']);
						$name = Regex::replace('/\.php$|^[0-9]+? /i', '', $name);
						$name = ucfirst($name);
						// echo "<a href='javascript:;' class='topic-example ajax' data-action='topics." . Request::Get('topic') . "." . $file . "' data-rc='.rc-topic-content'>" . $i . ". " . $name . "</a>";
						
						echo "<a href='javascript:;' class='topic-example ajax' data-action='topics.show' data-url='topic=" . Request::Get('topic') . "&file=" . $File['filename'] . "' data-rc='.rc-topic-content' onClick=\"jQuery('.topic-example').removeClass('active'); jQuery(this).addClass('active');\">" . $i . ". " . $name . "</a>";
						$i++;
					}
				}
			}
		}
	}
	
	function show() {
		global $db;
		$topic = Request::Get('topic');
		$file = Request::Get('file');
		if ($topic != '' && $file != '') {
			$path = DIR . '/application/logic/topics/' . Request::Get('topic') . '/' . $file;
			
			$name = Regex::replace('/\.php$/i', '', $file);
			$num = Regex::replace('/^([0-9]+)\-.*/i', '$1', $name);
			$name = Regex::replace('/^([0-9]+)\-/i', '', $name);
			$name = str_replace('-', ' ', $name);
			$name = Regex::replace('/^([0-9]+)? /i', '$1. ', $name);
			$name = ucfirst($name);
			
			\Filesystem::matchingFileExists(DIR . '/application/logic/topics/' . Request::Get('topic') . '/', '/^' . ($num + 1) . '\-/i');
			
			echo "<h3>" . $num . ". " . $name;
			echo "<span class='next-previous'>";
			# Previous
			$p = \Filesystem::matchingFileExists(DIR . '/application/logic/topics/' . Request::Get('topic') . '/', '/^' . ($num - 1) . '\-/i');
			if ($p) {
				echo "<a href='javascript:;' class='ajax' data-action='topics.show'  data-url='topic=" . Request::Get('topic') . "&file=" . $p . "' data-rc='.rc-topic-content'><i class='fa fa-angle-left'></i></a>";
			} else {
				echo "<a href='javascript:;' class='no-pointer-events'><i class='fa fa-angle-left'></i></a>";
			}
			
			# Next
			$n = \Filesystem::matchingFileExists(DIR . '/application/logic/topics/' . Request::Get('topic') . '/', '/^' . ($num + 1) . '\-/i');
			if ($n) {
				echo "<a href='javascript:;' class='ajax' data-action='topics.show'  data-url='topic=" . Request::Get('topic') . "&file=" . $n . "' data-rc='.rc-topic-content'><i class='fa fa-angle-right'></i></a>";
			} else {
				echo "<a href='javascript:;' class='no-pointer-events'><i class='fa fa-angle-right'></i></a>";
			}
			echo "</span>";
			echo "</h3>";
			
			echo "<a href='javascript:;' onClick=\"jQuery('.active-topic').toggleClass('show-output'); jQuery('.topic-switch i.fa').toggleClass('fa-toggle-on'); jQuery('.topic-switch i.fa').toggleClass('fa-toggle-off');\" class='topic-switch'><i class='fa fa-toggle-on fa-2x'></i></a> <sup>Switch between code <i class='fa fa-arrows-h'></i> output</sup>";
			
			echo "<hr>";
			
			if (file_exists($path)) {
				echo "<div class='active-topic'>";
				
				# Code
				echo "<div class='topic-section topic-code'>";
				$code = highlight_file($path, true);
				echo $code;
				echo "</div>";
				
				# Output
				echo "<div class='topic-section topic-output'>";
				require_once $path;
				echo "</div>";
				
				echo "</div>";
			}
		}
	}

?>