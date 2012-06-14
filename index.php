<?php
include_once('lib/markdown.php');

$basedir = dirname(__FILE__);

$uri = $_SERVER['REQUEST_URI'];
$body = '';

/**
 * Config yousef' right here:
 */
$sitename = "Docs";
$copyright = "&copy; Paul DeLeeuw, " . date('Y');

/**
 * Config over.
 */

function isMarkdownFile($fileinfo) {
	return ($fileinfo->isFile() && preg_match('/\.md$/', $fileinfo->getFilename()));
}

$activelink = false;

$pagesdir = $basedir . '/pages';
$nav = array();
if (file_exists($pagesdir) && is_dir($pagesdir)) {
	$iterator = new DirectoryIterator($pagesdir);
	foreach($iterator as $fileinfo) {
		$filename = $fileinfo->getFilename();
		if (isMarkdownFile($fileinfo) && $filename != 'index.md') {
			$name = explode('.', $filename);
			array_pop($name);
			$name = implode('.', $name);
			$nav[] = array(
				'name' => ucfirst($name),
				'link' => '/' . $name
			);
		}
	}
}

if ($uri == '/') {
	$title = $sitename;
	
	if (file_exists($pagesdir) && is_dir($pagesdir)) {
		$indexfile = $basedir . '/pages/index.md';
		if (file_exists($indexfile)) {
			$indexcontents = file_get_contents($indexfile);
			$body .= Markdown($indexcontents);
		}
	}

	$directory = $basedir . '/docs';
	
	
	$filenames = array();
	$iterator = new DirectoryIterator($directory);
	
	$body .= "<h2>Index</h2>";
	$body .= '<ul>';
	foreach ($iterator as $fileinfo) {
		if (isMarkdownFile($fileinfo)) {
			$body .= '<li><a href="/view/' . $fileinfo->getFilename() . '">' . $fileinfo->getFilename() . '</a></li>';
		}
	}
	$body .= '</ul>';
} else {
	$uriComponents = explode('/', $uri);
	
	$action = $uriComponents[1];
	
	$filename = $basedir . '/pages/' . $action . '.md';
	
	if (!file_exists($filename)) {
		$file = $uriComponents[2];
		$filename = $basedir . '/docs/' . $file;
		$title = $sitename . ": Viewing $file";
	} else {
		$activelink = ucfirst($action);
		$title = $sitename . ": " . $activelink;
	}
	
	if (file_exists($filename)) {
		$contents = file_get_contents($filename);
		$body .= Markdown($contents);
	} else {
		'<h1>404\'d!</h1>';
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
			</footer>
		</div>
	</body>
</html>