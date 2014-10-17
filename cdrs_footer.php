<?php
/*
    Plugin Name: CDRS Footer
    Plugin URI: http://cdrs.columbia.edu
    Description: Custom CDRS footer
    Author: Megan O'Neill
    Version: 0.1-alpha
    Author URI: http://cdrs.columbia.edu
    Domain Path: /lang
 */

function my_new_admin_menu() {
    $page = add_theme_page( 'Footer', 'Footer', 'edit_theme_options', 'my-footer-options', 'my_footer_options' );
    add_action( 'admin_print_styles-' . $page, 'my_footer_admin_scripts' );
}
add_action( 'admin_menu', 'my_new_admin_menu' );

function my_footer_admin_scripts() {
    // We'll put some javascript & css here later
}

function my_footer_options() {
    ?>
    <div class="wrap">
        <div id="icon-themes" class="icon32" ><br></div>
        <h2>Footer Options</h2>

        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php wp_nonce_field( 'update-footer-options' ); ?>
            <?php settings_fields( 'my-footer-options' ); ?>
            <?php do_settings_sections( 'my-footer-options' ); ?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="Save Changes" />
            </p >
        </form>
    </div>
    <?php
}

function my_footer_admin_init() {
    register_setting( 'my-footer-options', 'my-footer-options');
    add_settings_section( 'footer_general', 'Footer Settings', 'my_footer_general', 'my-footer-options' );
    add_settings_field('copyright', 'Copyright License:', 'copyright_settings', 'my-footer-options', 'footer_general');
    add_settings_field('copyright_url', '', 'copyright_setting_url', 'my-footer-options', 'footer_general');
    add_settings_field('manual_copyright', 'Custom Copyright Statement:', 'custom_copyright', 'my-footer-options', 'footer_general');
    add_settings_field('ac_partner', 'Academic Commons Partner?', 'ac_partner_setting', 'my-footer-options', 'footer_general');
    add_settings_field('full_text_setting', 'This site displays: ', 'full_text_setting', 'my-footer-options', 'footer_general');
}
add_action( 'admin_init', 'my_footer_admin_init' );

function my_footer_general() {
    _e( 'Edit your settings' );
}

function copyright_settings() {
    $options = get_option( 'my-footer-options' );
    $copyright = ( $options['copyright'] != "" ) ? sanitize_text_field( $options['copyright'] ) : '';
    echo '<input id="copyright"  placeholder="name" name="my-footer-options[copyright]" type="text" value="' . $copyright .'" />';

}

function copyright_setting_url() {
    $options = get_option( 'my-footer-options' );
    $copyright_url = ( $options['copyright_url'] != "" ) ? sanitize_text_field( $options['copyright_url'] ) : '';
    echo '<input id="copyright_url"  placeholder="url" name="my-footer-options[copyright_url]" type="text" value="' . $copyright_url .'" />';

}

function ac_partner_setting() {
    $options = get_option( 'my-footer-options' );

    // Get the value of this option.
    $checked = $options['ac_partner'];

    // The value to compare with (the value of the checkbox below).
    $current = 1;

    // True by default, just here to make things clear.
    $echo = true;

    ?>
    <input id="ac_partner"  type="checkbox" name="my-footer-options[ac_partner]" type="text" value="1" <?php if ( 1 == $options['ac_partner'] ) echo 'checked="checked"'; ?> />

    <?php
}

function custom_copyright(){
    $options = get_option( 'my-footer-options' );
    $custom_copyright = ( $options['custom_copyright'] != "" ) ? sanitize_text_field( $options['custom_copyright'] ) : '';
    echo 'OR</br>';
    echo '<input id="custom_copyright" name="my-footer-options[custom_copyright]" type="text" value="' . $custom_copyright .'" />';
}

function full_text_setting(){
    $options = get_option( 'my-footer-options' );
    ?>
    Abstract
    <input type="radio" name="my-footer-options[full_text_setting]" value="abstract"<?php checked( 'abstract' == $options['full_text_setting'] ); ?> />
    Full Text
    <input type="radio" name="my-footer-options[full_text_setting]" value="full_text"<?php checked( 'full_text' == $options['full_text_setting'] ); ?> />
    <?php
}



