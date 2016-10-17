<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Exhibition
 * @subpackage Exhibition/includes
 * @author     Joel Bergroth <joel.bergroth@gmail.com>
 */
class Exhibition_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
  	
  	$timestamp = wp_next_scheduled( 'exhibition_cron_hook' );
    wp_unschedule_event( $timestamp, 'exhibition_cron_hook' );

	}

}
