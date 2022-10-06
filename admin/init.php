<?php
include 'connect.php';
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


