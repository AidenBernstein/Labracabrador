<?php
include('../include/headerFooter.php');
head('Create User');

$script = <<<JS
const validateUser = () => {
    const username = $('username');
    const usernameErr = $('usernameErr');
    let valid = true;
    
    if(username.value === '') {
        usernameErr.innerHTML = ' * User field required';
        valid = false;
    }
    
    if(username.length > 16) {
        usernameErr.innerHTML = ' Username cannot be longer than 16 characters';
        valid = false;
    }
    
    const regex = /\W/g;
    console.log(username.value.replace(regex, ''));
    console.log(username.value);
    console.log(username.value.replace(regex, '') !== username.value);
    if(username.value.replace(regex, '') !== username.value) {          //check if username has any characters that are not a-z, A-Z, or 0-9
        usernameErr.innerHTML = ' Username cannot contain special characters or spaces';
        valid = false;
    }
    
    if(valid) {                                     //removes any error messages if everything is valid
        usernameErr.innerHTML = '';
        document.forms["userCreate"].requestSubmit();
    }
};
JS;

$form = <<<HTML
<h1>Create User</h1>
<form action="./done/create.php" method="post" id="userCreate">
    <p>
    <label for="username">Enter Username (up to 16 characters):&nbsp;</label>
    <input type="text" name="username" id="username">
    <span id="usernameErr" class="error"></span>
    </p>

    <p>
    <label></label>
    <input type="button" value="Submit" onclick="validateUser()">
    </p>
</form>
<script>$script</script>
HTML;

echo $form;

foot();