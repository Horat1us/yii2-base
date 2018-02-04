<?php

namespace Horat1us\Yii\Helpers;

/**
 * Class UrlHelper
 * @package Horat1us\Yii\Helpers
 */
class UrlHelper
{
    public static function append(string $url, array $params = []): string
    {
        $parts = parse_url($url);
        parse_str($parts['query'] ?? '', $existParams);

        $mergedParams = array_merge($existParams, $params);
        $parts['query'] = http_build_query($mergedParams);

        return function_exists('http_build_url')
            ? http_build_url($parts)
            : ($parts['scheme'] ?? 'http') . '://' . ($parts['host'] ?? 'localhost') . ($parts['path'] ?? '') . '?' . $parts['query'];

    }
}
