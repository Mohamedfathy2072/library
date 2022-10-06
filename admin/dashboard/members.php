<?php
ob_start();
session_start();
$pagetitle="Dashboard";
if ($_SESSION['user']) {
      include "../init.php";
    
$do=isset($_GET['do'])?$_GET['do']:'manage';
if ($do=='manage') {
  /*manage page*/
   // fetch date from database
        $stmt=$conn->prepare('SELECT * from users where status!=1 and approve=1  order by userID desc ');
        $stmt->execute();
        //fetch date in array
        $rows=$stmt->fetchall();
  ?>
  <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title text-center"> Users page </h3>
            <nav aria-label="breadcrumb">
              
            </nav>
          </div>
  
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Accessed Users</h4>
                  
                  <div class="table-responsive">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th>Profile</th>
                          <th>email</th>
                          <th>Created at</th>
                          <th>Full name</th>
                          <th>Control</th>
                        </tr>
                      </thead>
                    
                      <tbody>
                          <?php
                      foreach ($rows as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row['username']?></td>
                          <td><?php echo $row['email']?></td>
                          <td><?php echo $row['register_date']?></td>
                          <td><?php echo $row['fullname']?></td>

                          <td>
                            <a href="?do=edit&userid=<?php echo $row['userID'] ?>" class="btn btn-primary">Edit</a>
                            <a href="?do=delete&userid=<?php echo $row['userID'] ?>" class="btn btn-danger">Delete</a>

                        </td>
                          
                        <?php }?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pendding Users</h4>
                  <?php 
                   // fetch date from database
                      $stmt=$conn->prepare('SELECT * from users where status!=1 and approve = 0 order by userID desc ');
                      $stmt->execute();
                      //fetch date in array
                      $penndings=$stmt->fetchall();
                  ?>
                  <div class="table-responsive">
                    <table class="table ">
                          <thead>
                        <tr>
                          <th>Profile</th>
                          <th>email</th>
                          <th>Created at</th>
                          <th>Full name</th>
                          <th>Control</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                      foreach ($penndings as $pennding) {
                      ?>
                        <tr>
                          <td><?php echo $pennding['username']?></td>
                          <td><?php echo $pennding['email']?></td>
                          <td><?php echo $pennding['register_date']?></td>
                          <td><?php echo $pennding['fullname']?></td>

                          <td>
                            <a href="?do=approve&userid=<?php echo $pennding['userID'] ?>" class="btn btn-success">Activate</a>

                        </td>
                          
                        <?php }?>
                        
                      </tbody>
                    </table>
                  </div>
                  
                </div>
                
              </div>
              
            </div>
            <a href="?do=add" class="btn btn-primary btn-rounded btn-fw" 
            style="width:auto;margin-left:16px;margin-top:-10px;padding:8px"><i style="font-size: 15px;" class="mdi mdi-account-star"></i> Add Member</a>

  <?php 
}elseif ($do=='add') {
      /*add page*/
?>

<div class="content-wrapper">
<div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title"> Add Member </h3>
            <nav aria-label="breadcrumb">
              
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add new member</h4>
                  <p class="card-description">insert information accurately</p>
                  <form class="forms-sample" action="?do=insert" method="POST">
                    <div class="form-group" >
                      <label for="exampleInputName1">Name</label>
                      <input type="text" style="color:white"  name="username" class="form-control" id="exampleInputName1" data-text="" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Full Name</label>
                      <input type="text" style="color:white" name="fullname"  class="form-control" id="exampleInputName1"  placeholder="Full Name" >
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email address</label>
                      <input type="email" style="color:white" name="email"  class="form-control" id="exampleInputEmail3" data-text="" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Password</label>
                      <input type="password" style="color:white" name="password"  class="form-control" id="exampleInputPassword4" data-text="" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="members.php" class="btn btn-dark">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
            </div>
<?php
}elseif ($do=='insert') {
  /*insert page*/
   if ($_SERVER['REQUEST_METHOD']=='POST') {
    extract($_REQUEST);
 $hashed=md5($_POST['password']);
        //validate the form
        $formerrors=array();
        if(empty($username)) {
            $formerrors[]='Username sholdn\'t be empty';
        }elseif (strlen($username)<4) {
            $formerrors[]='Username sholdn\'t be less than 5 carchtars';
        }
        elseif (strlen($username)>20) {
            $formerrors[]='Username sholdn\'t be more than 20 carchtars';
        }elseif (empty($email)) {
            $formerrors[]='Email sholdn\'t be empty';
        }elseif (empty($fullname)) {
            $formerrors[]='fullname sholdn\'t be empty';
        }
        elseif (empty($password)) {
            $formerrors[]='password sholdn\'t be empty';
        }
        foreach ($formerrors as $error) {
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
            echo '<div class="alert alert-danger  text-center" role="alert">'. $error .'</div>';
            echo '</div></div></div>';

        }
        //check if the array of errors is empty to do sql stmt
        if (empty($formerrors)) {
            //check if username is exist in databse
            $count=checkitem('email','users',$email);
            if ($count == 1){
              echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
            $msg="<div class='container alert alert-danger text-center b' role='alert'>this Email is already token</div>";
              echo '</div></div></div>';
            redirecthome($msg,'back',2);

                            }else{
                    //insert user info  in dATABASE
$stmt=$conn->prepare('INSERT into
                                                users(username,password,email,fullname,status,register_date) 
                                        values
                                                (:username,:password,:email,:fullname,0,now())');

                    $stmt->execute(array(
                        'username'  => $username,
                        'password'  =>$hashed,
                        'email'     =>$email,
                        'fullname'  => $fullname));
                    //success message
echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
                    $mssg="<div class=' alert alert-success text-center '>".$stmt->rowcount(). " row inserted</div>";
                    redirecthome($mssg,'back',2);
                    echo '</div></div></div>';

                }
            }
        

                     }else{
                      echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        $mssg='<div class=" alert alert-danger text-center">YOU CAN\'T BROSE THIS PAGE DIRECTLY</div>';
        redirecthome($mssg,5);
                            echo '</div></div></div>';
                                }
                            
}elseif ($do=='edit') {
  /*edit page*/
    // check if user id is numeric and but id in $userid
$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? $_GET['userid']:0;
// echo $userid;
    //fetch data from database
$stmt=$conn->prepare('SELECT * from users where userID=? limit 1');
$stmt->execute(array($userid));
    //but data in array
$row=$stmt->fetch();
   //count the a
$count=$stmt->rowcount();
// var_dump($row);
    // check if user id is exist in database and but info in the form
if ($stmt->rowcount()>0) {
        ?>   
        <div class="content-wrapper">
<div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title"> Edit Member </h3>
            <nav aria-label="breadcrumb">
              
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Basic form elements</h4>
                  <p class="card-description"> Basic form elements </p>
                  <form class="forms-sample" action="?do=update" method="POST">
                    <div class="form-group" >
                      <label for="exampleInputName1">Name</label>
                      <input type="text" style="color:white"  name="username" autocomplete="off" value="<?php echo $row['username'] ?>" class="form-control" id="exampleInputName1" data-text="" placeholder="Name" required>
                        <input type="hidden" class="form-control"name="userid"value="<?php echo $row['userID'] ?>" >

                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Full Name</label>
                      <input type="text" value="<?php echo $row['fullname'] ?>" autocomplete="off" style="color:white" name="fullname"  class="form-control" id="exampleInputName1"  placeholder="Full Name" >
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email address</label>
                      <input type="email" value="<?php echo $row['email'] ?>" autocomplete="off"  style="color:white" name="email"  class="form-control" id="exampleInputEmail3" data-text="" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Password</label>
                      <input type="password" style="color:white" name="newpassword"  class="form-control" autocomplete="new-password" id="exampleInputPassword4" data-text="" placeholder="Password" >
                      <input type="hidden" class="form-control"name="oldpassword"value="<?php echo $row['password'] ?>" >

                    </div>
                    
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="members.php" class="btn btn-dark">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
            </div>
       
        <?php
}else {
  ?>
  <div class="content-wrapper">
<div class="main-panel">
        <div class="content-wrapper">
  <h1 class='container text-center pt-3'>this id isn\'t exist</h1>
</div>
</div>
</div>
  <?php
}



}elseif ($do=='delete') {
  /*delete page*/
  // check if user id is numeric and but id in $userid
$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? $_GET['userid']:0;
// echo $userid;
    //fetch data from database
$stmt=$conn->prepare('SELECT * from users where userID=? limit 1');
    //execute the quere
$stmt->execute(array($userid));

   //count the row
$count=$stmt->rowcount();
// var_dump($row);
    // check if user id is exist in database and but info in the form
if ($stmt->rowcount()>0) {
//delete member from database
$stmt=$conn->prepare('DELETE from users where userID= :userid');
$stmt->bindparam('userid',$userid);
$stmt->execute();
//success 
              echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
            $mssg= "<div class='container alert alert-success text-center b' role='alert'>".$stmt->rowcount()." row Deleted</div>";
            redirecthome($mssg,'back',0);
              echo '</div></div></div>';


 }     
}elseif ($do=='update') {
  /*update page*/
  if ($_SERVER['REQUEST_METHOD']=='POST') {
       
    
        extract($_REQUEST);
        //passwoed trick
        $pass="";
        if (empty($_POST['newpassword'])) {
            $pass=$_POST['oldpassword'];
        }else {
            $pass=md5($_POST['newpassword']);
        }
        //validate the form
        $formerrors=array();
        if(empty($username)) {
            $formerrors[]='Username sholdn\'t be empty';
        }elseif (strlen($username)<4) {
            $formerrors[]='Username sholdn\'t be less than 5 carchtars';
        }
        elseif (strlen($username)>20) {
            $formerrors[]='Username sholdn\'t be more than 20 carchtars';
        }elseif (empty($email)) {
            $formerrors[]='Email sholdn\'t be empty';
        }elseif (empty($fullname)) {
            $formerrors[]='fullname sholdn\'t be empty';
        }
        foreach ($formerrors as $error) {
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
            echo '<div class="alert alert-danger  text-center" role="alert">'. $error .'</div>';
              echo '</div></div></div>';

        }
        //check if the array of errors is empty to do sql stmt
        if (empty($formerrors)) {
            $stmt=$conn->prepare('UPDATE users set username=?,email=?,password=?,fullname=? where userID=? ');
            $stmt->execute(array($username,$email,$pass,$fullname,$userid));
            //success 
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
            $mssg= "<div class=' alert alert-success text-center' role='alert'>". $stmt->rowcount(). " row updated</div>";
            redirecthome($mssg,'back',3);
              echo '</div></div></div>';

        }
        

    }else {
      echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
      echo "<h1 class='container text-center pt-3'>" . 'YOU CAN\'T BROSE THIS PAGE DIRECTLY' . "</h1>";
      echo '</div></div></div>';

    }
}elseif ($do=='approve') {//activate member
        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? $_GET['userid']:0;
            //fetch data from database
        $stmt=$conn->prepare('SELECT * from users where userID=? limit 1');
            //execute the quere
        $stmt->execute(array($userid));

        //count the row
        $count=$stmt->rowcount();
        // var_dump($row);
            // check if user id is exist in database and but info in the form
        if ($stmt->rowcount()>0) {
        //delete member from database
        $stmt=$conn->prepare('UPDATE users set approve=1 where userID=:userid');
        $stmt->bindparam('userid',$userid);
        $stmt->execute();
        //success 
                    echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
                    $mssg= "<div class=' alert alert-success text-center' role='alert'>".$stmt->rowcount()." member activateh</div>";
                    redirecthome($mssg,'back',2);
                          echo '</div></div></div>';

}
}

        include "../" .$tpl . "fotter.php";

}else{
      header('location:login.php');           //redirect to login if username isn't exist 

}
ob_end_flush();