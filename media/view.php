<?php
include('../include/headerFooter.php');

$params = [];

parse_str($_SERVER['QUERY_STRING'], $params);

try {
    $media = new Media($params['sid']);
    head('"' . $media->title . '"');$root = getRoot();
    echo <<<HTML
    <h1>$media->title [$media->type]</h1>
    <h2>Submitted by {$media->user->userName}</h2>
    <p>{$root}upload/$media->fileName</p>
    <p>Description:</p>
    <code>$media->desc</code>
HTML;
} catch (Exception $e) {
    head('Incorrect SID');
    $message = "<pre class='error'><b>ERROR</b><br/>CODE: {$e->getCode()}<br />MESSAGE: {$e->getMessage()}<br />{$e->getTraceAsString()}</pre>";
    echo $message;
} finally {
    foot();
}