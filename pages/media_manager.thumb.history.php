<?php

/* Zeige die letzten 50 Bilder aus dem Data-Ordner mit dem korrekten Mediamanager-Bildprofil */

use Alexplusde\Thumb\Thumb;

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
foreach ($files as $file) {
    $profile = \Alexplusde\Thumb\Thumb::getConfig('media_manager_profile');
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
$fragment->setVar('title', rex_i18n::msg('thumb_history'), false);
$fragment->setVar('body', $output, false);
echo $fragment->parse('core/page/section.php');
