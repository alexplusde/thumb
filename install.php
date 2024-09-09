<?php

if (rex_media::get('thumb_bg.png') instanceof rex_media) {
    /* Neue Methode addMedia() verwenden */
    return rex_media_service::addMedia([
        'category_id' => 0,
        'title' => "Thumb-Addon: Hintergrund-Vorlage",
        'createuser' => 'thumb',
        'file' => ['name' => "thumb_bg.png",
            'path' => rex_path::addon('thumb', '/media/thumb_bg.png')]]);
}

rex_dir::create(rex_path::addonData('thumb'));

/* via rex_sql überprüfen, ob es bereits ein Media Manager Profil gibt - wenn nicht, dann anlegen */
$media_manager_types = rex_sql::factory()->setQuery('SELECT * FROM ' . rex::getTable('media_manager_type'))->getArray();
$profile_exists = false;
foreach ($media_manager_types as $profile) {
    if ($profile['name'] === rex_config::get('thumb', 'media_manager_type')) {
        $profile_exists = true;
        break;
    }
}

if(!$profile_exists) {
    $sql = rex_sql::factory();
    $sql->setTable(rex::getTable('media_manager_type'));
    $sql->setValue('name', 'thumb');
    $sql->setValue('status', 0);
    $sql->setValue('description', '');
    $sql->setValue('createdate', date('Y-m-d H:i:s'));
    $sql->setValue('createuser', 'thumb');
    $sql->setValue('updatedate', date('Y-m-d H:i:s'));
    $sql->setValue('updateuser', 'thumb');
    $sql->insert();

    /* ID des letzten Datensatzes ermitteln */
    $profile_id = rex_sql::factory()->getLastId();

    $sql = rex_sql::factory();
    $sql->setTable(rex::getTable('media_manager_type_effect'));
    $sql->setValue('type_id', $profile_id);
    $sql->setValue('effect', 'mediapath');
    $sql->setValue('parameters', '{"rex_effect_rounded_corners":{"rex_effect_rounded_corners_topleft":"","rex_effect_rounded_corners_topright":"","rex_effect_rounded_corners_bottomleft":"","rex_effect_rounded_corners_bottomright":""},"rex_effect_workspace":{"rex_effect_workspace_set_transparent":"colored","rex_effect_workspace_width":"","rex_effect_workspace_height":"","rex_effect_workspace_hpos":"left","rex_effect_workspace_vpos":"top","rex_effect_workspace_padding_x":"0","rex_effect_workspace_padding_y":"0","rex_effect_workspace_bg_r":"","rex_effect_workspace_bg_g":"","rex_effect_workspace_bg_b":"","rex_effect_workspace_bgimage":""},"rex_effect_crop":{"rex_effect_crop_width":"","rex_effect_crop_height":"","rex_effect_crop_offset_width":"","rex_effect_crop_offset_height":"","rex_effect_crop_hpos":"center","rex_effect_crop_vpos":"middle"},"rex_effect_insert_image":{"rex_effect_insert_image_brandimage":"","rex_effect_insert_image_hpos":"left","rex_effect_insert_image_vpos":"top","rex_effect_insert_image_padding_x":"-10","rex_effect_insert_image_padding_y":"-10"},"rex_effect_rotate":{"rex_effect_rotate_rotate":"0"},"rex_effect_filter_colorize":{"rex_effect_filter_colorize_filter_r":"","rex_effect_filter_colorize_filter_g":"","rex_effect_filter_colorize_filter_b":""},"rex_effect_image_properties":{"rex_effect_image_properties_jpg_quality":"","rex_effect_image_properties_png_compression":"","rex_effect_image_properties_webp_quality":"","rex_effect_image_properties_avif_quality":"","rex_effect_image_properties_avif_speed":"","rex_effect_image_properties_interlace":null},"rex_effect_filter_brightness":{"rex_effect_filter_brightness_brightness":""},"rex_effect_flip":{"rex_effect_flip_flip":"X"},"rex_effect_image_format":{"rex_effect_image_format_convert_to":"webp"},"rex_effect_filter_contrast":{"rex_effect_filter_contrast_contrast":""},"rex_effect_filter_sharpen":{"rex_effect_filter_sharpen_amount":"80","rex_effect_filter_sharpen_radius":"0.5","rex_effect_filter_sharpen_threshold":"3"},"rex_effect_resize":{"rex_effect_resize_width":"","rex_effect_resize_height":"","rex_effect_resize_style":"maximum","rex_effect_resize_allow_enlarge":"enlarge"},"rex_effect_filter_blur":{"rex_effect_filter_blur_repeats":"10","rex_effect_filter_blur_type":"gaussian","rex_effect_filter_blur_smoothit":""},"rex_effect_mirror":{"rex_effect_mirror_height":"","rex_effect_mirror_opacity":"100","rex_effect_mirror_set_transparent":"colored","rex_effect_mirror_bg_r":"","rex_effect_mirror_bg_g":"","rex_effect_mirror_bg_b":""},"rex_effect_header":{"rex_effect_header_download":"open_media","rex_effect_header_cache":"no_cache","rex_effect_header_filename":"filename","rex_effect_header_index":"index"},"rex_effect_convert2img":{"rex_effect_convert2img_convert_to":"jpg","rex_effect_convert2img_density":"150","rex_effect_convert2img_color":""},"rex_effect_mediapath":{"rex_effect_mediapath_mediapath":"..\\/var\\/data\\/addons\\/thumb"}}');
    $sql->setValue('priority', 1);
    $sql->setValue('createdate', '2024-09-06 14:41:25');
    $sql->setValue('createuser', 'mail@alexplus.de');
    $sql->setValue('updatedate', '2024-09-06 15:05:49');
    $sql->setValue('updateuser', 'mail@alexplus.de');
    $sql->insert();
}
