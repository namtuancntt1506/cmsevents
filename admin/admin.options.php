<?php
add_action('admin_menu', 'touristtravel_menu_page');
add_action('admin_init', 'touristtravel_register_options');

function touristtravel_menu_page()
{
    add_options_page('Tourist Travel', 'Tourist Travel', 'manage_options', 'touristtravel', 'touristtravel_options_page');
}

function touristtravel_register_options()
{
    register_setting( 'touristtravel', '_tt_column' );
    register_setting( 'touristtravel', '_tt_items' );
}

function touristtravel_options_page()
{
    ?>
    <div class="wrap">
        <h2><?php _e('Tourist Travel Setting', TOURISTTRAVEL_NAME); ?></h2>
        <form action="options.php" method="post">
        <?php settings_fields( 'touristtravel' ); do_settings_sections( 'touristtravel' ); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php _e('Column', TOURISTTRAVEL_NAME); ?></th>
                    <td>
                        <input name="_tt_column" id="_tt_column" type="number" min="1" max="4" step="1" value="<?php echo get_option('_tt_column', 3); ?>" class="small-text">
                        <label for="_tt_column"><?php _e('set column layout', TOURISTTRAVEL_NAME); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Max Items', TOURISTTRAVEL_NAME); ?></th>
                    <td>
                        <input name="_tt_items" id="_tt_items" type="number" min="1" step="1" value="<?php echo get_option('_tt_items', 6); ?>" class="small-text">
                        <label for="_tt_items"><?php _e('set max items', TOURISTTRAVEL_NAME); ?></label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
        </form>
    </div>
    <?php
}