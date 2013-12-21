<?php
header('Content-Type: text/html; charset=utf-8');
require_once('db.php');
	pageLoad();
	
	function pageLoad(){
		
		if(isset($_POST['logout']))
		{
			appendMessage(base64_decode($_COOKIE['user']), "has left");
			setcookie("user", "", time() + 3600*24,'/');
			setcookie("lastId", 0, time() + 3600*24,'/');
			header('Location: '.$_SERVER['PHP_SELF']); 
		}
		else
		{
			$burnmf = false;
		
			if(isset($_POST['name']) && $_POST['name'] != "")
			{
				$name = stripslashes(htmlspecialchars($_POST['name']));
				$burnmf = true;
			}
			else
				{
					if(base64_decode($_COOKIE['user']) != "")
					{
						$name = base64_decode($_COOKIE['user']);
						$burnmf = true;
					}
					else
					{
						loginForm();
					}
				}
		}
			if($burnmf){
				setcookie('user', base64_encode($name), time() + 3600*24,'/');
				setcookie('lastId', 0, time() + 3600*24,'/');
				appendMessage($name, "has entered");
				
				pageBody($name);
			}
		
		
	}
	
function loginForm(){
    //setcookie('user', '');
	echo'
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <title>Chat - Login</title>
        <link type="text/css" rel="stylesheet" href="style.css"
        />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap-theme.min.css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>-->
        <script type="text/javascript" src="chat.js"></script>
    </head>
	<div class="panel panel-default" id="loginform">
	<form action="index.php" method="post" id="loginf">
	    <div class="panel-heading">
		    <p>Please enter your name to continue:</p>
		</div>
		    <label for="name">Name:</label>
		    <div class="input-group">
		    
		    <input type="text" class="form-control" name="name" id="name"/>
		    <span class="input-group-btn">
		    <input class="btn btn-info" type="submit" name="enter" id="enter" value="Enter"/>
		     </span>
		</div>
	</form>
	</div>
	';
}

	function pageBody($username){
	echo '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <title>Chat - Customer Module</title>
        <link type="text/css" rel="stylesheet" href="style.css"
        />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap-theme.min.css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>-->
        <script type="text/javascript" src="chat.js"></script>
    </head>
    
    <body>
        <div id="wrapper">
            <div id="menu">
                <div class="input-group" id="ig1">
                    <h4>
                        <span class="label label-primary" id="welcome">Welcome to WinterChat,
                            <b>
                                '.$username.'
                            </b>
                        </span>
                    </h4>
                    <span class="input-group-btn">
                        <form action="index.php" method="post" id="exitform">
                            <input type="hidden" class="form-control" name="logout" id="logout" />
                            <!--<input type="text" class="form-control" name="logout" id="logout"
                            value="true"/>-->
                            <p class="logout">
                                <input class="btn btn-primary btn-sm" type="submit" name="exit" id="exit"
                                value="Exit" />
                            </p>
                        </form>
                    </span>
                </div>
                <!-- /input-group -->
            </div>
            <div id="chatbox"></div>
            <div class="input-group">
                <input name="usermsg" type="text" class="form-control" id="usermsg" />
                <span class="input-group-btn">
                    <button name="submitmsg" class="btn btn-info" id="submitmsg" type="button">Send</button>
                </span>
            </div>
            <!-- /input-group -->
        </div>
        <!-- div id="wrapper" -->
         
    </body>
</html>
	';
	}
    
