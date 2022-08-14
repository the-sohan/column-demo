<?php
/**
 * Plugin Name:       Column Demo test
 * Plugin URI:        https://example.com/plugins/
 * Description:       This is practise plugin.
 * Version:           1.0
 * Author:            Sohan
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       column-demo
 * Domain Path:       /languages
 */

function coldemo_boostrap(){
    load_plugin_textdomain( 'column-demo', false, dirname(__FILE__) . "/languages" );
}
add_action( 'plugins_loaded', 'coldemo_boostrap' );

function coldemo_post_columns( $columns ) {
	unset( $columns['tags'] );
	unset( $columns['comments'] );
	// unset( $columns['author'] );
	// $columns['author'] = "Author";
	// unset( $columns['date'] );
	// $columns['author'] = "Date";
	$columns['id'] = __( 'Post ID', 'column-demo' );
	$columns['thumbnail'] = __( 'Thumbnail', 'column-demo' );
	$columns['wordcount'] = __( 'Count', 'column-demo' );
	return $columns;
}
add_filter('manage_posts_columns', 'coldemo_post_columns');
add_filter('manage_pages_columns', 'coldemo_post_columns');

function coldemo_post_column_data( $column, $post_id ) {
	if ( 'id' == $column ) {
		echo $post_id;
	} elseif ( 'thumbnail' == $column ) {
		$thumbnail = get_the_post_thumbnail( $post_id, array(100, 100) );
		echo $thumbnail;
	} elseif ( 'wordcount' == $column ) {
		$_post = get_post($post_id);
		$content = $_post->post_content;
		$wordn = str_word_count(strip_tags($content));
		echo $wordn;
	}
}

add_action( 'manage_posts_custom_column', 'coldemo_post_column_data', 10, 2 );
add_action( 'manage_pages_custom_column', 'coldemo_post_column_data', 10, 2 );

function coldemo_sortable_column($columns){
	$columns['wordcount'] = 'wordn';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'coldemo_sortable_column' );
 
function coldemo_set_word_count(){
	$_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'post'
	));
}
add_action( 'init', 'coldemo_set_word_count' );

// test  test test


