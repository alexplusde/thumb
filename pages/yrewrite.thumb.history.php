<?php

use Alexplusde\Thumb\Thumb;

$addon = rex_addon::get('thumb');

$func = rex_request('func', 'string');
$csrf = rex_csrf_token::factory('thumb');
if ('' !== $func) {
    if (!$csrf->isValid()) {
        echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
    } else {
        if ('delete' === $func) {
            /* data-Verzeichnis von thumb leeren */
            array_map('unlink', glob(rex_path::addonData('thumb') . '/*'));
            echo rex_view::success(rex_i18n::msg('thumb_data_deleted'));
        }
    }
}
$button = '<a class="btn btn-danger btn-sm pull-right" href="' . rex_url::currentBackendPage(['func' => 'delete'] + $csrf->getUrlParams()) . '" data-confirm="' . rex_i18n::msg('thumb_delete_confirm') . '">' . rex_i18n::msg('thumb_delete') . '</a>';

/* Zeige die letzten 50 Bilder aus dem Data-Ordner mit dem korrekten Mediamanager-Bildprofil */

$dir = rex_path::addonData('thumb');
$files = scandir($dir, SCANDIR_SORT_DESCENDING);
if($files === false) {
    echo rex_view::error(rex_i18n::msg('thumb_data_empty'));
    return;
}
$files = array_diff($files, array('..', '.'));
$files = array_slice($files, 0, 50);

/* HTML-Bootstrap 3 Grid erzeugen */
$output = '<div class="row">';
$col = 0;
$profile = Thumb::getConfig('media_manager_profile', 'string', '');

foreach ($files as $file) {
    if(is_string($profile)) {
        $file = rex_media_manager::getUrl($profile, $file);
        $output .= '<div class="col-md-3"><img src="' . $file . '" class="img-thumbnail"></div>';
        $col++;
        if ($col % 4 === 0) {
            $output .= '</div><div class="row">';
        }
    }
}
$output .= '</div>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', rex_i18n::msg('thumb_history') .$button,  false);
$fragment->setVar('body', $output, false);
echo $fragment->parse('core/page/section.php');
