<?php

/*
Plugin Name: WP SocialIcon
Plugin URI: http://wordpress.org/extend/plugins/wp-socialicon/
Description: Ajouter les icones de vos réseaux sociaux préférés / Place on your website icons of your favorite social networks
Author: Florent Maillefaud
Author URI: http://www.restezconnectes.fr/
Text Domain: wp-socialicon
Domain Path: /languages/
Version: 1.4
*/


/*
Change Log
13/10/13 - Modifications du fichier Readme.txt
11/09/13 - Conflits avec javascript résolus
10/09/13 - Résolution de bugs et amléliorations
02/09/2013 - Création du Plugin 1.0
*/

if(!defined('WP_CONTENT_URL')) { define('WP_CONTENT_URL', get_option( 'siteurl') . '/wp-content'); }
if(!defined('WP_CONTENT_DIR')) { define('WP_CONTENT_DIR', ABSPATH . 'wp-content'); }
if(!defined('WP_PLUGIN_URL')) { define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins'); }
if(!defined('WP_PLUGIN_DIR')) { define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins'); }
if(!defined( 'WPSI_BASENAME')) { define( 'WPSI_BASENAME', plugin_basename(__FILE__) ); }
if(!defined( 'WPSI_PATHTHEME')) { define( 'WPSI_PATHTHEME', get_bloginfo('siteurl').'/wp-content/themes'); }

include("uninstall.php");

/* Ajout réglages au plugin */
$wpsocialicon_dashboard = ( is_admin() ) ? 'options-general.php?page=wp-social-icon/wp-socialicon.php' : '';
define( 'WPSI_SETTINGS', $wpsocialicon_dashboard);

// multilingue
add_action( 'init', 'wpsi_make_wpm_multilang' );
function wpsi_make_wpm_multilang() {
    load_plugin_textdomain('wp-socialicon', false, dirname( plugin_basename( __FILE__ ) ).'/languages');
}

// Add "Réglages" link on plugins page
add_filter( 'plugin_action_links_' . WPSI_BASENAME, 'wpsocialicon_plugin_actions' );
function wpsocialicon_plugin_actions ( $links ) {
    $settings_link = '<a href="'.WPSI_SETTINGS.'">'.__('Settings', 'wp-socialicon').'</a>';
    array_unshift ( $links, $settings_link );
    return $links;
}

/* Ajoute la version dans les options */
define('WPSI_VERSION', '1.4');
$option['wp_socialicon_version'] = WPSI_VERSION;
add_option('wp_socialicon_version', $option);

//récupère le formulaire d'administration du plugin
function admin_socialicon_panel() {
    include("wp-socialicon-admin.php");
}

function wp_socialicon_scripts() {
    wp_register_script('wp-socialicon-settings', WP_PLUGIN_URL.'/wp-social-icon/wp-socialicon-settings.js');
    wp_enqueue_script('wp-socialicon-settings');
}
if (isset($_GET['page']) && $_GET['page'] == 'wp-social-icon/wp-socialicon.php') {
    add_action('admin_print_scripts', 'wp_socialicon_scripts');
}

function add_wpsocialicon_admin() {

    $hook = add_options_page(__('WP Social Icon settings', 'wp-socialicon'), "WP Social Icon",  10, __FILE__, "admin_socialicon_panel");
    $wp_socialiconAdminOptions = array(
        'src' => '',
        'modele' => 1
    );
    $get_socialiconSettings = get_option('wp_socialicon_settings');
    if (!empty($get_socialiconSettings)) {
        foreach ($get_socialiconSettings as $key => $option) {
            $wp_socialiconAdminOptions[$key] = $option;
        }
    }
    update_option('wp_socialicon_settings', $wp_socialiconAdminOptions);
    
    $wpsi_style_defaut = '
#wp-socialicon-media-icons {
    float: right;
    margin-top: 15px;
}
a.wp-socialicon-media-icon {
    background-position: 0 0;
    display: inline-block;
    height: 32px;
    margin-right: 6px;
    overflow: hidden;
    text-indent: -1000px;
    transition: background-position 0.25s ease 0s;
    width: 32px;
}
a.wp-socialicon-media-icon:hover {
    background-position: 0 -32px;
}
';
    if(!get_option('wp_socialicon_style')) { update_option('wp_socialicon_style', $wpsi_style_defaut); }
}
//intègre le tout aux pages Admin de Wordpress
add_action("admin_menu", "add_wpsocialicon_admin");

/* Ajoute une CSS */
//wp_enqueue_style('wpsi-style', WP_PLUGIN_URL.'/wp-social-icon/wp-socialicon-style.css');

/* Retourne le chemin vers le dossier images du thème */
function wpsi_getpathimg() {

    if(is_child_theme()) {
        $pathImg = get_bloginfo('stylesheet_directory');
        $pathImg = str_replace(WPSI_PATHTHEME, '', $pathImg).'/images/';
    } else {
       $pathImg = get_bloginfo('template_url');
       $pathImg = str_replace($pathURL, '', $pathImg).'/images/';
    }
    return $pathImg;
}

/* Retourne la CSS dans le header */
add_action('wp_head','wpsi_custom_css', 1);
function wpsi_custom_css() {
    global $wpdb;
    if(get_option('wp_socialicon_settings')) { extract(get_option('wp_socialicon_settings')); }
    $params = get_option('wp_socialicon_settings');

    if($params['src']!='' && $params['enable_img']==true) {
        $wpSI_srcimages = WPSI_PATHTHEME.wpsi_getpathimg().$params['src'];
    } else {
        $wpSI_srcimages = WP_PLUGIN_URL.'/wp-social-icon/images/'.$params['modele'];
    }
    $get_socialiconStyle = get_option('wp_socialicon_style');

echo '
<!-- STYLE SOCIAL ICON '.$params['modele'].'-->
<style type="text/css">
'.$get_socialiconStyle.'
    .facebook {
        background-image: url("'.$wpSI_srcimages.'/facebook.png");
    }
    .twitter {
        background-image: url("'.$wpSI_srcimages.'/twitter.png");
    }
    .google-plus {
        background-image: url("'.$wpSI_srcimages.'/google-plus.png");
    }
    .pinterest {
        background-image: url("'.$wpSI_srcimages.'/pinterest.png");
    }
    .flickr {
        background-image: url("'.$wpSI_srcimages.'/flickr.png");
    }
</style>
';

}

// Add Shortcode
function wpsocialicon_shortcode( $atts ) {

    global $wpdb;
    // Attributes
    extract( shortcode_atts(
        array(
            'modele' => '1'
        ), $atts )
    );
    if(get_option('wp_socialicon_settings')) { extract(get_option('wp_socialicon_settings')); }
    $params = get_option('wp_socialicon_settings');

    $print  = '<div id="wp-socialicon-media-icons">';
    if($params['url_facebook']!='') {
        $print  .= '<a class="wp-socialicon-media-icon facebook" href="'.$params['url_facebook'].'" target="_blank">Facebook</a>';
    }
    if($params['url_twitter']!='') {
        $print  .= '<a class="wp-socialicon-media-icon twitter" href="'.$params['url_twitter'].'" target="_blank">Twitter</a>';
    }
    if($params['url_googleplus']!='') {
        $print  .= '<a class="wp-socialicon-media-icon google-plus" href="'.$params['url_googleplus'].'" target="_blank">Google+</a>';
    }
    if($params['url_pinterest']!='') {
        $print  .= '<a class="wp-socialicon-media-icon pinterest" href="'.$params['url_pinterest'].'" target="_blank">Pinterest</a>';
    }
    if($params['url_flickr']!='') {
        $print  .= '<a class="wp-socialicon-media-icon flickr" href="'.$params['url_flickr'].'" target="_blank">Flickr</a>';
    }
    $print .='</div>';

    // Code
    if ( wp_is_mobile() == true && $params['disable_m']==1 ) {
        return '';
    } else {
        return  $print;
    }

}
add_shortcode( 'wpsocialicon', 'wpsocialicon_shortcode' );

if(function_exists('register_deactivation_hook')) {
    register_deactivation_hook(__FILE__, 'wpsi_uninstall');
}
?>
