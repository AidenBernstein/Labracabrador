<?php //TODO encrypt password with username and put in db
include('../../include/headerFooter.php');
head('User Created');
function keygen($user): string
{
    $id = $user . uniqid();
    $keyArr = preg_split('//u', $id,-1, PREG_SPLIT_NO_EMPTY);

    foreach($keyArr as &$char) {
        $char = chr(((ord($char) + rand(69, 420)) % 93) + 33);
    }

    return implode('', $keyArr);
}

$user = $_POST['username'];
echo $user . '<br />';
echo 'Your account key is: ' . keygen($user);
foot();