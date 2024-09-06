<?php

namespace Alexplusde\Thumb;

use rex_config;
use rex_file;
use rex_fragment;
use rex_socket;
use rex_url;
use rex_socket_exception;
use rex_path;

use Url\Url;

class Thumb
{

    const WIDTH = 1200;
    const HEIGHT = 630;

    public static function setConfig(?string $key, $value = null) :void
    {
        rex_config::set('thumb', $key, $value);
    }
    public static function getConfig(?string $key) : mixed
    {
        return rex_config::get('thumb', $key);
    }

    public static function getThumbUrl(?string $url) :string
    {
        $file = rex_file::get(rex_path::addonData('thumb', self::generateFilename($url)));

        if (null === $file) {
            if (self::getConfig('api') == "hcti") {
                self::getImgFromHtciApi($url);
            } elseif (self::getConfig('api') == "h2in") {
                self::getImgFromH2inApi($url);
            }
        }
        $frontend_url = rex_url::media(self::getConfig('media_manager_profile').'/'.self::generateFilename($url));

        return $frontend_url;
    }

    private static function getImgFromHtciApi(string $source_url, string $html = '') :string
    {
        try {
            $socket = rex_socket::factory('hcti.io', 443, true);
            $socket->setPath('/v1/image');
            
            $data = [];
            $data['html'] = $html;
            $data['selector'] = 'main';
            $data['viewport_width'] = self::WIDTH;
            $data['viewport_height'] = self::HEIGHT;

            $socket->addBasicAuthorization(self::getConfig('hcti_username'), self::getConfig('hcti_api_key'));
            
            $response = $socket->doPost($data);

            if ($response->isOk()) {
                $body = json_decode($response->getBody(), true);    
                self::saveImg($body['url'], $source_url);
                return self::getThumbUrl($source_url);
            }
        } catch(rex_socket_exception $e) {
            $e->getMessage();
        }
        return '';
    }
    private static function getImgFromH2inApi(string $source_url, string $html = '') :string
    {
        try {
            $socket = rex_socket::factory('www.html2image.net/', 443, true);
            $socket->setPath('/api/api.php?key='.self::getConfig('h2in_api_key').'&source='.$source_url.'&type=png&width='.self::WIDTH.'&height='.self::HEIGHT);
            
            $response = $socket->doGet();

            if ($response->isOk()) {
                $body = $response->getBody();
                self::saveImg($body['url'], rex_path::addonData('thumb', self::generateFilename($source_url)));
                return self::getThumbUrl($source_url);
            }
        } catch(rex_socket_exception $e) {
            $e->getMessage();
        }
        return '';
    }

    private static function getImgFromApi(string $content = '', string $url) :string {
        /* Existiert das Bild bereits? */

        if (rex_file::get(rex_path::addonData('thumb', self::generateFilename($url)))) {
            return self::getThumbUrl($url);
        }
        if(self::getConfig('api') == "hcti") {
            return self::getImgFromHtciApi($url, $content);
        } elseif(self::getConfig('api') == "h2in") {
            return self::getImgFromH2inApi($url, $content);
        }
        return '';
    }

    private static function saveImg($img_url, string $frontend_url) :void
    {
        $image = rex_socket::factoryUrl($img_url)->doGet();
        $image->writeBodyTo(rex_path::addonData('thumb', self::generateFilename($frontend_url)));
    }

    private static function generateFilename(?string $url, $extension = ".png") :string
    {
        return md5($url).$extension;
    }

    public static function epArtUpdated($ep)
    {
        $params = $ep->getParams();
        // rex_file::delete(rex_path::addonData('thumb', self::generateFilename($params['article']->getUrl())));
    }
    public static function epCatUpdated($ep)
    {
        $params = $ep->getParams();
        // rex_file::deleteEpUrlSeoTagsddonData('thumb', self::generateFilename($params['category']->getUrl())));
    }
    public static function EpSeoTags($ep)
    {
        /* Zum Debuggen: OutputFilter leeren / flushen, um dump() sehen zu können */
        // ob_end_clean();

        /* Grundvoraussetzungen */
        $article = \rex_article::getCurrent();
        $domain = \rex_yrewrite::getDomainByArticleId($article->getId());
        $website = $domain->getTitle();
        $fragment = new rex_fragment();
        $tags = $ep->getSubject();
        $title = strip_tags($tags['title']);
        $description = $article->getValue('yrewrite_description');
        $image = $article->getValue('yrewrite_image');
        $media = null;
        if($image) {
            $media = \rex_media::get($image);
        }

        $background_image = self::getConfig('background_image');
        $background_media = null;
        if ($background_image) {
            $background_media = \rex_media::get($background_image);
        }

        /* URL-Addon übertrumpft YRewrite */
        $manager = Url::resolveCurrent();
        if ($manager) {
            // $seo = $manager->getSeo();

            if ($manager->getSeoTitle()) {
                $title = $manager->getSeoTitle();
            }

            if($manager->getSeoDescription()) {
                $description = $manager->getSeoDescription();
            }
        }

        $result = '';
        $fragment->setVar('title', $title, false);
        $fragment->setVar('description', $description, false);
        $fragment->setVar('url', $manager->getValue('url'), false);

        if($media) {
            $fragment->setVar('image', $media->getUrl(), false);
        }
        if($background_media) {
            $fragment->setVar('background_image', $background_media->getUrl(), false);
        }
        $fragment->setVar('website', $website, false);
        if(self::getConfig('fragment')) {
            $result = $fragment->parse(self::getConfig('fragment'));
        }

        $og_image_url = self::getImgFromApi($result, $manager->getValue('url'));

        $tags['og:image'] = '<meta property="og:image" content="'.$og_image_url.'" />';
        $tags['og:image:width'] = '<meta property="og:image:width" content="'.self::WIDTH.'" />';
        $tags['og:image:height'] = '<meta property="og:image:height" content="'.self::HEIGHT.'" />';

        $ep->setSubject($tags);

    }
}
