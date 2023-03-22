<?php
include('../../include/headerFooter.php');
include('../mediaClass.php');
head('Media Submitted');
?>
<?php
global $tFile;
/**
 * @return array|string|string[]|null
 */
function fileName() {
    return preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['username'] . $_POST['title']); //remove any non-alphanumeric characters
}

function validateUser() {

}

/**
 * @return string
 */
function upload(): string
{
    $target_dir = "../../uploads/";
    $targetFile = $target_dir . fileName() . '.' .pathinfo($_FILES["media"]["name"])['extension'];
    $uploadOk = 1;
    if (file_exists($targetFile)) {
        echo "Media has already been submitted. <br />";
        $uploadOk = 0;
    }

    $user = new user(NULL, $_POST['username']);
    $code = $user->validate($_POST['key']) ? 1 : 0;
    try {
        $media = new Media(NULL, $user, $_POST['title'], $_POST['desc'], $targetFile, $_POST['type']);
        if ($uploadOk == 0) {
            $media->drop(); // if everything is ok, try to upload file
            throw new Exception('<p>Upload Error<br /></p>', 2121);
        } else {
            if (move_uploaded_file($_FILES["media"]["tmp_name"], $targetFile)) {
                echo '<p>' . $_POST['title'] . " has been uploaded.</p>";
            } else {
                throw new Exception('<p>Upload Error<br /></p>', 2122);
            }
        }
    } catch (Exception $e) {
        $message = "<div class='error'><b>ERROR</b><br/>CODE: {$e->getCode()}<br />MESSAGE: {$e->getMessage()}<br />{$e->getTraceAsString()}</div>";
        echo $message;
    }

    return $targetFile;
}

/**
 * @return string
 */
function output(): string
{
    $output = $_POST['username'] . '<br />';
    $output .= $_POST['key'] . '<br />';
    $output .= $_POST['title'] . '<br />';
    $output .= $_POST['desc'] . '<br />';

    return $output;
}

echo "<p>" . output() . "</p>";
$tFile = upload();
?>
<a href = "<?php  echo $tFile;?>">link to media</a>
<?php
foot();
?>