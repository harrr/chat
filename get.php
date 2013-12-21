<?php
    require_once('db.php');
    $last = $_POST['last'];
    //$last = 370;
    $chatLogData = getChatLog($last);
    //echo $chatLogData;
     //echo json_encode($chatLogData);
    if($chatLogData!="")
    {
        $messageCode = $chatLogData;
        $lastId=$chatLogData['lastId'];
    }
    $data=array('messageCode' => isset($messageCode) ? $messageCode : "", 'lastId' => isset($last) ? $last : 0);
    echo json_encode($data);
?>