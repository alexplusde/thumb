<?php
class thumb
{
    public function setConfig(?string $key, $value = null) :void
    {
        rex_config::set('thumb', $key, $value);
    }
    public function getConfig(?string $key) :string
    {
        rex_config::get('thumb', $key);
    }

    public static function getImgUrl(?string $slug = null) :string
    {
        return '/?rex-api=thumb&article_id=1&clang_id=0&slug='.rex_string::normalize($slug);
    }
    public static function getImg(?int $article_id, ?int $clang_id = 0)
    {
    }

    public static function getImgFromHtciApi($url)
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
                self::saveImg($body['url'], 'filename.png');
            }
        } catch(rex_socket_exception $e) {
            dump($e->getMessage());
        }
    }

    private static function saveImg($url, $filename) :void
    {
        $image = rex_socket::factoryUrl($url, $filename)->doGet();
        $image->writeBodyTo(rex_path::addonCache('thumb', $filename));
    }
}
