<?php

/* Update des paramètres */
if($_POST['action'] == 'update' && $_POST["wp_socialicon_settings"]!='') {
    update_option('wp_socialicon_settings', $_POST["wp_socialicon_settings"]);
    update_option('wp_socialicon_style', $_POST["wp_socialicon_style"]);
    $options_saved = true;
    echo '<div id="message" class="updated fade"><p><strong>Options sauvegardées.</strong></p></div>';
}

// Récupère les paramètres sauvegardés
if(get_option('wp_socialicon_settings')) { extract(get_option('wp_socialicon_settings')); }
$paramMMode = get_option('wp_socialicon_settings');

/* Feuille de style par défault */
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

/* Si on réinitialise les feuille de styles  */
if($_POST['wpsi_initcss']==1) {
    update_option('wp_socialicon_style', $wpsi_style_defaut);
    $options_saved = true;
    echo '<div id="message" class="updated fade"><p><strong>Feuillez de style réinitialisée !</strong></p></div>';
}

?>
<style type="text/css">.postbox h3 { cursor:pointer; }</style>
<div class="wrap">

    <!-- TABS OPTIONS -->
    <div id="icon-options-general" class="icon32"><br></div>
        <h2 class="nav-tab-wrapper">
            <a id="wpsi-menu-general" class="nav-tab nav-tab-active" href="#general" onfocus="this.blur();"><?php echo __('General', 'wp-socialicon'); ?></a>
            <a id="wpsi-menu-modele" class="nav-tab" href="#modele" onfocus="this.blur();"><?php echo __('Models', 'wp-socialicon'); ?></a>
            <a id="wpsi-menu-options" class="nav-tab" href="#options" onfocus="this.blur();"><?php echo __('Options', 'wp-socialicon'); ?></a>
            <a id="wpsi-menu-style" class="nav-tab" href="#style" onfocus="this.blur();"><?php echo __('CSS Stylesheet', 'wp-socialicon'); ?></a>
            <a id="wpsi-menu-apropos" class="nav-tab" href="#apropos" onfocus="this.blur();"><?php echo __('About', 'wp-socialicon'); ?></a>
        </h2>
    </div>

    <div>
        <div class="clear"/>

         <div style="margin-left:25px;margin-top: 15px;">
            <form method="post" action="" name="valide_settings">
                <input type="hidden" name="action" value="update" />

             <!-- GENERAL -->
             <div class="wpsi-menu-general wpsi-menu-group">
                 <div id="wpsi-opt-general"  >
                         <ul>

                            <!-- URL PROFIL RESEAUX SOCIAUX -->
                            <li><h3><?php echo __('Enter socials URL :', 'wp-socialicon'); ?></h3>
                            <p><?php echo __('Place this shortcode to the place you want :  do_shortcode(\'[wpsocialicon]\')', 'wp-socialicon'); ?></p>
                                 <table class="wp-list-table widefat fixed" cellspacing="0" style="width:70%">
                                        <tbody id="the-list">
                                            <tr>
                                                <td width="20%">Facebook</td>
                                                <td><input type="text" name="wp_socialicon_settings[url_facebook]" size="55" value="<?php echo $paramMMode['url_facebook'] ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">Twitter</td>
                                                <td><input type="text" name="wp_socialicon_settings[url_twitter]" size="55" value="<?php echo $paramMMode['url_twitter'] ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">Google+</td>
                                                <td><input type="text" name="wp_socialicon_settings[url_googleplus]" size="55" value="<?php echo $paramMMode['url_googleplus'] ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">Pinterest</td>
                                                <td><input type="text" name="wp_socialicon_settings[url_pinterest]" size="55" value="<?php echo $paramMMode['url_pinterest'] ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">Flickr</td>
                                                <td><input type="text" name="wp_socialicon_settings[url_flickr]" size="55" value="<?php echo $paramMMode['url_flickr'] ?>" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </li>

                            <li> &nbsp;</li>
                            <li>
                                <a href="#general" id="submitbutton" OnClick="document.forms['valide_settings'].submit();this.blur();" name="Save" class="button-primary"><span> <?php echo __('Save this settings', 'wp-socialicon'); ?> </span></a>
                            </li>

                        </ul>
                 </div>
             </div>

              <!-- MODELES -->
             <div class="wpsi-menu-modele wpsi-menu-group"  style="display: none;">
                 <div id="wpsi-opt-modele"  >
                         <ul>

                            <!-- MODELE ICON -->
                            <li>
                                <?php if($paramMMode['enable_img']==true) { ?>
                                    <div class="error"><p><?php echo __('The selection of icons is disable. You have activated the personal folder icons.', 'wp-socialicon'); ?></p></div>
                                <?php } ?>
                                <h3><?php echo __('Choose model of your socials icons :', 'wp-socialicon'); ?></h3>
                                <div id="">
                                <?php 
                                    $arr = array(1, 2, 3, 4, 5, 6, 7);
                                    foreach ($arr as &$value) {
                                ?>
                                    <div style="text-align:center;float:left;margin:10px;">
                                        <img src="<?php echo WP_PLUGIN_URL; ?>/wp-social-icon/images/<?php echo $value; ?>/google-plus.png" /><br />
                                        <input type= "radio" name="wp_socialicon_settings[modele]" value="<?php echo $value; ?>" <?php if($paramMMode['modele']==$value) { echo ' checked'; } ?>>
                                    </div>
                                <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </li>
                            <li> &nbsp;</li>

                            <li>
                                <a href="#modele" id="submitbutton" OnClick="document.forms['valide_settings'].submit();this.blur();" name="Save" class="button-primary"><span> <?php echo __('Save this settings', 'wp-socialicon'); ?> </span></a>
                            </li>

                        </ul>
                 </div>
             </div>

             <!-- OPTIONS -->
             <div class="wpsi-menu-options wpsi-menu-group" style="display: none;">
                 <div id="wpsi-opt-options"  >
                         <ul>
                            <!-- URL ICONES -->
                            <li>
                                <h3><?php echo __('URL of icon sources :', 'wp-socialicon'); ?></h3><p><?php echo __('You have personal icons? Enter here URL of your icons.', 'wp-socialicon'); ?><br /><?php echo __('Please use this icon names: ', 'wp-socialicon'); ?><i> facebook.png, twitter.png, google-plus.png, pinterest.png, flickr.png</i></p>
                            </li>
                            <li>
                                <input type= "checkbox" name="wp_socialicon_settings[enable_img]" value="true" <?php if($paramMMode['enable_img']==true) { echo ' checked'; } ?>>&nbsp;<?php echo __('Enable personnal folder ?', 'wp-socialicon'); ?>
                            </li>
                            <li>
                                <?php echo wpsi_getpathimg(); ?><input type="text" name="wp_socialicon_settings[src]" size="55" value="<?php echo $paramMMode['src'] ?>" />
                            </li>

                            <!-- CHOIX DESACTIVATION VERSION MOBILE -->
                            <li> <h3><?php echo __('Mobile version', 'wp-socialicon'); ?></h3>
                                <input type= "checkbox" name="wp_socialicon_settings[disable_m]" value="1" <?php if($paramMMode['disable_m']==1) { echo ' checked'; } ?>>&nbsp;<?php echo __('Disable in mobile version ?', 'wp-socialicon'); ?>
                            </li>
                            <li> &nbsp;</li>
                            <li>
                                <a href="#options" id="submitbutton" OnClick="document.forms['valide_settings'].submit();this.blur();" name="Save" class="button-primary"><span> <?php echo __('Save this settings', 'wp-socialicon'); ?> </span></a>
                            </li>

                        </ul>
                 </div>
             </div>

            <!-- STYLE -->
             <div class="wpsi-menu-style wpsi-menu-group" style="display: none;">
                 <div id="wpsi-opt-style"  >
                         <ul>
                             <!-- UTILISER UNE FEUILLE DE STYLE PERSO -->
                            <li><h3><?php echo __('CSS style sheet code :', 'wp-socialicon'); ?></h3>
                                <?php echo __('Edit the CSS sheet of your maintenance page here. Click "Reset" and "Save" to retrieve the default style sheet.', 'wp-socialicon'); ?><br /><br />
                                 <TEXTAREA NAME="wp_socialicon_style" COLS=30 ROWS=10 style="width:80%;"><?php echo stripslashes(trim(get_option('wp_socialicon_style'))); ?></TEXTAREA>
                            </li>
                            <li>
                                <input type= "checkbox" name="wpsi_initcss" value="1" id="initcss" >&nbsp;<label for="wpsi_initcss"><?php echo __('Reset default CSS stylesheet ?', 'wp-socialicon'); ?></label><br />
                            </li>
                            <li> &nbsp;</li>

                            <li>
                                <a href="#style" id="submitbutton" OnClick="document.forms['valide_settings'].submit();this.blur();" name="Save" class="button-primary"><span> <?php echo __('Save this settings', 'wp-socialicon'); ?> </span></a>
                            </li>
                        </ul>
                 </div>
             </div>

            </form>

             <!-- Onglet options 6 -->
             <div class="wpsi-menu-apropos wpsi-menu-group" style="display: none;">
                 <div id="wpsi-opt-apropos"  >
                         <ul>
                            <li><?php echo __('This plugin has been developed for you for free by <a href="http://www.restezconnectes.fr" target="_blank">Florent Maillefaud</ a>. It is royalty free, you can take it, modify it, distribute it as you see fit. <br /> <br />It would be desirable that I can get feedback on your potential changes to improve this plugin for all.', 'wp-socialicon'); ?>
                            </li>
                            <li> &nbsp;</li>
                            <li>
                                <!-- FAIRE UN DON SUR PAYPAL -->
                                <div><?php echo __('If you want Donate (French Paypal) for my current and future developments:', 'wp-socialicon'); ?><br />
                                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="ABGJLUXM5VP58">
                                    <input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
                                    </form>
                                </div>
                                <!-- FIN FAIRE UN DON -->
                            </li>
                            <li> &nbsp;</li>
                        </ul>
                 </div>
             </div>

     </div><!-- -->

</div><!-- -->

