<?php

$directory = dirname(__FILE__) . '/docs';

$filenames = array();
$iterator = new DirectoryIterator($directory);

$uri = $_SERVER['REQUEST_URI'];
$body = '';

/**
 * Config yousef' right here:
 */
$sitename = "Docs";
$copyright = "&copy; Paul DeLeeuw, " . date('Y');

if ($uri == '/') {
	$title = $sitename;
	$body .= "<h2>Index</h2>";
	$body .= '<ul>';
	foreach ($iterator as $fileinfo) {
		if ($fileinfo->isFile() && preg_match('/\.md$/', $fileinfo->getFilename())) {
			$body .= '<li><a href="/view/' . $fileinfo->getFilename() . '">' . $fileinfo->getFilename() . '</a></li>';
		}
	}
	$body .= '</ul>';
} else {
	$uriComponents = explode('/', $uri);
	
	$action = $uriComponents[1];
	$file = $uriComponents[2];
	
	$filename = dirname(__FILE__) . '/docs/' . $file;
	
	if (file_exists($filename)) {
		include_once('lib/markdown.php');
		$contents = file_get_contents($filename);
		$body = Markdown($contents);
		$title = $sitename . ": Viewing $file";
	}
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			<div class="container"><a class="brand" href="/"><?=$sitename?></a></div>
			</div>
		</div>
		<div class="container">
			<?=$body?>
			<hr>
			<footer>
				<p><?=$copyright?></p>
			</footer>
		</div>
	</body>
</html>