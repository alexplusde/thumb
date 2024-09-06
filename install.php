<?php

if (!rex_media::get('thumb_bg.png')) {
    /* Neue Methode addMedia() verwenden */
    return rex_media_service::addMedia([
        'category_id' => 0,
        'title' => "Thumb-Addon: Hintergrund-Vorlage",
        'createuser' => 'thumb',
        'file' => ['name' => "thumb_bg.png",
            'path' => rex_path::addon('thumb', '/media/thumb_bg.png')]]);
}
