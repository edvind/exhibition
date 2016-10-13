<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Exhibition
 * @subpackage Exhibition/admin
 * @author     Joel Bergroth <joel.bergroth@gmail.com>
 */
class Exhibition_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Exhibition_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Exhibition_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/exhibition-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Exhibition_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Exhibition_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/exhibition-admin.js', array( 'jquery' ), $this->version, false );

	}
	
  /**
	 * Register metaboxes used in the exhibition post type
	 *
	 * @since    1.0.0
	 */
	public function exhibition_metaboxes() {
  
    // Start with an underscore to hide fields from custom fields list
    $prefix = '_exhibition_';
  
    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
      'id'            => 'exhibition_info_metabox',
      'title'         => __( 'Exhibition information', 'exhibition-post-type' ),
      'object_types'  => array( 'exhibition', ),
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Start', 'exhibition-post-type' ),
      'id'   => 'date_start',
      'type' => 'text_date',
      // 'timezone_meta_key' => 'wiki_test_timezone',
      'date_format' => 'Y-m-d',
      'column' => array(
        'position' => 2,
        'name'     => __( 'Start', 'exhibition-post-type' ),
      ),
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'End', 'exhibition-post-type' ),
      'id'   => 'date_end',
      'type' => 'text_date',
      'date_format' => 'Y-m-d',
      'column' => array(
        'position' => 3,
        'name'     => __( 'End', 'exhibition-post-type' ),
      ),
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Until further notice', 'exhibition-post-type' ),
      'desc' => __( "If the exhibition doesn't have a set end date.", 'exhibition-post-type' ),
      'id'   => 'date_no_end',
      'type' => 'checkbox',
    ) );
  
  }

}
