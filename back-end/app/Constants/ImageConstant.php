<?php

namespace App\Constants;

class ImageConstant
{

    public static function getStoragePath($id)
    {
        return "public/manga/$id/thumb.png";
    }
}
