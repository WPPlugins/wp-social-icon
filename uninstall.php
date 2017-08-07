<?php

/**
 * Désinstallation du plugin WP Social Icons
 */
function wpsi_uninstall() {  
    if(get_option('wp_socialicon_settings')) { delete_option('wp_socialicon_settings'); }
    if(get_option('wp_socialicon_style')) {  delete_option('wp_socialicon_style'); }

}
register_deactivation_hook(__FILE__, 'wpsi_uninstall');
