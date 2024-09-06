<?php

/* Zeige die letzten 50 Bilder aus dem Cache-Ordner mit dem korrekten Mediamanager-Bildprofil */

$dir = rex_path::addonCache('thumb');
$files = scandir($dir, SCANDIR_SORT_DESCENDING);
if($files === false) {
    echo rex_view::error(rex_i18n::msg('thumb_cache_empty'));
    return;
}
$files = array_diff($files, array('..', '.'));
$files = array_slice($files, 0, 50);

/* HTML-Bootstrap 3 Grid erzeugen */
$output = '<div class="row">';
$col = 0;
foreach ($files as $file) {
    $file = rex_media_manager::getUrl($file, 'thumb');
    $output .= '<div class="col-md-2"><img src="' . $file . '"></div>';
    $col++;
    if ($col % 4 == 0) {
        $output .= '</div><div class="row">';
    }
}
$output .= '</div>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', rex_i18n::msg('thumb_history'), false);
$fragment->setVar('body', $output, false);
echo $fragment->parse('core/page/section.php');
