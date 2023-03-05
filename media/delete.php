<?php
include('../include/headerFooter.php');
head('Media Submitted');
?>

<h1></h1>
<form action="./done/delete.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username"><br />

    <label for="key">Key:</label>
    <input type="text" name="key" id="key"><br />

    <label for="sid">SID to delete:</label>
    <input type="text" name="sid" id="sid"><br />

    <input type="submit" value="Delete">
</form>

<?php
foot();
?>