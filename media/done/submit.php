<?php
include('../../include/headerFooter.php');
head('Media Submitted');
global $tFile;
/**
 * @return array|string|string[]|null
 */
function fileName() {
    return preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['username'] . $_POST['title']); //remove any non-alphanumeric characters
}

/**
 * @return string
 */
function upload(): string
{
    $target_dir = "../../uploads/";
    $targetFile = fileName() . '.' . pathinfo($_FILES["media"]["name"])['extension'];
    $tFile = $target_dir . fileName() . '.' . pathinfo($_FILES["media"]["name"])['extension'];
    $uploadOk = 1;
    if (file_exists($tFile)) {
        echo "Media has already been submitted. <br />";
        $uploadOk = 0;
    }

    try {
        $user = new user(NULL, $_POST['username']);
        $valid = $user->validate($_POST['key']);
        if (!$valid){
            echo '<p>Please enter valid user credentials</p>';
            return '';
        }
        $media = new Media(NULL, $user, $_POST['title'], $_POST['desc'], $targetFile, $_POST['type']);
        if ($uploadOk == 0) {
            $media->drop(); // if everything is ok, try to upload file
            throw new Exception('<p>Upload Error<br /></p>', 2121);
        } else {
            if (move_uploaded_file($_FILES["media"]["tmp_name"], $tFile)) {
                echo '<p>' . $_POST['title'] . " has been uploaded.</p>";
            } else {
                throw new Exception('<p>Upload Error<br /></p>', 2122);
            }
        }
    } catch (Exception $e) {
        $message = "<pre class='error'><b>ERROR</b><br/>CODE: {$e->getCode()}<br />MESSAGE: {$e->getMessage()}<br />{$e->getTraceAsString()}</pre>";
        echo $message;
        return '';
    }

    return $tFile;
}

$tFile = upload();
if($tFile) {
    echo "<p>File Upload was successful!</p>";
    echo "<a href = '$tFile'>Link to {$_POST['title']}</a>";
}
foot();