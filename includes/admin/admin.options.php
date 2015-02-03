<?php
add_action('admin_menu', 'cmsevent_menu_page');
add_action('admin_init', 'cmsevent_register_options');

function cmsevent_menu_page()
{
    add_submenu_page('edit.php?post_type=events', __('Setting', CMSEVENTS_NAME), __('Setting', CMSEVENTS_NAME), 'manage_options', 'cmsevents', 'cmsevent_options_page');
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
                    <th scope="row"><?php _e('Column', CMSEVENTS_NAME); ?></th>
                    <td>
                        <input name="_tt_column" id="_tt_column" type="number" min="1" max="4" step="1" value="<?php echo get_option('_tt_column', 3); ?>" class="small-text">
                        <label for="_tt_column"><?php _e('set column layout', CMSEVENTS_NAME); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Max Items', CMSEVENTS_NAME); ?></th>
                    <td>
                        <input name="_tt_items" id="_tt_items" type="number" min="1" step="1" value="<?php echo get_option('_tt_items', 6); ?>" class="small-text">
                        <label for="_tt_items"><?php _e('set max items', CMSEVENTS_NAME); ?></label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
        </form>
    </div>
    <?php
}