<?php
/**
 * @package vip-bundle-decoupled
 */

namespace WPCOMVIP\Decoupled\URLs;

/**
 * Setting `home` and `siteurl` options to different values helps us set
 * permalinks correctly, but it causes some problems for resouces that we still
 * want to serve from WordPress. Filter those resources to use siteurl.
 *
 * @param  string $resource_url URL of a WordPress resource.
 * @return string
 */
function update_resource_url( $resource_url ) {
	$home_path     = wp_make_link_relative( home_url() );
	$resource_path = wp_make_link_relative( $resource_url );

	if ( ! empty( $home_path ) ) {
		$resource_path = preg_replace( sprintf( '#^%s/*#', $home_path ), '/', $resource_path );
	}

	return site_url( $resource_path );
}

function add_filters() {
	$filters = [
		'author_feed_link',
		'category_feed_link',
		'feed_link',
		'post_comments_feed_link',
		'rest_url',
		'tag_feed_link',
		'taxonomy_feed_link',
		'wp_get_attachment_url',
	];

	foreach ( $filters as $filter ) {
		add_filter( $filter, __NAMESPACE__ . '\\update_resource_url', 10, 1 );
	}
}
add_filters();
