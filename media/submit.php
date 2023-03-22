<!--
This page uses: information from chapter 1 (php tag) and chapter 5 (include())
-->
<?php
include('../include/headerFooter.php');
head('Submit Content');
?>

<h1>Submit Media</h1>
<form action="./done/submit.php" enctype="multipart/form-data" method="post" id="submission">
    <p>
    <label for="username">Username:&nbsp;</label>
    <input type="text" name="username" id="username">
    <span class="error" id="usernameErr"></span>
    </p>

    <p>
    <label for="key">Key:&nbsp;</label>
    <input type="password" name="key" id="key">
    <span class="error" id="keyErr"></span>
    </p>

    <p>
    <label for="title">Media Title:&nbsp;</label>
    <input type="text" name="title" id="title">
    <span class="error" id="titleErr"></span>
    </p>

    <p>
    <label for="desc">Media Description:&nbsp;</label>
    <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
    <span class="error" id="descErr"></span>
    </p>

    <p>
    <label for="media">Media Upload:&nbsp;</label>
    <input type="file" name="media" id="media">
    <span class="error" id="mediaErr"></span>
    </p>

    <p>
    <label></label>
    <input type="button" value="submit" id="Submit" onclick="pressSubmit()">
    </p>

    <input type="hidden" id="type" name="type" value="">
</form>
<div id="filetype"></div>
<script src="/media/submit.js"></script> <!--Place the script tag at the end of file so that it will only load once everything else has loaded-->
<?php
foot();
?>