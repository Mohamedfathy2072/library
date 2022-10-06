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
        $stmt=$conn->prepare('SELECT * from categories   order by catID desc ');
        $stmt->execute();
        //fetch date in array
        $rows=$stmt->fetchall();
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title text-center"> Categories page </h3>
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
                        <th >Category Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                
                    <tbody>
                        <?php
                    foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td class="catname"><h4 class="cname"><?php echo $row['name']?></h4>


                        
                    
                            </div>
                    </td>
                        <td><h5><?php echo $row['description']?></h5></td>
                        <td><?php echo $row['date']?></td>

                        <td>
                        <a href="?do=edit&catid=<?php echo $row['catID'] ?>" class="btn btn-primary">Edit</a>
                        <a href="?do=delete&catid=<?php echo $row['catID'] ?>" class="btn btn-danger">Delete</a>

                    </td>
                        
                    <?php }?>
                    
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
        </div>
        
            
            
            
        
        <a href="?do=add" class="btn btn-primary btn-rounded btn-fw" 
        style="width:auto;margin-left:16px;margin-top:-10px;padding:8px"><i style="font-size: 15px;" class="mdi mdi-account-star"></i> Add Category</a>

<?php 
}elseif ($do=='add') {
    /*add page*/
?>

<div class="content-wrapper">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title"> Add Category </h3>
        <nav aria-label="breadcrumb">
            
        </nav>
        </div>
        <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add new Category</h4>
                    <p class="card-description">insert information accurately</p>
                <form class="forms-sample" action="?do=insert" method="POST">
                    <div class="form-group" >
                        <label for="exampleInputName1">Name</label>
                        <input type="text" style="color:white"  name="name" class="form-control" id="exampleInputName1" data-text="" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputName1">Description</label>
                        <input type="text" style="color:white" name="desc"  class="form-control" id="exampleInputName1"  placeholder="Full Name" >
                        </diV>
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="CATEGORIES.PHP.php" class="btn btn-dark">Cancel</a>
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
    //validate the form
    $formerrors=array();
    if(empty($name)) {
        $formerrors[]='name sholdn\'t be empty';
    }elseif (empty($desc)) {
        $formerrors[]='Describtion sholdn\'t be empty';
    }
    foreach ($formerrors as $error) {
        echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        echo '<div class="alert alert-danger  text-center" role="alert">'. $error .'</div>';
        echo '</div></div></div>';
    }
    //check if the array of errors is empty to do sql stmt
    if (empty($formerrors)) {
        //check if username is exist in databse
        $count=checkitem('name','categories',$name);
        if ($count == 1){
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        $msg="<div class='container alert alert-danger text-center b' role='alert'>this Category is already exist</div>";
            echo '</div></div></div>';
        redirecthome($msg,'back',2);

                        }else{
                //insert user info  in dATABASE
$stmt=$conn->prepare('INSERT into
                                            categories(name,description,date) 
                                    values
                                            (:name,:description,now())');

                $stmt->execute(array(
                    'name'  => $name,
                    'description'  =>$desc));
                //success message
echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
                $mssg="<div class=' alert alert-success text-center '>".$stmt->rowcount(). " Category added</div>";
                redirecthome($mssg,'back',2);
                echo '</div></div></div>';

            }
        }
    

                    }else{
                    echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
    $mssg='<div class=" alert alert-danger text-center">YOU CAN\'T BROSE THIS PAGE DIRECTLY</div>';
    redirecthome($mssg,3);
                        echo '</div></div></div>';
                            }
                        
}elseif ($do=='edit') {
/*edit page*/
// check if user id is numeric and but id in $userid
$catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? $_GET['catid']:0;
// echo $userid;
//fetch data from database
$stmt=$conn->prepare('SELECT * from categories where catID=? limit 1');
$stmt->execute(array($catid));
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
        <h3 class="page-title"> Edit Category </h3>
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
                    <input type="text" style="color:white"  name="name" autocomplete="off" value="<?php echo $row['name'] ?>" class="form-control" id="exampleInputName1" data-text="" placeholder="Name" required>
                    <input type="hidden" class="form-control"name="catid"value="<?php echo $row['catID'] ?>" >

                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Description</label>
                    <input type="text" value="<?php echo $row['description'] ?>" autocomplete="off" style="color:white" name="desc"  class="form-control" id="exampleInputName1"  placeholder="Description" >
                </div>
                
                
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <a href="categories.php" class="btn btn-dark">Cancel</a>
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
// check if category id is numeric and but id in $userid
$catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? $_GET['catid']:0;
//fetch data from database
$stmt=$conn->prepare('SELECT * from categories where catID=? limit 1');
//execute the quere
$stmt->execute(array($catid));

//count the row
$count=$stmt->rowcount();
// var_dump($row);
// check if user id is exist in database and but info in the form
if ($stmt->rowcount()>0) {
//delete category from database
$stmt=$conn->prepare('DELETE from categories where catID= :catid');
$stmt->bindparam('catid',$catid);
$stmt->execute();
//success 
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        $mssg= "<div class=' alert alert-success text-center' role='alert'>".$stmt->rowcount()." Category Deleted</div>";
        redirecthome($mssg,'back',2);
            echo '</div></div></div>';


}     
}elseif ($do=='update') {
/*update page*/
if ($_SERVER['REQUEST_METHOD']=='POST') {
    

    extract($_REQUEST);
  
    //validate the form
    $formerrors=array();
    if(empty($name)) {
        $formerrors[]='Name sholdn\'t be empty';
    }elseif (empty($desc)) {
        $formerrors[]='Description sholdn\'t be empty';
    }
    foreach ($formerrors as $error) {
        echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        echo '<div class="alert alert-danger  text-center" role="alert">'. $error .'</div>';
            echo '</div></div></div>';

    }
    //check if the array of errors is empty to do sql stmt
    if (empty($formerrors)) {
        $stmt=$conn->prepare('UPDATE categories set name=?,description=? where catID=? ');
        $stmt->execute(array($name,$desc,$catid));
        //success 
        echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        $mssg= "<div class=' alert alert-success text-center' role='alert'>". $stmt->rowcount(). " Category updated</div>";
        redirecthome($mssg,'back',);
            echo '</div></div></div>';

    }
    

}else {
    echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
    echo "<h1 class='container text-center pt-3'>" . 'YOU CAN\'T BROSE THIS PAGE DIRECTLY' . "</h1>";
    echo '</div></div></div>';

}
}

    include "../" .$tpl . "fotter.php";

}else{
    header('location:login.php');           //redirect to login if username isn't exist 

}
ob_end_flush();