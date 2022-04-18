<?php
$colrs = (array) self::getCurrentUsersColrScheme();
$map = get_option('colr_map');
?>
<div class="container" style="display:table;">
    <h2>Customize Your View</h2>
    <form name="colr_picker" method="post" action="<?= admin_url( 'admin-post.php' ) ?>">
        <?php
                $i = 1;
                foreach($map as $dec){
                    if(!empty($dec['selector']) && !empty($dec['type'])){
                        ?>
                            <div style="margin:30px; float:left;">
                    <div class="colr-demo" id="colr-demo-<?= $i ?>" style="background-color: <?= $colrs[$i] ?>"></div>
                    <label class="block" for="<?= $colrs[$i] ?>"><?= $dec['name'] ?></label>
                    <input type="text" class="block w-full color-picker" id="<?= $i ?>" name="<?= $i ?>" value="<?= $colrs[$i] ?>">
                </div>
                    <?php
                    }
                    $i++;
                }
                ?>
            </tr>
        </table>
        <input type="hidden" name="colr_scheme_id" value="<?php if(isset($id)) { echo $id; } ?>" />
        <input type="hidden" name="nonce" value="<?= wp_create_nonce('colr_picker') ?>" />
        <input type="hidden" name="action" value="colr_picker" />
        <button id="update_settings_save" class="block w-full md:w-auto px-8 py-3 bg-indigo-500 rounded text-white hover:bg-opacity-75">
            Save
        </button>
    </form>
</div>
<script src="<?= COLR_DIR_URL ?>public/js/colr-picker.js"></script>
<script>
    let sources = document.querySelectorAll('input.color-picker');
    // Set hooks for each source element
    for (let i = 0, j = sources.length; i < j; ++i) {
        (new CP(sources[i])).on('change', function(r, g, b, a) {
            this.source.value = this.color(r, g, b, a);
            let id = this.source.id;
            var demo = document.getElementById('colr-demo-'+id);
            if(demo) {
                demo.style.backgroundColor = this.color(r, g, b, a);
            }
        });
    }
</script>
