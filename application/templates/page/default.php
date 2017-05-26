<?php
	$container_class = isset($_SESSION['fw']) ? 'container-fluid' : 'container';
?>
<!DOCTYPE html>
<html>
	<head>
		
		<!-- Meta stuff -->
		<meta charset="utf-8">
		
		<title>PHP Workshop</title>
		
		<!-- JS -->
		<script src="https://use.fontawesome.com/fdfc850ff9.js"></script>
		
		<!-- CSS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="/application/assets/css/default.css">
	
	</head>
	
	<body>
		
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="<?php echo $container_class; ?>">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Home</a>
					<a class="navbar-brand" href="/topics">Topics</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
				
				</div>
			</div>
		</nav>
		
		<div class="jumbotron">
			<div class="<?php echo $container_class; ?>">
				<h1>PHP Workshop!</h1>
				<p>
					These topics are all about the awesome features PHP provides with the new version 7 and 7.1
					as well as some good practice coding discussions. PHP <strong>version <?php echo phpversion(); ?></strong> is used for all examples.
				</p>
			</div>
		</div>
		
		
		<div class="<?php echo $container_class; ?>">
			<!-- {{CONTENT}} -->
			
			<hr>
			
			<footer>
				<p>
					<small>
						<i class="fa fa-info-circle"></i>
						PHP version <?php echo phpversion(); ?>
					</small>
				</p>
				<p>
					&copy; <?php echo date('Y'); ?> Marius Gerum | Arendicom GmbH
					&bull;
					<a href="https://github.com/mariusgerum/arendicom-workshop" title="Check the code on GitHub" target="_blank">
						Review this code on GitHub
					</a>
					&bull;
					<a href="javascript:;" class="ajax" data-action="info.setfw" data-rc=".abc">toggle full-width</a>
				</p>
			</footer>
		</div>
		
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="/application/assets/js/ajax.js"></script>
	
	</body>
</html>