<div class="container-fluid">

	<div class="row">
		<div class="col-md-12">
			<h1>The following topics are covered:</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php
				
				$path = './application/logic/topics/';
				if (file_exists($path)) {
					$Files = [];
					$handle = opendir($path);
					while (($file = readdir($handle)) !== false) {
						if (Regex::match('/^\.\.?$/i', $file)) {
							continue;
						}
						if (is_dir($path . $file)) {
							$Files[] = $file;
						}
					}
					
					asort($Files);
					
					$i = 1;
					echo "<div class='row'>";
					foreach ($Files as $file) {
						$name = $file;
						$name = preg_replace('/^[0-9]+?\-/i', '', $name);
						$name = str_replace('-', ' ', $name);
						$name = ucfirst($name);
						echo "<div class='col-md-4'>";
						echo "<h4>" . $i . ". " . $name . "</h4>";
						echo "</div>";
						$i++;
					}
					echo "</div>";
					
				}
			
			?>
		</div>
	</div>

</div>