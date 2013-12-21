<?php

    date_default_timezone_set('Europe/Moscow');
    $connection = mysql_connect('localhost','root','') or exit("Error connection with database!");
    //Выбираем базу данных
    $db = mysql_select_db('mysql', $connection) or exit("Error connection with database!");
    mysql_query('SET NAMES utf8_unicode_ci');
       
    function safe_var ($var) //удаление специальных символов и преобразование спец. html-символов
    {
	    return htmlspecialchars(mysql_real_escape_string(trim($var)));
    }
    
    
   function getChatLog($lastId)
    {
        
       $doc = Array('log' => '', 'lastId' => $lastId);
	   $sel_result = mysql_query('SELECT * FROM chat where id>"'.$lastId.'" ORDER BY date ASC, id ASC;');
       while($row =  mysql_fetch_assoc($sel_result)){
           $doc['log'].="<div class='msgln'>[".$row['date']."]<b>".$row['name']."</b>:".$row['message']."<br></div>";
           $doc['lastId']=  $row['id'];
        }
        setcookie("lastId", $doc['lastId']);
        $minId= $doc['lastId']-20;
        mysql_query('DELETE FROM chat where id<"'.$minId.'" and id>580;');
        return $doc['log'];
    }
    
    function appendMessage($user, $text)
    {
        $now_time = date("Y-m-d H:i:s");
        $user = stripslashes(htmlspecialchars($user));
        mysql_query("insert into chat (name, message, date) values ('{$user}','{$text}', '{$now_time}')");
    }
    
?>