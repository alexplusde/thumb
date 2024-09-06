<?php

use Alexplusde\Thumb\Thumb;
use Url\Url;
use Url\Seo;

if (rex::isBackend()) {
    /* TODO: Wenn sich ein Artikel oder das Background-Medium ändert, oder Metadaten, oder überhaupt, dann entsprechend gecachte Bilder invalidieren */
    rex_extension::register('ART_UPDATED', Thumb::epStructureUpdated(...), rex_extension::LATE);
    rex_extension::register('CAT_UPDATED', Thumb::epStructureUpdated(...), rex_extension::LATE);
}

if (rex::isFrontend() && rex_addon::get('url')->isAvailable()) {
    rex_extension::register('URL_SEO_TAGS', Thumb::EpSeoTags(...), rex_extension::LATE);
} else if (rex::isFrontend() && rex_addon::get('yrewrite')->isAvailable()) {
    rex_extension::register('YREWRITE_SEO_TAGS', Thumb::EpSeoTags(...), rex_extension::LATE);
}
rex_extension::register('YREWRITE_SEO_TAGS', Thumb::EpSeoTags(...), rex_extension::LATE);
