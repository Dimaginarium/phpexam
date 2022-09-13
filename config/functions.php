<?php
/**
 * @param $fieldName string
 * @param $rowData array
 */

function makeAdminMenu(){
    $adminMenu = '<nav>
        <ul class="main-menu">';
    foreach (ADMIN_MENU as $menuID => $menuItem){
        $adminMenu .= '<li><a class="'.$menuItem['icon'].'" href="?p='.$menuID.'">'.$menuItem['title'].'</a></li>';
    }

    $adminMenu .='</ul></nav>';
    return $adminMenu;
}

function login(){
    global $link;
    $email = mysqli_real_escape_string($link, filter_input(INPUT_POST, 'email'));
    $password = filter_input(INPUT_POST, 'password');

    $qry = "SELECT password, id, name FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($link, $qry) or die(mysqli_error($link));
    $row = mysqli_fetch_row($result);

    //ha van row(azaz talalt email egyezest) akkor password check
    if ($row !== null && password_verify($password, $row[0])){
        $stime = time(); //UNIX timestamp
        $sid = session_id();
        //Munkafolyamat jelszo md5(sid+userID+secretkey)
        $spass = md5($sid . $row[1] . SECRET_KEY);
        $_SESSION['userdata'] = [
            'id' => $row[1],
            'username' => $row[2],
            'email' => $email
        ];
        $_SESSION['id'] = $sid;

        //Takaritas hogy ne legyen beragadt user a belepeskor
        mysqli_query($link, "DELETE FROM sessions WHERE sid = '$sid' LIMIT 1") or die(mysqli_error($link));
        //Taroljuk el a belepest az adatbazisban
        $qry = "INSERT INTO sessions (`sid`,`spass`,`stime`) VALUES('$sid','$spass','$stime')";
        mysqli_query($link, $qry) or die(mysqli_error($link));
        return true;
    }
    return false;
}

/**
Ervenyes belepes ellenorzese
 * @return bool
 */
function auth(){
    global $link;
    $now = time();
    //Tisztitas
    $expired = $now - (60*15); //Lejart munkafolyamatok torlese (most - 15perc)
    mysqli_query($link, "DELETE FROM sessions WHERE stime < $expired") or die(mysqli_error($link));
    //Lekerjuk a sessionhoz tartozo rekordot
    $sid = session_id();
    $qry = "SELECT spass FROM sessions WHERE sid = '$sid' LIMIT 1";
    $result = mysqli_query($link, $qry) or die(mysqli_error($link));
    $row = mysqli_fetch_row($result);

    if ( isset($_SESSION['userdata']['id']) && $row[0] === md5($_SESSION['id'] . $_SESSION['userdata']['id'] . SECRET_KEY)){
        //minden ok, frissitjuk az stime-ot
        mysqli_query($link, "UPDATE sessions SET stime = $now WHERE sid = '$sid' LIMIT 1") or die(mysqli_error($link));
        return true;
    }
    return false;
}

//Logout
function logout(){
    global $link;
    mysqli_query($link, "DELETE FROM sessions WHERE sid = '{$_SESSION['id']}' LIMIT 1") or die(mysqli_error($link));
    $_SESSION = [];
    session_destroy();
}

//Value visszaadasa input mezokbe (parameter atadassal)
function getValue($fieldName, $rowData = []){
    if (filter_input(INPUT_POST, $fieldName) !== null){
        return filter_input(INPUT_POST, $fieldName);
    }
    //ha van DB adat akkor azzal terunk vissza
    if (array_key_exists($fieldName,$rowData)){
        return $rowData[$fieldName];
    }
    return '';
}

//Hiba 'kiiro' eljaras
function getError($fieldName){
    global $errors; //az eljaras idejere globalis, azaz 'latni fogjuk' az eljarason belul

    if (isset($errors[$fieldName])){
        return $errors[$fieldName]; //Visszaterunk hibauzenettel
    }
    return ''; //nincs ilyen elem, visszaterunk ures stringgel
}


function format($n)
{
    return substr($n, 0, 6) . "-" . substr($n, 6, 6) . "-" . substr($n, 12, 6). "-" . substr($n, 18, 6);
}
