<?php
//error reporting
ini_set('display_errors','on');
error_reporting(E_ALL);
$sessionuser='';
if (isset($_SESSION['user'])) {
    $sessionuser=$_SESSION['user'];
}
include 'admin/connect.php';
//templates directory
$tpl="includes/templates/";
//css directory
$css="layout/css/";
//js directory
$js="layout/js/";
//languages directory
$lang="includes/languages/";
//finction directory
$func="includes/functions/";
// ===================================================
//include important files
include $func . "functions.php";
include $lang . "eng.php";
include $tpl . "header.php";

 if (!isset($nonavbar)) {include $tpl . "navbar.php";}


