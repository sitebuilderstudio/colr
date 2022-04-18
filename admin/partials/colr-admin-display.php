<?php

//if ( ! current_user_can( 'manage_options' ) ) {
//    return;
//}

$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

?>
<div class="wrap" id="colr-admin-display">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <nav class="nav-tab-wrapper">
        <a href="?page=colr" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Color Schemes</a>
        <a href="?page=colr&tab=map" class="nav-tab <?php if($tab==='map'):?>nav-tab-active<?php endif; ?>">Map</a>
        <a href="?page=colr&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
    </nav>

    <div class="tab-content">
        <?php switch($tab) :
            case 'map':
                require_once COLR_DIR_PATH . 'admin/partials/tabs/map.php';
                break;
            case 'settings':
                require_once COLR_DIR_PATH . 'admin/partials/tabs/settings.php';
                break;
            default:
                require_once COLR_DIR_PATH . 'admin/partials/tabs/schemes.php';
                break;
        endswitch; ?>
    </div>
</div>
<?php
