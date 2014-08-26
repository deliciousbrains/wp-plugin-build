<?php
if ( 'wp-migrate-db-pro' == $plugin_slug ) {
	$edition = 'pro';
}
else {
	$edition = 'lite';
}

$filter_file = "$tmp_dir/filter";

`cat "$build_dir/filter-all" "$build_dir/filter-$edition" > "$filter_file"`;
