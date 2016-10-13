<?php
  
/**
 * Registers custom post types
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 */

/**
 * Registers custom post types
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 * @author     Joel Bergroth <joel.bergroth@gmail.com>
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class Exhibition_Custom_Post_Type {
  
	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;
	
	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Now_Hiring 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	
  /**
	 * Registers exhibition custom post type
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		void
	 */
	public function exhibition_post_type() {
  
  	$labels = array(
  		'name'                  => _x( 'Exhibitions', 'Post Type General Name', 'exhibition-post-type' ),
  		'singular_name'         => _x( 'Exhibition', 'Post Type Singular Name', 'exhibition-post-type' ),
  		'menu_name'             => __( 'Exhibitions', 'exhibition-post-type' ),
  		'name_admin_bar'        => __( 'Exhibition', 'exhibition-post-type' ),
  		'archives'              => __( 'Exhibition Archives', 'exhibition-post-type' ),
  		'parent_item_colon'     => __( 'Parent Exhibition:', 'exhibition-post-type' ),
  		'all_items'             => __( 'All Exhibitions', 'exhibition-post-type' ),
  		'add_new_item'          => __( 'Add New Exhibition', 'exhibition-post-type' ),
  		'add_new'               => __( 'Add New', 'exhibition-post-type' ),
  		'new_item'              => __( 'New Exhibition', 'exhibition-post-type' ),
  		'edit_item'             => __( 'Edit Exhibition', 'exhibition-post-type' ),
  		'update_item'           => __( 'Update Exhibition', 'exhibition-post-type' ),
  		'view_item'             => __( 'View Exhibition', 'exhibition-post-type' ),
  		'search_items'          => __( 'Search Exhibition', 'exhibition-post-type' ),
  		'not_found'             => __( 'Not found', 'exhibition-post-type' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'exhibition-post-type' ),
  		'featured_image'        => __( 'Exhibition Image', 'exhibition-post-type' ),
  		'set_featured_image'    => __( 'Set exhibition image', 'exhibition-post-type' ),
  		'remove_featured_image' => __( 'Remove exhibition image', 'exhibition-post-type' ),
  		'use_featured_image'    => __( 'Use as exhibition image', 'exhibition-post-type' ),
  		'insert_into_item'      => __( 'Insert into exhibition', 'exhibition-post-type' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this exhibition', 'exhibition-post-type' ),
  		'items_list'            => __( 'Exhibition list', 'exhibition-post-type' ),
  		'items_list_navigation' => __( 'Exhibitions list navigation', 'exhibition-post-type' ),
  		'filter_items_list'     => __( 'Filter exhibitions list', 'exhibition-post-type' ),
  	);
  	$args = array(
  		'label'                 => __( 'Exhibition', 'exhibition-post-type' ),
  		'description'           => __( 'Exhibition description', 'exhibition-post-type' ),
  		'labels'                => $labels,
  		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
  		'taxonomies'            => array( 'post_tag', 'artist' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 5,
  		'menu_icon'             => 'dashicons-layout',
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => true,
  		'can_export'            => true,
  		'has_archive'           => true,		
  		'exclude_from_search'   => false,
  		'publicly_queryable'    => true,
  		'capability_type'       => 'page',
  		'rewrite'               => array( 'slug' => 'utstallningar' ),
  	);
  	register_post_type( 'exhibition', $args );
  
  }
	
} // class