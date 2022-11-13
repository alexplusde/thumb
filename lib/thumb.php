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

    public static function getImg()
    {
    }

    public static function getImgFromHtciApi()
    {
    }

    private function saveImg() :void
    {
    }
}
