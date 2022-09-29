<?php

require('vendor/autoload.php');

$url = isset($_GET['url']) ? $_GET['url'] : null;

function send_json($data)
{
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

$video_name = getTitle($url);

    send_json($data)
{
    header('Content-Type: application/json');
    echo $data;
    exit;
}

if (!$url) {
    send_json([
        'error' => 'No URL provided!'
    ]);
}

$youtube = new \YouTube\YouTubeDownloader();

try {
    $links = $youtube->getDownloadLinks($url);

    $first = $links->getFirstCombinedFormat();
	$second = $links->getSecondCombinedFormat();
	$third = $links->getThirdCombinedFormat();

    if ($first) {
        send_json([
            'links' => [$first->url, $second->url, $third->url],
			'name'  => [$video_name]
        ]);
    } else {
        send_json(['error' => 'No links found']);
    }

} catch (\YouTube\Exception\YouTubeException $e) {

    send_json([
        'error' => $e->getMessage()
    ]);
}
