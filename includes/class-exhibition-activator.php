<?php

/**
 * Fired during plugin activation
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Exhibition
 * @subpackage Exhibition/includes
 * @author     Joel Bergroth <joel.bergroth@gmail.com>
 */
class Exhibition_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    
    // Default slug for artists
    if ( get_option( 'slug_artists' ) == false ) {
      update_option( 'slug_artists', 'artists' );
    }
    
    // Default slug for exhibitions
    if ( get_option( 'slug_exhibitions' ) == false ) {
      update_option( 'slug_exhibitions', 'exhibitions' );
    }
    
    //wp_schedule_event( mktime(7), 'daily', 'exhibition_cron_hook' );
    
	}

}
