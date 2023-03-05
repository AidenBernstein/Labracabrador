<?php 
function head($title) {
    $url = explode("/", $_SERVER['REQUEST_URI']);
    $style = '';
    if(count($url) === 3){
        $style = '';
    }
    echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$title</title>
            <link rel="stylesheet" href="($style)">
        </head>
        <body>
    HTML;
}

head('balls');

function foot() {
    echo <<<HTML
        </body>
        </html>
    HTML;
}

foot();
?>