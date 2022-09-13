<?php
include_once "../config/database.php";
include_once "../config/functions.php";
include_once "../config/settings.php";

/** @var $link mysqli
 */

session_start();

$action = filter_input(INPUT_GET, 'action');

if (filter_input(INPUT_GET, 'logout') !== null){
    logout();
}

$auth = auth();
if (!$auth){
    header("location:index.php");
    exit();
}
$success = '';
$code ='';
if (!empty($_POST)) {

    $errors = [];

    $code1 = filter_input(INPUT_POST, 'code1');
    $code2 = filter_input(INPUT_POST, 'code2');
    $code3 = filter_input(INPUT_POST, 'code3');
    $code4 = filter_input(INPUT_POST, 'code4');

    $code = filter_input(INPUT_POST, 'code1');
    $code .= filter_input(INPUT_POST, 'code2');
    $code .= filter_input(INPUT_POST, 'code3');
    $code .= filter_input(INPUT_POST, 'code4');
//    echo $code;
    if (strlen($code) <> 24 || strlen($code1) < 6 || strlen($code2) < 6 || strlen($code3) < 6 || strlen($code4) < 6) {
        $errors['newcode'] = '<span class="error">Invalid code format!</span>';
    }
    if (preg_match('/[^A-Za-z0-9]/', $code))
    {
        $errors ['characters'] = '<span class="error">Invalid character in code!</span>';
    }

    $qry = "SELECT code FROM codes WHERE code = '$code'";
    $result = mysqli_query($link, $qry) or die(mysqli_error($link));
    $dupes = mysqli_fetch_row($result);

    if ($dupes !== null){
        $errors['duplicate'] = '<span class="error">This code has already been used!</span>';
    }

    if (empty($errors)) {
        $data = [
            'user_id' => $_SESSION['userdata']['id'],
            'code' => $code
        ];
        $data['time_uploaded'] = date('Y-m-d H:i:s');

        if ($code!==null){

            $qry = "INSERT INTO
                codes(
                       `user_id`,
                       `code`,
                       `time_uploaded`
                       )
                VALUES(
                       '{$data['user_id']}',
                       '".strtoupper($data['code'])."',
                       '{$data['time_uploaded']}'
                       )";
            mysqli_query($link, $qry) or die(mysqli_error($link));
            echo '<script>alert("Upload Successful!"); window.location = self.location; </script>';
//
        }
    }
}

$qry = "SELECT user_id, code, time_uploaded FROM codes ORDER BY time_uploaded";
$result = mysqli_query($link, $qry) or die(mysqli_error($link));


$table = "<table><tr>
                <th>Code</th>
                <th>Time of Upload</th>
            </tr>";
while ($row = mysqli_fetch_row($result)){
    if ($row[0] == $_SESSION['userdata']['id']){
        $table .= "<tr>
                <td>".format("$row[1]")."</td>
                <td>$row[2]</td>
</tr>";
    }
}

$table .="</table>";

?>


<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code Dropper Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <img class="logo" src="img/logo.png" alt="logo">
<div class="content">
    <form method="post">
        <h2>DASHBOARD</h2>
        <h4>Welcome, <?php echo $_SESSION['userdata']['username']?>! <a href="?logout">[Logout]</a></h4>
        <label>
            <span>Upload Your Code</span>
            <br>
            <input class="codeInput" type="text" name="code1" value="<?php echo getValue('code1'); ?>" placeholder="ABCDEF"> -
            <input class="codeInput" type="text" name="code2" value="<?php echo getValue('code2'); ?>" placeholder="AB12EF"> -
            <input class="codeInput" type="text" name="code3" value="<?php echo getValue('code3'); ?>" placeholder="55CDEF"> -
            <input class="codeInput" type="text" name="code4" value="<?php echo getValue('code4'); ?>" placeholder="FGGSRD">
        </label>
        <br>
        <?php echo getError('newcode');
                echo getError('characters');
                echo getError('usedcode');
                echo getError('duplicate');
                echo $success;?>
        <br>
        <div class="center">
            <button>Send In</button>
        </div>
        <hr>
        <span>Codes Already in Use</span>
        <?php echo $table; ?>

    </form>
</div>
</div>
</body>
</html>