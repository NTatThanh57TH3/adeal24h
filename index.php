<?php
$page = 'index';
include 'header.php';

$page_title = $setting['setting_metatitle_web'] ? $setting['setting_metatitle_web'] : $setting['setting_title_web'];

// Process only new path
$new_path_file = DIR_ROOT . 'webonly/' .$siteDisplay['site_domain'] . '/index.php';
if(file_exists($new_path_file)) {
    include 'application_webonly.php';
    require_once ($new_path_file);
    include 'footer.php';
    exit();
}else{
    include 'application.php';
}

if ( isset($setting['setting_design_page'][$page]) && $setting['setting_design_page'][$page] && is_array($setting['setting_design_page'][$page]) && count($setting['setting_design_page'][$page]) && !empty($setting['setting_design_page'][$page]) ) {
    foreach ($setting['setting_design_page'][$page] as $file) {
        if ($file['module_name'] == 'top_search_keyword') {
            $file['directory'] = 'searchs';
        }
        if ($file['extension'] && $file['module_name'] && $file['directory']) {
            if (file_exists('include/develops/' . $file['directory'] . '/modules/' . $template . '/' . $file['module_name'] . '.' . $file['extension']))
                require_once 'include/develops/' . $file['directory'] . '/modules/' . $template . '/' . $file['module_name'] . '.' . $file['extension'];
            else
                require_once 'include/develops/' . $file['directory'] . '/modules/' . $file['module_name'] . '.' . $file['extension'];
        }
    }
    include 'footer.php';
}

if ( !$_list_global_modules && !$setting['setting_design_page'] ){
    if ( $site_product ){
        if ( file_exists('include/develops/products/modules/'.$template.'/product_categories.php') )
            require_once 'include/develops/products/modules/'.$template.'/product_categories.php';
        else
            require_once 'include/develops/products/modules/product_categories.php';
    }
    if ( $site_news && !$site_product ){
        if (file_exists('include/develops/contents/modules/'.$template.'/content_special.php'))
            require_once 'include/develops/contents/modules/'.$template.'/content_special.php';
        else
            require_once 'include/develops/contents/modules/content_special.php';

        if ( file_exists('include/develops/contents/modules/'.$template.'/content_categories.php'))
            require_once 'include/develops/contents/modules/'.$template.'/content_categories.php';
        else
            require_once 'include/develops/contents/modules/content_categories.php';

        if ( file_exists('include/develops/contents/modules/'.$template.'/content_category_position.php'))
            require_once 'include/develops/contents/modules/'.$template.'/content_category_position.php';
        else
            require_once 'include/develops/contents/modules/content_category_position.php';

        if (file_exists('include/develops/contents/modules/'.$template.'/content_create_box.php'))
            require_once 'include/develops/contents/modules/'.$template.'/content_create_box.php';
        else
            require_once 'include/develops/contents/modules/content_create_box.php';
    }else if ( $site_news && $site_product ){
        if (file_exists('include/develops/contents/modules/'.$template.'/content_special.php'))
            require_once 'include/develops/contents/modules/'.$template.'/content_special.php';
        else
            require_once 'include/develops/contents/modules/content_special.php';

        if ( file_exists('include/develops/contents/modules/'.$template.'/content_categories.php'))
            require_once 'include/develops/contents/modules/'.$template.'/content_categories.php';
        else
            require_once 'include/develops/contents/modules/content_categories.php';
    }
}

include 'footer.php';