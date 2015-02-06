<?php
add_action('admin_menu', 'cmsevent_menu_page');
add_action('admin_init', 'cmsevent_register_options');

function cmsevent_menu_page()
{
    add_submenu_page('edit.php?post_type=event', __('Setting', CMSEVENTS_NAME), __('Setting', CMSEVENTS_NAME), 'manage_options', 'cmsevents', 'cmsevent_options_page');
}

function cmsevent_register_options()
{
    //register_setting( 'touristtravel', '_tt_column' );
    //register_setting( 'touristtravel', '_tt_items' );
}

function cmsevent_options_page()
{
    ?>
    <div class="wrap">
        <h2><?php _e('Event Setting', CMSEVENTS_NAME); ?></h2>
        <form action="options.php" method="post">
        <?php settings_fields( 'touristtravel' ); do_settings_sections( 'touristtravel' ); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"></th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
        </form>
    </div>
    <?php
}