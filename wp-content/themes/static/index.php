<?php
/**
 * Static theme entry point.
 *
 * Serves the existing static index.html file while keeping relative asset
 * paths anchored to this theme directory.
 */

$static_index = __DIR__ . '/index.html';

if (! file_exists($static_index)) {
	status_header(404);
	echo 'Static index.html not found.';
	return;
}

$html = file_get_contents($static_index);

if (false === $html) {
	status_header(500);
	echo 'Unable to load static index.html.';
	return;
}

$base = '<base href="' . esc_url(get_template_directory_uri() . '/') . '">' . PHP_EOL;
$html = preg_replace('/<head(\s[^>]*)?>/i', '$0' . PHP_EOL . $base, $html, 1);

echo $html;
