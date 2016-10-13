<?php
  
/**
 * Registers custom taxonomies
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 */

/**
 * Registers custom taxonomies
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 * @author     Joel Bergroth <joel.bergroth@gmail.com>
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class Exhibition_Taxonomy {
  
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
	 * Registers artist taxonomy
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		void
	 */
	public function artist_taxonomy() {
  	
  	if ( get_option('slug_artists') != false ) {
    	$slug_artists = get_option('slug_artists');
  	} else {
    	$slug_artists = 'artists';
  	}
  	
  	$labels = array(
  		'name'                       => _x( 'Artists', 'Taxonomy General Name', 'exhibition' ),
  		'singular_name'              => _x( 'Artist', 'Taxonomy Singular Name', 'exhibition' ),
  		'menu_name'                  => __( 'Artists', 'exhibition' ),
  		'all_items'                  => __( 'All Artists', 'exhibition' ),
  		'parent_item'                => __( 'Parent Artist', 'exhibition' ),
  		'parent_item_colon'          => __( 'Parent Artist:', 'exhibition' ),
  		'new_item_name'              => __( 'New Artist Name', 'exhibition' ),
  		'add_new_item'               => __( 'Add New Artist', 'exhibition' ),
  		'edit_item'                  => __( 'Edit Artist', 'exhibition' ),
  		'update_item'                => __( 'Update Artist', 'exhibition' ),
  		'view_item'                  => __( 'View Artist', 'exhibition' ),
  		'separate_items_with_commas' => __( 'Separate artists with commas', 'exhibition' ),
  		'add_or_remove_items'        => __( 'Add or remove artists', 'exhibition' ),
  		'choose_from_most_used'      => __( 'Choose from the most used artists', 'exhibition' ),
  		'popular_items'              => __( 'Popular Artists', 'exhibition' ),
  		'search_items'               => __( 'Search Artists', 'exhibition' ),
  		'not_found'                  => __( 'Not Found', 'exhibition' ),
  		'no_terms'                   => __( 'No Artists', 'exhibition' ),
  		'items_list'                 => __( 'Artists list', 'exhibition' ),
  		'items_list_navigation'      => __( 'Artists list navigation', 'exhibition' ),
  		'rewrite'                    => array( 'slug' => $slug_artists ), //TODO setting
  	);
  	$args = array(
  		'labels'                     => $labels,
  		'hierarchical'               => false,
  		'public'                     => true,
  		'show_ui'                    => true,
  		'show_admin_column'          => true,
  		'show_in_nav_menus'          => true,
  		'show_tagcloud'              => true,
  	);
  	register_taxonomy( 'artist', array( 'exhibition' ), $args );
  
  }
	
} // class