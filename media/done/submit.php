<?php //TODO implement mysql
//TODO create a media class
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

    $media = new Media(NULL, $_POST['username'], $_POST['title'], $_POST['desc'], $targetFile, $_POST['type']);

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        echo $media->drop();
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["media"]["tmp_name"], $targetFile)) {
            echo $_POST['title'] . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
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