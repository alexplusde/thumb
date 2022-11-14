<?php

if (rex::isBackend() && rex::getUser()) {
    rex_extension::register('ART_UPDATED', ['thumb','ep_art_updated'], rex_extension::LATE);
    // rex_extension::register('ART_META_UPDATED', ['thumb','ep_art_meta_updated'], rex_extension::LATE);
    rex_extension::register('CAT_UPDATED', ['thumb','ep_cat_updated'], rex_extension::LATE);
}
