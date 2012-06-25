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
$template = 'main';

/**
 * Config over.
 */

function isMarkdownFile($fileinfo) {
	return ($fileinfo->isFile() && preg_match('/\.md$/', $fileinfo->getFilename()));
}

$activelink = false;

// Create the navigation
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
// Render the root page
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
// Otherwise render the selected page or document.
	$uriComponents = explode('/', $uri);
	
	$action = urldecode($uriComponents[1]);
	
	$filename = $basedir . '/pages/' . $action . '.md';
	$qr = '';
	
	if (!file_exists($filename)) {
		$file = (!empty($uriComponents[2])) ? urldecode($uriComponents[2]) : false;
		if ($file) {
			$filename = $basedir . '/docs/' . $file;
			$title = $sitename . ": Viewing $file";
			$qr = '<img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=http://' . $_SERVER['SERVER_NAME'] . '/view/' . urlencode($uriComponents[2]) . '&choe=UTF-8&chld=L" />';
		}
	} else {
		$activelink = ucfirst($action);
		$title = $sitename . ": " . $activelink;
	}
	
	if (file_exists($filename)) {
		$contents = file_get_contents($filename);
		$body .= Markdown($contents);
	} else {
		header('HTTP/1.0 404 Not Found');
		$title = $sitename . ": Not Found";
		$body .= '<h1>404\'d!</h1>';
	}
	
}

include "assets/templates/{$template}.php";
