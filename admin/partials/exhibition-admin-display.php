<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://twitter.com/edvfind
 * @since      1.0.0
 *
 * @package    Exhibition
 * @subpackage Exhibition/admin/partials
 */
?>

<div class="wrap">
<h1><?php _e( 'Exhibition settings', 'exhibition' ); ?></h1>

<form method="post" action="options.php">
  <?php settings_fields( 'exhibition-settings-group' ); ?>
  <?php do_settings_sections( 'exhibition-settings-group' ); ?>
  <h2><?php _e( 'DigitaltMuseum', 'exhibition' ); ?></h2>
  <table class="form-table">
    <tr valign="top">
    <th scope="row"><?php _e( 'API Key', 'exhibition' ); ?></th>
    <td><input type="text" name="dm_api_key" value="<?php echo esc_attr( get_option('dm_api_key') ); ?>" /></td>
    </tr>
     
    <tr valign="top">
    <th scope="row"><?php _e( 'Museum', 'exhibition' ); ?></th>
    <td><input type="text" name="dm_owner" value="<?php echo esc_attr( get_option('dm_owner') ); ?>" /></td>
    </tr>
  </table>
  
  <h2><?php _e( 'Slugs', 'exhibition' ); ?></h2>
  <table class="form-table">
    <tr valign="top">
    <th scope="row"><?php _e( 'Exhibitions', 'exhibition' ); ?></th>
    <td>/<input type="text" name="slug_exhibitions" value="<?php echo esc_attr( get_option('slug_exhibitions') ); ?>" />/</td>
    </tr>
     
    <tr valign="top">
    <th scope="row"><?php _e( 'Artists', 'exhibition' ); ?></th>
    <td>/<input type="text" name="slug_artists" value="<?php echo esc_attr( get_option('slug_artists') ); ?>" />/</td>
    </tr>
  </table>
  
  <?php submit_button(); ?>

</form>
  
  <?php
    // TESTING
    $plugin_shared = new Exhibition_Shared( 'exhibition', '1.0.0' );

    print $plugin_shared->exhibition_import_from_dm();
    ?>
</div>