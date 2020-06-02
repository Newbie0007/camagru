<?php
session_start();
require_once("./config/class.user.php");
$user = new USER();

if($user->is_loggedin() == true)
{
	$user->redirect('./pages/home.php');
}

if(isset($_POST['btn-login']))
{
	$username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    if ($user->is_registered($username) == false)
    {
        $error = "You are not registered. Click sign up to register";
    }
    else if ($user->is_verified($username) == false)
    {   
        $error = "You have not confirm your email yet";
    }
	else if($user->login($username, $password) == true)
	{
        $_SESSION['user_session'] = $username;
		$user->redirect('./pages/home.php');
	}
	else
	{
		$error = "Wrong Details";
	}	
}
?>
<!DOCTYPE HTML>
<html">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="./Javascripts/stylesheet.css" rel="stylesheet" />
    <link rel="shortcut icon" href="media/fonts/fnbtree.png" type="image/png" />
    <title>Camagru_WTC_Register_signin</title>
</head>
<header>
    <div class="header">
        <a href="#default" class="logo">Camagru</a>
        <div class="header-right">
            <a class="active" href="#home">Home</a>
            <a href="./pages/public_gallery.php">Public Gallery</a>
            <a href="#about">About</a>
        </div>
    </div>
</header>
<body>
<div id="container">
    <div class="signin-form">

        <form class="form-signin" method="post" id="login-form">
    
            <h2 class="form-signin-heading">Login to Camagru.</h2><hr />
            
            <div id="error">
                <?php
                    if(isset($error))
                    {
                        ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
            
            <div class="form-group">
                <input type="text" class="form-control" name="username" pattern="\w+" title="This field can only have letters and/or digits" 
                    placeholder="Enter your username" required="true">
            </div>
            
            <div class="form-group">
                <input type="password" class="form-control" name="password" pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*"
                    title="Password must have digits, caps and small letters" placeholder="Enter your Password" required="true" />
            </div>
            <hr />
            
            <div class="form-group">
                <button type="submit" name="btn-login" class="btn btn-default">Login</button>
            </div><br />
            <label>Don't have account yet? <a href="./pages/sign-up.php">Sign Up</a></label>
            <br /><br />
            <label>Forgot your password? <a href="pages/forgot_password.php">click here</a></label>
        </form>
    </div>

</div>
</body>
</html">