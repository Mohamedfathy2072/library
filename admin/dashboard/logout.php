<?php
session_start();   //start the session

session_unset();   //unset data 

session_destroy(); //distroy the data
header('location:login.php');
exit();