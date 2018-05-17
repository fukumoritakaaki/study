<?php

$url = 'https://no1s.biz/';
$scr = new UrlScraper;
print_r($scr->parseLinks(file_get_contents($url), $url));

class UrlScraper {

    public static function parseLinks($html, $base_href = '') {
        $array = array();
        $regex = '@<a[^>]*?(?<!\.)href="([^"]*+)"[^>]*+>(.*?)</a>@si';
        if (!preg_match_all($regex, $html, $matches, PREG_SET_ORDER)) {
            return $array;
        }
        foreach ($matches as $match) {
            if(strpos($match[1],'https://no1s.biz/') !== false){
                $match[2] = strip_tags($match[2]);
                $match[2] = trim($match[2]);
                echo $match[1] . '　' . $match[2] . PHP_EOL;
            }
        }
    }
}

?>