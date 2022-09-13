<?php
include_once "../config/database.php";
include_once "../config/functions.php";
include_once "../config/settings.php";


session_start();

$info = '';
if (!empty($_POST)){
    if (login()){
        header('location:dashboard.php');
        exit();
    } else {
        $info = '<span class="error">Incorrect e-mail or password!</span>';
    }
}
?>


<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code Dropper Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<!--<h1>Code-Dropper LOGO HERE</h1>-->
    <img class="logo" src="img/logo.png" alt="logo">
<div class="content">
    <form method="post">
        <h2>LOGIN</h2>

        <label>
            <span>E-mail</span>
            <br>
            <input type="text" name="email" value="<?php echo getValue('email'); ?>" placeholder="email@email.com">
        </label>
        <br>
        <label>
            <span>Password</span>
            <br>
            <input type="password" name="password" value="" placeholder="******">
        </label>
        <?php echo $info; ?>
        <br>
        <div class="center">
            <button>Login</button>
            <br>
            <div class="new">
                <span>Not registered yet?</span><br>
                <a href="register.php">Create a new account</a>
            </div>
        </div>

    </form>
</div>
</div>
</body>
</html>