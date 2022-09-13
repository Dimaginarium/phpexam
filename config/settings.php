<?php
//Altalanos beallitasok

const SECRET_KEY = 'wauedgcziasc134'; //titkosito kulcs

//Admin modulok mappaja es kiterjesztese
const MODULES_DIR = 'modules/';
const MODULE_EXT = '.php';

//Admin menu
const ADMIN_MENU = [
    0 => [
        'title' => 'Vezerlopult',
        'icon' => 'fab fa-dashboard',
        'module' => 'dashboard'
    ],
    1 => [
        'title' => 'Adminisztratorok',
        'icon' => 'fab fa-user',
        'module' => 'admins'
    ],
];