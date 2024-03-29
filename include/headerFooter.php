<?php
//I use JS with this code to have a responsive header
//chapter 3: file(), implode()
//chapter 5: functions


include('./mediaClass.php');
include('./user/userClass.php');

/*return the location of the 'root/' folder
 * @return string
 */
function getRoot(): string
{
    $url = explode("/", $_SERVER['REQUEST_URI']);
    $root = '';
    switch($url[count($url)- 2]) {
        case 'media':
        case 'user':
        case 'include':
            $root = '../';
            break;

        case 'done':
            $root = '../../';
            break;

        case '':
            $root = './';
            break;

        default:
            echo 'Error: issue in URL, unable to find root';
            break;
    }
    return $root;
}

/*return the contents of the /include/punList.txt' file, there is probably a more elegant way of doing this
 * @return string
 */
function punArray(): string
{
    $punList = $_SERVER['DOCUMENT_ROOT'] . '/include/punList.txt';
    $punArray = file($punList);
    return implode('', $punArray);
}

/*echo the site's header
 * @return void
 */
function head($title) {
    $punArray = 'punArray';
    $getRoot = 'getRoot';
    /** @noinspection SpellCheckingInspection */
    $headjs = <<<JS
    /*helper function
    $(str id): elementObj
    */
    const $ = (id) => {
        return document.getElementById(id);
    };
    
    /*Picks a random pun from /include/punList.txt
    randomPun(): str    
     */
    const randomPun = () => {
        const punArray = `{$punArray()}`.split('\\n');
        return punArray[Math.floor(Math.random() * punArray.length)];
    };
    
    /*Change the pun in the header
    radnomPun(): void
     */
    const changePun = () => {
        $('pun').innerHTML = randomPun();
    };
    
    /*Display the full form of #info
    infoFull(): void
     */
    const infoFull = () => {
        const info = $('info');
        const leftcol = info.appendChild(document.createElement('a'));
        const leftcolLogo = leftcol.appendChild(document.createElement('img'));
        const rightcol = info.appendChild(document.createElement('div'));
        const rightcolLab = rightcol.appendChild(document.createElement('div'));
        const rightcolPun = rightcol.appendChild(document.createElement('div'));
        
        rightcol.append($('nav'));
        leftcolLogo.src = '{$getRoot()}include/logo-big.png';
        leftcolLogo.className = 'smallImg';
        leftcol.href = '{$getRoot()}index.php';
        
        leftcol.classList.add('column', 'left');
        rightcol.classList.add('column', 'right');
        
        rightcolLab.innerHTML = 'Labracabrador: $title';
        rightcolPun.innerHTML = randomPun();
        
        rightcolPun.id = 'pun';
        rightcol.onclick = changePun;
    };
    
    infoFull()
    JS;

    $root = getRoot();
    echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$title</title>
            <link rel="stylesheet" href="{$root}include/style.css">
            <link rel="icon" type="image/x-icon" href="{$root}include/logo.ico">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300&display=swap" rel="stylesheet">
        </head>
        <body>
        <header id="header" style="width: 100%; flex-direction: column;"> <!--it took me so long to figure out the flex direction. Please look at these 14 character and praise them -->
            <div id="info" style="display: block; width: 100%;"></div> <!--Style is needed to make the header actually show up, and I don't think I want this to apply to the whole site-->
            <nav id="nav" style="display: block;">
                <a href="{$root}media/gallery.php">Media Gallery</a>
                <strong>•</strong>
                <a href="{$root}media/submit.php">Submit Media</a>
                <strong>•</strong>
                <a href="{$root}user/create.php">Create User</a>
            </nav>
        </header>
        <script>$headjs</script>
        <main>
    HTML;
}

/*echo the site's footer
 * @return void
 */
function foot() {
    /** @noinspection HtmlUnknownAnchorTarget */
    echo <<<HTML
        </main>
        <footer>
            <p>Labracabrador: as magical as a magician's dog</p>
            <br />
            <a href="mailto:abernstein@live.seminolestate.edu">Contact the creator of the website, and they might get back to you!</a>
            <br />
            <a href="#info">Back to the top</a>
        </footer>
        </body>
        </html>
    HTML;
}

/*return connection to db
 * @return mysqli
 */
function connectDB(): mysqli {
    $db = new mysqli('localhost', 'labPHP', 'securePassword', 'labracabrador');
    $db->select_db('labracabrador');
    return @$db;
}