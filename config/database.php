<?php
$dbhost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'vizsga';
//kapcsolat felepitese
$link = @mysqli_connect($dbhost, $dbUser, $dbPass, $dbName) or die('Hiba az adatbazis kapcsolatban! Keresse a rendszer uzemeltetojet: ['.mysqli_connect_error().']');
//kodlap illesztese
mysqli_set_charset($link, "utf8");