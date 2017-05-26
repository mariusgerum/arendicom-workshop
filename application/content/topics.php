<div class="container-fluid">

	<div class="row">
		<div class="col-md-3">
			<?php
				
				$path = './application/logic/topics/';
				
				if (file_exists($path)) {
					
					$Folders = \Filesystem::getFolders($path);
					
					if (!empty($Folders) && isset($Folders[0])) {
						asort($Folders);
						
						foreach ($Folders as $Folder) {
							$name = $Folder['filename'];
							$name = preg_replace('/^[0-9]+?\-/i', '', $name);
							$name = str_replace('-', ' ', $name);
							$name = ucfirst($name);
							echo "<div class='single-topic'>";
							echo "<a href='javascript:;' class='ajax' data-action='topics.load' data-url='topic=" . $Folder['filename'] . "' data-rc='.rc-" . $Folder['filename'] . "' onClick=\"jQuery('.tmp-topic-examples').html('');\">" . $name . "</a>";
							echo "<div class='topic-examples rc-" . $Folder['filename'] . "'>";
							echo "</div>";
							echo "</div>";
						}
						
						echo "<div class='single-topic'>";
						echo "<a href='javascript:;' class='ajax' data-action='info.playground' data-url='topic=info' data-rc='.rc-topic-content'><i class='fa fa-code'></i> Playground</a>";
						echo "</div>";
						
						echo "<div class='single-topic'>";
						echo "<a href='javascript:;' class='ajax' data-action='info.menu' data-url='topic=info' data-rc='.rc-info'><i class='fa fa-info-circle'></i> Info</a>";
						echo "<div class='topic-examples rc-info'>";
						echo "</div>";
						echo "</div>";
						
					}
				}
			
			?>
		</div>

		<div class="col-md-9 rc-topic-content">

		</div>

	</div>
</div>