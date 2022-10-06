<?php
function lang($word){
static $lang = array(
    //nabar words
    'home'          => 'Home' ,
    'categories'    =>'Categories',
    'setting'       =>'Setting',
    'edit profile'  =>'Edit profile',
    'logout'        =>'Logout',
    'items'         =>'Items',
    'comments'      =>'Comments',
    'members'       =>'Members'  

  

);
    return $lang[$word]; 
}