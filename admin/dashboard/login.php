<?php
session_start();
$nonavbar='';
$pagetitle='Login';
if (isset($_SESSION['user'])) {
    header('location:dashboard.php');//redirect to dashboard if username is exist
exit();
}
include "../init.php";

if ($_SERVER['REQUEST_METHOD']=='POST') {
$username=$_POST['user'];
$pass=$_POST['pass'];
$hashed=md5($pass);

$stmt=$conn->prepare('SELECT userID,username,password from users where username=? and password=? and status=1 limit 1');
$stmt->execute(array($username,$pass));
$row=$stmt->fetch();
$count=$stmt->rowcount();
// echo $count;
if ($count>0) {
$_SESSION['id']=$row['userID'];  //register session id
$_SESSION['user']=$username;  //register session name
header('location:dashboard.php');
exit();
}
}
// <i class="fal fa-lock fa-fw fa-xl margin-right-md fa-spin" style="color:white; --fa-animation-duration:2s;"></i>
?>
<div class="background">
 <div class="mydiv">
        <h1 class="h " style="text-align: center;color:white;margin-left: 27px;">login   <i class="fal fa-solid fa-lock fa-fw fa-xl margin-lef4-md fa-spin ss " ></i></h1>

<form class="myForm" acttion="<?php echo $_SERVER['PHP_SELF'] ?>"method="POST">  
    <div  style="text-align: center;">
            <i class="fa-solid fa-user-lock" style="color:#b9e1ef;width=100px;height:100px;"></i>
        </div>
        <p class="color" style="text-align: center;">this is form to login</p>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label color">Username</label>
            <input type="text" name="user"style="color:white" placeholder="enter your username !" autocomplete="off" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text color">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label color">Password</label>
            <input type="password" style="color:white"  name="pass" placeholder="enter your password !" autocomplete="new-password" class="form-control " id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check ">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label color " for="exampleCheck1">Check me out</label>
        </div>
        <div class="mb-3 form-check ">
                <button type="submit" class="btn btn-primary   mybutton " value="login" dir="ltr">login</button>
        </div>

</form>
 </div>
 </div>
<?php
include "../" . $tpl . "fotter.php";
?>