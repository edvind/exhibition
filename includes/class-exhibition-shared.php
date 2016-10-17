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
  	
    $local_uuids = $this->get_meta_values( '_exhibition_id_uuid' );
  	
  	// Search through all found exhibitions
  	foreach ( $json_feed->response->docs as $exhibition ):
  	    
      foreach ($local_uuids as $local_uuid):
      
        // See if UUID exists in exhibition database
        if ( $local_uuid->meta_value == $exhibition->{'artifact.uuid'} ):
  
  	      $post_metadata = get_post_meta( $local_uuid->post_id );
  	      
          // If post is marked for synchronization
          if ( isset( $post_metadata["_exhibition_synchronize"][0] ) ):
            
            if( $post_metadata["_exhibition_synchronize"][0] == 'on' ):
            
              $this->exhibition_update_post( $exhibition->{'artifact.uuid'}, $local_uuid->post_id, false );
              
            endif;
          
          endif;
          
          continue 2;
          
        endif;
      
      endforeach;
      
      $this->exhibition_insert_post( $exhibition->{'artifact.uuid'} );
  	
  	endforeach;
  }
  
  /**
	 * Insert exhibition uuid as exhibition custom post type.
	 *
	 * @since 		1.0.0
	 * @var       string    $uuid    Unique ID of DigitaltMuseum post eg. CC52D261-405C-47C6-88EF-4FD7D4EF725C
	 */
	public function exhibition_insert_post( $uuid ) {
    
    // Fetch exhibition information from 
    $exhibition = $this->fetch_dm_exhibition( $uuid );
    
    // Create post object
    $exhibition_post = array(
      'post_title'    => wp_strip_all_tags( $exhibition->title ),
      'post_content'  => '<i>' . $exhibition->description_ingress . '</i><br><br>' .$exhibition->description,
      'post_status'   => 'publish',
      'post_type'     => 'exhibition',
      'post_author'   => 19
    );
     
    // Insert the post into the database
    $exhibition_post_id = wp_insert_post( $exhibition_post );
    
    if ( $exhibition_post_id != false ) {
      
      add_post_meta( $exhibition_post_id, '_exhibition_date_start', $exhibition->date_start );
      add_post_meta( $exhibition_post_id, '_exhibition_date_end', $exhibition->date_end );
      add_post_meta( $exhibition_post_id, '_exhibition_id_museum', $exhibition->id );
      add_post_meta( $exhibition_post_id, '_exhibition_artifact_uniqueid', $exhibition->unique_id );
      add_post_meta( $exhibition_post_id, '_exhibition_id_uuid', $exhibition->uuid );
      
    }

  }
  
  /**
	 * Update exhibition post with information taken from DigitalMuseum.
	 *
	 * @since 		1.0.0
	 * @var       string    $uuid                  Unique ID of DigitaltMuseum post eg. CC52D261-405C-47C6-88EF-4FD7D4EF725C
	 * @var       string    $exhibition_post_id    Existing exhibition post ID
	 * @var       boolean   $synchronize           Whether or not to turn off synchronization
	 */
	public function exhibition_update_post( $uuid, $exhibition_post_id, $synchronize = true ) {
    
    // Fetch exhibition information from 
    $exhibition = $this->fetch_dm_exhibition( $uuid );
    
        // Create post object
    $exhibition_post = array(
      'ID'            => $exhibition_post_id,
      'post_title'    => wp_strip_all_tags( $exhibition->title ),
      'post_content'  => '<i>' . $exhibition->description_ingress . '</i><br><br>' .$exhibition->description,
      'post_status'   => 'publish',
      'post_type'     => 'exhibition',
      'post_author'   => 19
    );
     
    // Insert the post into the database
    $exhibition_post_id = wp_insert_post( $exhibition_post );
    
    if ( $exhibition_post_id != false ) {
      
      add_post_meta( $exhibition_post_id, '_exhibition_date_start', $exhibition->date_start );
      add_post_meta( $exhibition_post_id, '_exhibition_date_end', $exhibition->date_end );
      add_post_meta( $exhibition_post_id, '_exhibition_id_museum', $exhibition->id );
      add_post_meta( $exhibition_post_id, '_exhibition_artifact_uniqueid', $exhibition->unique_id );
      add_post_meta( $exhibition_post_id, '_exhibition_id_uuid', $exhibition->uuid );
      
      if ( $synchronize == false ) {
        
        delete_post_meta( $exhibition_post_id, '_exhibition_synchronize' );
        
      }
      
    }
  	
  }
    
/**
	 * Import found exhibition as an exhibition custom post type.
	 *
	 * @since 		1.0.0
	 * @var       string    $uuid    Unique ID of DigitaltMuseum post eg. CC52D261-405C-47C6-88EF-4FD7D4EF725C
	 * @return    object/false       Returns object with exhibition information if exhibition exists on DigitaltMuseum,
	 *                               otherwise returns as false.
	 */
	public function fetch_dm_exhibition( $uuid ) {
    
    $url = 'http://api.dimu.org/artifact/uuid/'.$uuid;
    
  	$args = stream_context_create(array('http'=>
      array(
          'timeout' => 2500,
      )
  	));
  	
  	if ($this->get_http_response_code( $url ) != "200") {
    	return false;
  	}
  	
  	$json_feed = file_get_contents( $url, false, $args );
  	$json_feed = json_decode( $json_feed );
  	
  	foreach ( $json_feed->exhibition->titles as $title ) :
  	
  	  if ( $title->status == 'original' ) :
  	    $exhibition_title = $title->title;
  	  endif;
  	  
  	endforeach;
  	
    $exhibition = (object) [
      'title' => $exhibition_title,
      'uuid' => $uuid,
      'unique_id' => $json_feed->unique_id,
      'id' => $json_feed->identifier->id,
      'date_start' => $this->dm_date_to_wp( $json_feed->exhibition->timespan->fromDate ),
      'date_end' => $this->dm_date_to_wp( $json_feed->exhibition->timespan->toDate ),
      'description_ingress' => nl2br( $json_feed->exhibition->description ),
      'description' => nl2br( $json_feed->description ),
    ];
  	
  	return $exhibition;
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
  
  public function get_meta_values( $key = '', $type = 'exhibition') {

    global $wpdb;

    if( empty( $key ) )
        return;

    $r = $wpdb->get_results( $wpdb->prepare( "
      SELECT pm.meta_value, pm.post_id FROM {$wpdb->postmeta} pm
      LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
      WHERE pm.meta_key = '%s'
      AND p.post_type = '%s'
    ", $key, $type ), OBJECT_K );

    return $r;
  }
  
  /**
	 * Get response code of http request
	 *
	 * @since 		1.0.0
	 * @var       string    $url     URL to check
	 * @return    string             Response code
	 */  
  public function get_http_response_code( $url ) {
    
    $headers = get_headers( $url );
    return substr( $headers[0], 9, 3 );
    
  }
	
} // class