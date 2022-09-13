<?php
include_once "../config/database.php";
include_once "../config/functions.php";
include_once "../config/settings.php";

/** @var $link mysqli
 */


if (!empty($_POST)) {
    $errors = [];

    $name = strip_tags(filter_input(INPUT_POST, 'name'));
    $name = trim($name);
    if (mb_strlen($name, 'utf-8') < 3) {
        $errors['name'] = '<span class="error">At least 3 characters!</span>';
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $errors['email'] = '<span class="error">Invalid format!</span>';
    }else{

        $qry = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($link,$qry) or die(mysqli_error($link));
        $row = mysqli_fetch_row($result);
//        var_dump($row);
        if ($row !== null){
            $errors['email'] = '<span class="error">E-mail already in use!</span>';
        }
    }


    $password = filter_input(INPUT_POST,'password');
    $repassword = filter_input(INPUT_POST,'repassword');

    if (mb_strlen($password) < 6){
        $errors['password'] = '<span class="error">At least 6 characters!</span>';
    }elseif($password !== $repassword){
        $errors['repassword'] = '<span class="error">Password do not match!</span>';
    }else{

        $password = password_hash($password,PASSWORD_BCRYPT);
    }

    if (empty($errors)) {

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];
        $data['time_created'] = date('Y-m-d H:i:s');
        $qry = "INSERT INTO 
                users(
                       `name`,
                       `email`,
                       `password`,
                       `time_created`
                       )
                VALUES(
                       '{$data['name']}',
                       '{$data['email']}',
                       '{$data['password']}',
                       '{$data['time_created']}'
                       )";

        mysqli_query($link,$qry) or die(mysqli_error($link));
        echo '<script>alert("Please log in with your account!"); window.location.href = "index.php"; </script>';
        exit();
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
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <img class="logo" src="img/logo.png" alt="logo">
<div class="content">
    <?php $form ='<form method="post"> <h2>REGISTER</h2>';
        $form .= '<label><span>Name:</span>';
        $form .= '<input type="text" name="name" value="' . getValue('name') . '"placeholder="John Doe">';
        $form .= getError('name');
        $form .= '</label> <br>';

        $form .= '<label><span>E-mail:<sup>*</sup></span>';
        $form .= ' <input type="text" name="email" value="' . getValue('email') . '"placeholder="email@email.com">';
        $form .= getError('email');
        $form .= '</label> <br>';

        $form .= '<label><span>Password:<sup>*</sup></span>';
        $form .= '<input type="password" name="password" placeholder="******" value="">';
        $form .= getError('password');
        $form .= '</label> <br>';

        $form .= '<label><span>Password again:<sup>*</sup></span>';
        $form .= '<input type="password" name="repassword" placeholder="******" value="">';
        $form .= getError('repassword');
        $form .= '</label> <br>';

        $form .= '<div class="center"><button>Register</button></div>';
        $form .= '</form>';
        echo $form;
    ?>
</div>
</div>
</body>
</html>