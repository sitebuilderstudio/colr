<?php

// admin options page tab, for setting css property names etc

$map = get_option('colr_map');
if(!$map) { $map=array(); }
$qty = get_option('colr_default_class_qty');
?>
<h1>CSS Selector Map</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'colr-options-map-group' ); ?>
    <?php do_settings_sections( 'colr-options-map-group' ); ?>
    <table class="form-table" id="colr-options-map">
        <thead>
            <tr>
                <th>ID</th>
                <th>Display Name</th>
                <th>Selector</th>
                <th>Property</th>
            </tr>
        </thead>
        <?php
        $i = 1;
        while($qty>=$i){
            ?>
            <tr valign="top">
                <td><?= $i ?></td>
                <td>
                    <input type="text" name="colr_map[<?= $i ?>][name]" value="<?php
                    if(isset($map[$i]['name'])) {
                        echo esc_attr($map[$i]['name']);
                    }?>" />
                </td>
                <td>
                    <input type="text" name="colr_map[<?= $i ?>][selector]" value="<?php
                    if(isset($map[$i]['selector'])) {
                        echo esc_attr($map[$i]['selector']);
                    }?>" />
                </td>
                <td>
                    <?php
                    if(isset($map[$i]['type'])) {
                        $type = esc_attr($map[$i]['type']);
                    }else{
                        $type = "";
                    }
                    ?>
                    <select name="colr_map[<?= $i ?>][type]">
                        <option value="1" <?php if($type==="1") { echo "selected"; } ?>>Color</option>
                        <option value="2" <?php if($type==="2") { echo "selected"; } ?>>Background Color</option>
                        <option value="3" <?php if($type==="3") { echo "selected"; } ?>>Border Color</option>
                    </select>
                </td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </table>
    <?php submit_button(); ?>
</form>


