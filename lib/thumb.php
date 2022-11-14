<?php
class thumb
{
    public static function setConfig(?string $key, $value = null) :void
    {
        rex_config::set('thumb', $key, $value);
    }
    public static function getConfig(?string $key) : mixed
    {
        return rex_config::get('thumb', $key);
    }

    public static function getUrl(?string $url) :string
    {
        $file = rex_file::get(rex_path::addonCache('thumb', self::generateFilename($url)));

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

    private static function getImgFromHtciApi(?string $url) :void
    {
        try {
            $socket = rex_socket::factory('hcti.io', 443, true);
            $socket->setPath('/v1/image');
            

            $fragment = new rex_fragment();
            $fragment->setVar('url', $url);
            $fragment->setVar('description', "My Description");

            $data = [];
            $data['html'] = $fragment->parse('thumb/html.php');
            // $data['url'] = $url;
            $data['selector'] = 'main';
            $data['viewport_width'] = 1200;
            $data['viewport_height'] = 600;

            $socket->addBasicAuthorization(self::getConfig('hcti_username'), self::getConfig('hcti_api_key'));
            
            $response = $socket->doPost($data);

            if ($response->isOk()) {
                $body = json_decode($response->getBody(), true);
                self::saveImg($body['url'], $url);
            }
        } catch(rex_socket_exception $e) {
            $e->getMessage();
        }
    }
    private static function getImgFromH2inApi(?string $url) :void
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
            $e->getMessage();
        }
    }
    private static function saveImg($img_url, ?string $url) :void
    {
        $image = rex_socket::factoryUrl($img_url)->doGet();
        $image->writeBodyTo(rex_path::addonCache('thumb', self::generateFilename($url)));
    }
    private static function generateFilename(?string $url, $extension = ".png") :string
    {
        return md5($url).$extension;
    }

    public static function ep_art_updated($ep)
    {
        $params = $ep->getParams();
        // rex_file::delete(rex_path::addonCache('thumb', self::generateFilename($params['article']->getUrl())));
    }
    public static function ep_cat_updated($ep)
    {
        $params = $ep->getParams();
        // rex_file::delete(rex_path::addonCache('thumb', self::generateFilename($params['category']->getUrl())));
    }
}
