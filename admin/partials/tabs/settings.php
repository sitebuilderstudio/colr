<?php
// admin settings page
?>
<h1>Settings</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'colr-options-defaults-group' ); ?>
    <?php do_settings_sections( 'colr-options-defaults-group' ); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Default Colr Scheme</th>
            <td><input type="text" name="colr_default" value="<?php echo esc_attr( get_option('colr_default') ); ?>" /></td>
        </tr>

        <tr valign="top">
            <th scope="row">Default Dark Mode</th>
            <td><input type="text" name="colr_default_dark" value="<?php echo esc_attr( get_option('colr_default_dark') ); ?>" /></td>
        </tr>

        <tr valign="top">
            <th scope="row">Class Quantity</th>
            <td><input type="text" name="colr_default_class_qty" value="<?php echo esc_attr( get_option('colr_default_class_qty') ); ?>" /></td>
        </tr>

    </table>
    <?php submit_button(); ?>
</form>


