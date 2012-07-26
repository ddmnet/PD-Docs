<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="/assets/css/bootstrap.css" />
		<style type="text/css" media="screen">
			
			body {
				padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
    
		</style>
		<link rel="stylesheet" href="/assets/css/bootstrap-responsive.css" />
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/"><?=$sitename?></a>
					<div class="nav-collapse">
						<ul class="nav">
							<?
							foreach ($nav as $navitem):
								$class = ($activelink == $navitem['name']) ? ' class="active"' : '';
								echo '<li', $class, '><a href="', $navitem['link'], '">', $navitem['name'], '</a></li>';
							endforeach;
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<?=$body?>
			<hr>
			<footer>
				<p><?=$copyright?></p>
				<?=$qr?>
			</footer>
		</div>
	</body>
</html>