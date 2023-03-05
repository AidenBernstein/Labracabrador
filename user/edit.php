<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="./done/edit.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"><br />

        <label for="key">Key:</label>
        <input type="text" name="key" id="key"><br />

        <label for="uid">UID to delete:</label>
        <input type="text" name="uid" id="uid"><br />

        <label for="level">Select new level:</label>
        <select name="level" id="level">
            <option value="0">Level Zero: Blocked</option>
            <option value="1">Level One: Regular</option>
            <option value="2">Level Two: Moderator</option>
            <option value="3">Level Three: Admin</option>
        </select> 

        <input type="submit" value="Update">
    </form>
</body>
</html>