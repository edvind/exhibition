<?php
  
/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 */

/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @package    Exhibition
 * @subpackage Exhibition/includes
 * @author     Joel Bergroth <joel.bergroth@gmail.com>
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class Exhibition_Shared {
  
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
	 * Import exhibitions from digitaltmuseum.se
	 *
	 * @since 		1.0.0
	 */
	public function exhibition_import_from_dm() {
    
    $dm_api_key = get_option( 'dm_api_key' );
    $dm_owner = get_option( 'dm_owner' );
    
  	$url = 'http://api.dimu.org/api/solr/select?q=*&fq=identifier.owner:'.$dm_owner.'&fq=artifact.type:Exhibition*&wt=json&api.key='.$dm_api_key;
  	
  	$args = stream_context_create(array('http'=>
  	    array(
  	        'timeout' => 2500,
  	    )
  	));
  	$json_feed = file_get_contents( $url, false, $args );
  	$json_feed = json_decode( $json_feed );
  	
  	// Import each exhibition as a post
  	foreach ($json_feed->response->docs as $exhibition):
  	
  	    $this->exhibition_insert_post( $exhibition->{'artifact.uuid'} );
  	
  	endforeach;
  }
  
  /**
	 * Import found exhibition to the exhibition custom post type.
	 *
	 * @since 		1.0.0
	 * @var       string    $uuid    Unique ID of DigitaltMuseum post eg. CC52D261-405C-47C6-88EF-4FD7D4EF725C
	 */
	public function exhibition_insert_post( $uuid ) {
    
    $url = 'http://api.dimu.org/artifact/uuid/'.$uuid;
    
  	$args = stream_context_create(array('http'=>
      array(
          'timeout' => 2500,
      )
  	));
  	
  	$json_feed = file_get_contents( $url, false, $args );
  	$json_feed = json_decode( $json_feed );
  	
  	foreach ( $json_feed->exhibition->titles as $title ) :
  	
  	  if ( $title->status == 'original' ) :
  	    $exhibition_title = $title->title;
  	  endif;
  	  
  	endforeach;
  	
  	$exhibition_uuid = $uuid;
  	$exhibition_date_start = $this->dm_date_to_wp( $json_feed->exhibition->timespan->fromDate );
  	$exhibition_date_end = $this->dm_date_to_wp( $json_feed->exhibition->timespan->toDate );
  	$exhibition_unique_id = $json_feed->unique_id;
    $exhibition_id = $json_feed->identifier->id;
  	$exhibition_description = nl2br ($json_feed->description);
  	
  	echo $exhibition_title;
    echo '<br>';
  	echo $exhibition_uuid;
  	echo '<br>';
  	echo $exhibition_unique_id;
  	echo '<br>';
  	echo $exhibition_id;
  	echo '<br>';
  	echo $exhibition_date_start;
  	echo '<br>';
  	echo $exhibition_date_end;
  	echo '<br>';
  	echo $exhibition_description;
  	echo '<br><br>';
  	
  }
  
  /**
	 * Convert DM start/end dates to custom field date
	 *
	 * @since 		1.0.0
	 * @var       string    $date    DM formatted date eg. 00000000-0000-000
	 * @return    string             Date in format yyyy-mm-dd
	 */
	public function dm_date_to_wp( $date ) {
    $date_str = substr($date, 0, 8);
    $date_str = substr_replace($date_str, '-', 6, 0);
    $date_str = substr_replace($date_str, '-', 4, 0);
    return $date_str;
  }
	
} // class