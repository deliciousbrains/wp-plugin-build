<?php
$version_checks = array(
	"$plugin_slug.php" => array(
		'@Version:\s+(.*)\n@' => 'header',
		"@\\\$GLOBALS\\['wpmdb_meta'\\]\\['" . $plugin_slug . "'\\]\\['version'\\] = '(.*?)';@" => 'global variable'
	)
);
