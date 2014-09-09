<?php

function printStatus($available)
{
    $prefix  = $available ? '' : 'no-';
    $content = $available ? '&#10004;' : '&#10007;';

    print('<span class="'.$prefix.'available">'.$content.'</span>');
}

// function siteIsAvailable($site)
// {
//     $ch = curl_init($site);
//     curl_setopt($ch, CURLOPT_NOBODY, true);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//     curl_exec($ch);
//     $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);

//     return $retcode === 200;
// }

function apcIsEnabled()
{
    return extension_loaded('apc') && ini_get('apc.enabled');
}

function memcacheIsEnabled()
{
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $stats = reset($m->getStats());

    return $stats['uptime'] > 0;
}

function elasticsearchIsEnabled()
{
    try {
        $es = json_decode(file_get_contents("http://localhost:9200"));
        return !empty($es->status) && $es->status === 200;
    } catch (\Exception $e) {
        return false;
    }
}

function mongodbIsEnabled()
{
    try {
        new MongoClient();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}