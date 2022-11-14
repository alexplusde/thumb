<?php

if (null === rex_file::get(rex_path::media('thumb_bg.png'))) {
    rex_file::copy(rex_path::addon('thumb', '/media/thumb_bg.png'), rex_path::media('thumb_bg.png'));
    rex_mediapool_syncFile("thumb_bg.png", null, "Hintergrundbild", null, null, "thumb");
}
