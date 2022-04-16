<?php

$colrs = Colr_Public::getCurrentUsersColrScheme();

// backup of my color scheme
// {"bg":"#ccd9dd","headerbg":"#3c3c3c","mainmenulinks":"#000000","h1":"#959595","h2":"#c87c37","btns":"#5e2b59","linkbm":"#6062b5","notebm":"#8d98bc","tag":"#a6a6a6","borderbm":"#480048"}

?>
<div class="p-4 md:p-6 bg-white rounded-lg">
    <h2 class="text-2xl font-medium">Customize Your View</h2>
    <form name="colr_picker" method="post" action="<?= admin_url( 'admin-post.php' ) ?>" class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-bg" style="background-color: <?= $colrs->bg ?>"></div>
                <label class="block" for="bg">Main Background</label>
                <input type="text" class="block w-full color-picker" id="bg" name="bg" value="<?= $colrs->bg ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-headerbg" style="background-color: <?= $colrs->headerbg ?>"></div>
                <label class="block" for="bg">Header Background</label>
                <input type="text" class="block w-full color-picker" id="headerbg" name="headerbg" value="<?= $colrs->headerbg ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-mainmenulinks" style="background-color: <?= $colrs->mainmenulinks ?>"></div>
                <label class="block" for="bg">Main Menu Links</label>
                <input type="text" class="block w-full color-picker" id="mainmenulinks" name="mainmenulinks" value="<?= $colrs->mainmenulinks ?>">
            </div>
            <div class="col-span-1"><div class="colr-demo" id="colr-demo-h1" style="background-color: <?= $colrs->h1 ?>"></div>
                <label class="block" for="bg">Primary Page Title</label>
                <input type="text" class="block w-full color-picker" id="h1" name="h1" value="<?= $colrs->h1 ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-h2" style="background-color: <?= $colrs->h1 ?>"></div>
                <label class="block" for="bg">Secondary Page Title</label>
                <input type="text" class="block w-full color-picker" id="h2" name="h2" value="<?= $colrs->h2 ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-linkbm" style="background-color: <?= $colrs->linkbm ?>"></div>
                <label class="block" for="favcolor">Bookmark Link</label>
                <input type="text" class="block w-full color-picker" id="favcolor" name="linkbm" value="<?= $colrs->linkbm ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-notebm" style="background-color: <?= $colrs->notebm ?>"></div>
                <label class="block" for="favcolor">Bookmark Note</label>
                <input type="text" class="block w-full color-picker" id="notebm" name="notebm" value="<?= $colrs->notebm ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-tag" style="background-color: <?= $colrs->tag ?>"></div>
                <label class="block" for="favcolor">Tag</label>
                <input type="text" class="block w-full color-picker" id="tag" name="tag" value="<?= $colrs->tag ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-border" style="background-color: <?= $colrs->borderbm ?>"></div>
                <label class="block" for="favcolor">Border</label>
                <input type="text" class="block w-full color-picker" id="border" name="borderbm" value="<?= $colrs->borderbm ?>">
            </div>
            <div class="col-span-1">
                <div class="colr-demo" id="colr-demo-btns"></div>
                <label class="block" for="btns">Buttons</label>
                <input type="text" class="block w-full color-picker" id="btns" name="btns" value="<?= $colrs->btns ?>">
            </div>
        </div>
        <input type="hidden" name="colr_scheme_id" value="<?php if(isset($id)) { echo $id; } ?>" />
        <input type="hidden" name="nonce" value="<?= wp_create_nonce('colr_picker') ?>" />
        <input type="hidden" name="action" value="colr_picker" />
        <div class="mt-8 ">
            <button id="update_settings_save" class="block w-full md:w-auto px-8 py-3 bg-indigo-500 rounded text-white hover:bg-opacity-75">
                Save
            </button>
        </div>
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
