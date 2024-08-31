<?php

namespace App\Support;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CustomUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(string $conversionName = ''): string
    {
        $url = parent::getUrl($conversionName);

        return str_replace('storage/', 'develop-network-task/storage/app/public/', $url);
    }
}
