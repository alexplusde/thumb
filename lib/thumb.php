<?php
class thumb
{
    public static function setConfig(?string $key, $value = null) :void
    {
        rex_config::set('thumb', $key, $value);
    }
    public static function getConfig(?string $key) :string
    {
        return rex_config::get('thumb', $key);
    }

    public static function getImgUrl($url)
    {
        $file = rex_file::get(rex_path::addonData('thumb', self::generateFilename($url)));
        if (null === $file) {
            if (self::getConfig('api') == "htci") {
                self::getImgFromHtciApi($url);
            } elseif (self::getConfig('api') == "h2in") {
                self::getImgFromH2inApi($url);
            }
        }

        return rex_url::media(self::getConfig('media_manager_profile').'/'.self::generateFilename($url));
    }

    private static function getImgFromHtciApi($url)
    {
        try {
            $socket = rex_socket::factory('hcti.io', 443, true);
            $socket->setPath('/v1/image');
            
            $data = [];
            $data['url'] = $url;
            $data['selector'] = 'main';
            $data['viewport_width'] = 1200;
            $data['viewport_height'] = 600;
            
            $response = $socket->doPost($data);

            if ($response->isOk()) {
                $body = $response->getBody();
                self::saveImg($body['url']);
            }
        } catch(rex_socket_exception $e) {
            dump($e->getMessage());
        }
    }
    private static function getImgFromH2inApi($url)
    {
        try {
            $socket = rex_socket::factory('www.html2image.net/', 443, true);
            $socket->setPath('/api/api.php?key='.self::getConfig('h2in_api_key').'&source='.$url.'&type=png&width=1200&height=600');
            
            $response = $socket->doGet();

            if ($response->isOk()) {
                $body = $response->getBody();
                self::saveImg($body['url']);
            }
        } catch(rex_socket_exception $e) {
            dump($e->getMessage());
        }
    }
    private static function saveImg($url) :void
    {
        $image = rex_socket::factoryUrl($url)->doGet();
        $image->writeBodyTo(rex_path::addonCache('thumb', self::generateFilename($url)));
    }
    private static function generateFilename(?string $url) :string
    {
        return md5($url);
    }
}
