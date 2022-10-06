<?php 
session_start();
$pagetitle="login";
if (isset($_SESSION['user'])) {
    header('location:index.php');//redirect to dashboard if username is exist
exit();
}
include "init.php";

if ($_SERVER['REQUEST_METHOD']=='POST') {
$user=$_POST['user'];
$pass=$_POST['pass'];
$hashed=md5($pass);

$stmt=$conn->prepare('SELECT username,password from users where username=? and password=?');
$stmt->execute(array($user,$hashed));
$get=$stmt->fetch();
$count=$stmt->rowcount();
// echo $count;
if ($count>0) {
$_SESSION['user']=$user;  //register session name
$_SESSION['userid']=$get['userID'];  //register session id

header('location:index.php');
exit();
}
}
?>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <div class="backlogin">
        <div class="text-center lo">
          
                <div class="login">
                    <div class="form-signin">
                       <form acttion="<?php echo $_SERVER['PHP_SELF'] ?>"method="POST">
                            <img class="mt-4" src="assets/7.jpg" alt="logo" style="border-radius:25px" width="80" height="75">
                            <h1 class="h3 m-4 fw-normal" style="color:white">sign in</h1>

                            <div class="form-floating mn-5 mb-3">
                            <input type="text" name="user" class="form-control" id="floatingInput" placeholder="name@example.com" auto-complete='off'>
                            <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating ">
                            <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password"   auto-complete='new-password'>
                            <label for="floatingPassword">Password</label>
                            </div>

                            <div class="checkbox mb-3">
                            <label style="color:white">
                                <input type="checkbox"  value="remember-me"> Remember me
                            </label>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                            <div class="signuptoggle">
                            <a class="float-start " href="signup.php"style="color:white;">Sign Up</a>
                            </div>
                            <p class="mt-5 mb-3 text-muted">&copy; welcome friend </p>
                        </form>
                    </div>
                </div>
                
                </div>
        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        
        
    
    <?php include $tpl . "fotter.php";?>



