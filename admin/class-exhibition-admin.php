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
      'title'         => __( 'Exhibition information', 'exhibition' ),
      'object_types'  => array( 'exhibition', ),
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Start', 'exhibition' ),
      'id'   => 'date_start',
      'type' => 'text_date',
      // 'timezone_meta_key' => 'wiki_test_timezone',
      'date_format' => 'Y-m-d',
      'column' => array(
        'position' => 2,
        'name'     => __( 'Start', 'exhibition' ),
      ),
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'End', 'exhibition' ),
      'id'   => 'date_end',
      'type' => 'text_date',
      'date_format' => 'Y-m-d',
      'column' => array(
        'position' => 3,
        'name'     => __( 'End', 'exhibition' ),
      ),
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Until further notice', 'exhibition' ),
      'desc' => __( "If the exhibition doesn't have a set end date.", 'exhibition' ),
      'id'   => 'date_no_end',
      'type' => 'checkbox',
    ) );
  
  
    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
      'id'            => 'exhibition_dm_metabox',
      'title'         => __( 'DigitaltMuseum', 'exhibition' ),
      'object_types'  => array( 'exhibition', ),
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Synchronize', 'exhibition' ),
      'desc' => 'Synchronize this post with DigitaltMuseum. Note that local data will be overwritten.',
      'id'   => 'synchronize',
      'type' => 'checkbox',
      'column' => array(
        'position' => 4,
        'name'     => __( 'Synchronize', 'exhibition' ),
      ),
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Warning', 'exhibition'),
      'desc' => __( "Editing these fields may result in connection problems with DigitaltMuseum.", 'exhibition' ),
      'type' => 'title',
      'id'   => 'dm_title'
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'Museum inventory no.', 'exhibition' ),
      'desc' => __( "Museum or collection's own identifier / inventory no., e.g. HM27346", 'exhibition' ),
      'id'   => 'id_museum',
      'type' => 'text',
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'DiMu ID', 'exhibition' ),
      'desc' => __( 'DiMu-specific unique id for object, e.g. 021106469355', 'exhibition' ),
      'id'   => 'artifact_uniqueid',
      'type' => 'text',
    ) );
    
    $cmb->add_field( array(
      'name' => __( 'UUID', 'exhibition' ),
      'desc' => __( 'UUID e.g. CC52D261-405C-47C6-88EF-4FD7D4EF725C', 'exhibition' ),
      'id'   => 'id_uuid',
      'type' => 'text',
    ) );
  
  }
  
  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since 1.0.0
   */
  public function add_exhibition_admin_menu() {
  	add_options_page( __( 'Exhibition settings', 'exhibition' ), __( 'Exhibitions', 'exhibition' ), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
  }
  
  /**
   * Register exhibition settings.
   *
   * @since 1.0.0
   */
  public function register_settings() {
  	register_setting( 'exhibition-settings-group', 'dm_api_key' );
  	register_setting( 'exhibition-settings-group', 'dm_owner' );
  	register_setting( 'exhibition-settings-group', 'slug_artists' );
  	register_setting( 'exhibition-settings-group', 'slug_exhibitions' );
  }
  
  /**
   * Render the settings page.
   *
   * @since 1.0.0
   */
  public function display_plugin_setup_page() {
  	include_once( 'partials/exhibition-admin-display.php' );
  }
  
  /**
   * Display messages at the top of admin area
   *
   * @since 1.0.0
   */
  public function admin_notice() {
    
    $screen = get_current_screen();
    
    if( $screen->id == 'exhibition' ) {
      
      global $post;
      $post_metadata = get_post_meta( $post->ID );
      
      if( isset( $post_metadata["synchronize"] ) ) {

        ?>
        <div class="notice notice-warning">
            <p><?php _e( 'Warning! Edits to this exhibition will be overwritten since this post is marked for synchronization with DigitaltMuseum.', 'exhibition' ); ?> </p>
        </div>
        <?php

      }
    }
  }

}