<?php

use Alexplusde\Thumb\Thumb;
use Url\Url;
use Url\Seo;

if (rex::isBackend()) {
    /* TODO: Wenn sich ein Artikel oder das Background-Medium ändert, dann entsprechend gecachte Bilder invalidieren */

    rex_extension::register('ART_UPDATED', Thumb::EpArtUpdated(...), rex_extension::LATE);
    // rex_extension::register('ART_META_UPDATED', ['thumb','ep_art_meta_updated'], rex_extension::LATE);
    rex_extension::register('CAT_UPDATED', Thumb::EpCatUpdated(...), rex_extension::LATE);
}

if (rex::isFrontend() && rex_addon::get('url')->isAvailable()) {
    rex_extension::register('URL_SEO_TAGS', Thumb::EpUrlSeoTags(...), rex_extension::LATE);
} else if (rex::isFrontend() && rex_addon::get('yrewrite')->isAvailable()) {

}
