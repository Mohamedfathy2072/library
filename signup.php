<?php 
session_start();
$pagetitle="Sign up";
include "init.php";
$errors=array();
if (isset($_SESSION['user'])) {
    header('location:index.php');//redirect to dashboard if username is exist
exit();
}

?>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
    
<div class="text-center lo">
<div class="login" >
    <div class="form-signin">
        <form acttion="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <img class="mt-2" src="assets/7.jpg" alt="logo" style="border-radius:15px" width="80" height="75">
            <h1 class="h3 m-4 fw-normal" style="color:white">Sign up</h1>

            <div class="form-floating mn-5 mb-3">
            <input type="text" name="user" class="form-control" 
                id="floatingInput" placeholder="name@example.com" auto-complete='off' r>
                <label for="floatingInput">Username</label>
                <?php if (isset($_POST['user'])) {
                if (strlen($user)<4 && $user!="") {
                $errors[]="*name must be more than 4 characters";
                echo "<p class='errorp'> *name must be more than 4 characters</p>";
                }if (empty($_POST['user'])) {
                echo "<p class='errorp' style='top: px;color:#c32222;'> *name can't be empty</p>";
                  $errors[]="*name can't be empty";
                }
            if (checkitem('username','users',$_POST['user'])==1) {
                echo "<p class='errorp' style='top:4px;color:#c32222;'> *This name is exist choose another name</p>";
            }
          
            }  
            ?>                            
            </div>
            <div class="form-floating mn-5 mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" auto-complete='off' r>
            <label for="floatingInput">Email address</label>
            <?php
            if (isset($_POST['email'])){
                
              $femail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
              if (empty($_POST['email'])) {
                  $errors[]="*Please enter the email";
                  echo "<p class='errorp' style='top:4px;color:#c32222;'> *Please enter the email</p>"; 

              } 
              if (filter_var($femail,FILTER_VALIDATE_EMAIL)!=TRUE && $_POST['email']='') {
                $errors[]="*Email is not valid";
                echo "<p class='errorp' style='top:4px;color:#c32222;'> *Email is not valid</p>";                             
              }
            }
              
              ?>     
              </div>
              <div class="form-floating ">
              <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password"  auto-complete='new-password' r>
              <label for="floatingPassword">Password</label>
              <?php if (isset($_POST['password'])){
                if (empty($_POST['password']) && $_POST['password']='d41d8cd98f00b204e9800998ecf8427e') {
                  $errors[]="*Please enter the password";
                  echo "<p class='errorp'> *Please enter the password</p>";  
              }  
          $hashedpass1 = md5($_POST['password']);
            }
              ?>
              </div>
              <div class="form-floating ">
              <input type="password" name="password2" class="form-control" id="floatingPassword" placeholder="Password"  auto-complete='new-password' r>
              <label for="floatingPassword">Valid Password</label>
              <?php if (isset($_POST['password2'])){
                $hashedpass2 = md5($_POST['password2']);
                if (empty($_POST['password2'])) {
                  $errors[]="*Please enter the valid password";
                  echo "<p class='errorp'> *Please enter the valid password</p>";  
              }  
            
            if ($hashedpass2 !== $hashedpass1 && !empty($_POST['password']) && !empty($_POST['password2'])){
                  $errors[]="* password isn't match valid password";
                  echo "<p class='errorp'> *password is not match</p>";   
            }
          }
          
              ?>
              </div>
              <div class="form-floating">
              

              </div>
              <div class="checkbox mb-3">
             
              </div>
              <button class="w-100 btn btn-lg btn-info p-2" type="submit">Sign up</button>
              <p class="mt-5 mb-3 text-muted">&copy; welcome friend </p>
          </form>
      </div>
  </div>
</div>

<?php 
if ($_SERVER['REQUEST_METHOD']=='POST') {
extract($_REQUEST);
if (empty($errors)) {
if (checkitem('username','users',$user)==0) {
$stmt=$conn->prepare('insert into users (username,email,password,status,register_date) values(:username,:email,:password,0,now())');
$stmt->execute(array(
  'username'  => $user,
  'email'      => $femail,
  'password'  => $hashedpass1,
));
$_SESSION['user']=$user;  //register session name
// header('location:index.php');    
// exit();
}
}
}

include $tpl . "fotter.php";
?>



