<?php            
    require_once('db.php');
    $text = $_POST['text'];
    $user = base64_decode($_COOKIE['user']);
    appendMessage($user, $text);
    require_once('get.php');
?>