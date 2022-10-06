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
        $stmt=$conn->prepare('SELECT 
                                    books.*,categories.name 
                            as      catname 
                            from 
                                    books 
                            inner join 
                                    categories 
                            on 
                                    categories.catID = books.catID
                            order by 
                                    bookid desc');
        $stmt->execute();
        //fetch date in array
        $rows=$stmt->fetchall();
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title text-center"> Books page </h3>
        <nav aria-label="breadcrumb">
            
        </nav>
        </div>

        <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">Books</h4>
                
                <div class="table-responsive">
                <table class="table ">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th >Book Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Author Name</th>
                        <th>Created At</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                
                    <tbody>
                        <?php
                    foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td>
                            <?php if (empty($row['image'])) {
                           ?>  NO image  <?php
                            }else{
                             ?>
                        <img src="uploads/books/<?php echo $row['image']?> "/>
                        <?php } ?>
                    </td>
                        <td class="catname"><h5 class=""><?php echo $row['name']?></h5></td>
                        <td><h6><?php echo $row['description']?></h6></td>
                        <td><?php echo $row['catname']?></td>
                        <td><?php echo $row['author']?></td>
                        <td><?php echo $row['add_date']?></td>
                        <td>
                        <a href="?do=edit&bookid=<?php echo $row['bookid'] ?>" class="btn btn-primary">Edit</a>
                        <a href="?do=delete&bookid=<?php echo $row['bookid'] ?>" class="btn btn-danger">Delete</a>

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
        style="width:auto;margin-left:16px;margin-top:-10px;padding:8px"><i style="font-size: 15px;" class="mdi mdi-account-star"></i> Add Book</a>

<?php 
}elseif ($do=='add') {
    /*add page*/
?>

<div class="content-wrapper">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title"> Add Book </h3>
        <nav aria-label="breadcrumb">
            
        </nav>
        </div>
        <div class="row">
        <div class="col-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add new Book</h4>
                    <p class="card-description">insert information accurately</p>
                <form class="forms-sample" action="?do=insert" method="POST" enctype="multipart/form-data">
                    <div class="form-group" >
                        <label for="exampleInputName1">Name</label>
                        <input type="text" style="color:white"  name="name" class="form-control live-name" id="exampleInputName1" data-text="" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputName1">Description</label>
                        <input type="text" style="color:white" name="desc"  class="form-control live-description" id="exampleInputName1"  placeholder="Description" >
                        </diV>
                         <div class="form-group">
                        <label for="exampleInputName1">Upload image</label>
                        <input type="file" style="color:white" name="img"  class="form-control live-img" id="exampleInputName1"  placeholder="Book's image " >
                        </diV>
                        <div class="form-group">
                        <label for="exampleInputName1">Author Name</label>
                        <input type="text" style="color:white" name="author"  class="form-control live-author" id="exampleInputName1"  placeholder="Book's Author name " >
                        </diV>
                    <div class="form-group">
                      <label>Categories</label>
                      <?php
                       $stmt=$conn->prepare('SELECT * from categories  order by catID desc');
                        $stmt->execute();
                        //fetch date in array
                        $cats=$stmt->fetchall();
                    ?>
                    <select class="js-example-basic-single catbook" style="width:100%" name="category">
                    <option value="0">...</option>

                    <?php foreach ($cats as $cat) {?>
                        <option value="<?php echo $cat['catID']?> "><?php echo $cat['name']?> </option>
                        <?php } ?>
                    </select>
                    </div>
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="CATEGORIES.PHP.php" class="btn btn-dark">Cancel</a>
                </form>
                </div>
            </div>
            </div>
               <div class="col-3">
                        <div class="card live-review" style="height:95%">
                            <!-- Sale badge-->
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center m-4">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder m-3 ">Book name</h5>
                                    <h6 class="fw-bolder m-4 1">Description</h6>
                                    <p class="fw-bolder m-4 ">Author Name</p>

                                    
                            </div>
                            
                        </div>
                    </div>
        </div>
<?php
}elseif ($do=='insert') {
/*insert page*/
if ($_SERVER['REQUEST_METHOD']=='POST') {
extract($_REQUEST);

$imgname=$_FILES['img']['name'];
$imgsize=$_FILES['img']['size'];
$imgtmp=$_FILES['img']['tmp_name'];
$imgtype=$_FILES['img']['type'];

$imgallowedextentions=array('jpg','jpeg','png','gif');
$imgextention=strtolower(end(explode('.', $imgname)));
    //validate the form
    $formerrors=array();
    if(empty($name)) {
        $formerrors[]='name sholdn\'t be empty';
    }elseif (empty($desc)) {
        $formerrors[]='Describtion sholdn\'t be empty';
    }
    elseif (!in_array($imgextention,$imgallowedextentions)) {
        $formerrors[]='This extention isn\'t allowed ';
    }elseif (empty($category)) {
        $formerrors[]='Category sholdn\'t be empty';
    }elseif (empty($author)) {
        $formerrors[]='Author sholdn\'t be empty';
    }
    foreach ($formerrors as $error) {
        echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        echo '<div class="alert alert-danger  text-center" role="alert">'. $error .'</div>';
        echo '</div></div></div>';
    }
    //check if the array of errors is empty to do sql stmt
    if (empty($formerrors)) {
        //check if book is exist in databse
        $count=checkitem('name','books',$name);
        
        if ($count == 1){
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
            $msg="<div class=' alert alert-danger text-center ' role='alert'>this Book  is already exist</div>";
            redirecthome($msg,'back',2);
            echo '</div></div></div>';

                        }else{
                            $bookimg=rand(0,5000000000) .'_' . $imgname;
                            move_uploaded_file($imgtmp,"uploads/books/" .$bookimg);
                //insert user info  in dATABASE
                $stmt=$conn->prepare('INSERT into
                                            books(name,description,image,author,catID,add_date	) 
                                    values
                                            (:name,:description,:img,:author,:category,now())');

                $stmt->execute(array(
                    'name'  => $name,
                    'description'  =>$desc,
                    'img'         =>$bookimg,
                    'author'         =>$author,
                    'category'  =>$category

                ));
                //success message
echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
                $mssg="<div class=' alert alert-success text-center '>".$stmt->rowcount(). " book added</div>";
                redirecthome($mssg,'back',0);
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
$bookid=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? $_GET['bookid']:0;
//fetch data from database
$stmt=$conn->prepare('SELECT * from books where bookid=? limit 1');
$stmt->execute(array($bookid));
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
        <h3 class="page-title"> Edit Book </h3>
        <nav aria-label="breadcrumb">
            
        </nav>
        </div>
        <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">Basic form elements</h4>
                <p class="card-description"> Basic form elements </p>
                <form class="forms-sample" action="?do=update" method="POST" enctype="multipart/form-data">
                <div class="form-group" >
                    <label for="exampleInputName1">Name</label>
                    <input type="text" style="color:white"  name="name" autocomplete="off" value="<?php echo $row['name'] ?>" class="form-control" id="exampleInputName1" data-text="" placeholder="Name" required>
                    <input type="hidden" class="form-control"name="bookid"value="<?php echo $row['bookid'] ?>" >
                </div>
               
                <div class="form-group">
                    <label for="exampleInputName1">Description</label>
                    <input type="text" value="<?php echo $row['description'] ?>" autocomplete="off" style="color:white" name="desc"  class="form-control" id="exampleInputName1"  placeholder="Description" >
                </div>
                 <div class="form-group">
                        <label for="exampleInputName1">Upload image</label>
                        <input type="file" style="color:white" name="img"  class="form-control live-price" id="exampleInputName1"  placeholder="Book's image " >
                        </diV>
                <div class="form-group">
                        <label for="exampleInputName1">Author Name</label>
                        <input type="text" value="<?php echo $row['author'] ?>" style="color:white" name="author"  class="form-control live-author" id="exampleInputName1"  placeholder="Book's Author name " >
                        </diV>
                <div class="form-group">
                      <label>Categories</label>
                      <?php
                       $stmt=$conn->prepare('SELECT * from categories  order by catID desc');
                        $stmt->execute();
                        //fetch date in array
                        $cats=$stmt->fetchall();
                    ?>
                    <select class="js-example-basic-single catbook" style="width:100%" name="category">
                    <option value="0">...</option>

                    <?php 
                    $stmt=$conn->prepare('select * from categories');
                    $stmt->execute();
                    $cats=$stmt->fetchall();
                    foreach ($cats as $cat) {?>
                <option value="<?php echo $cat['catID']?>" <?php if ($cat['catID']==$row['catID']) { echo 'selected'; } ?>><?php echo $cat['name']?></option>
                        <?php } ?>
                    </select>
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
// check if book id is numeric and but id in $userid
$bookid=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? $_GET['bookid']:0;
//fetch data from database
$stmt=$conn->prepare('SELECT * from books where bookid=? limit 1');
//execute the quere
$stmt->execute(array($bookid));

//count the row
$count=$stmt->rowcount();
// var_dump($row);
// check if user id is exist in database and but info in the form
if ($stmt->rowcount()>0) {
//delete category from database
$stmt=$conn->prepare('DELETE from books where bookid= :bookid');
$stmt->bindparam('bookid',$bookid);
$stmt->execute();
//success 
            echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        $mssg= "<div class=' alert alert-success text-center' role='alert'>".$stmt->rowcount()." book Deleted</div>";
        redirecthome($mssg,'back',2);
            echo '</div></div></div>';


}     
}elseif ($do=='update') {
/*update page*/
if ($_SERVER['REQUEST_METHOD']=='POST') {
extract($_REQUEST);
$imgname=$_FILES['img']['name'];
$imgsize=$_FILES['img']['size'];
$imgtmp=$_FILES['img']['tmp_name'];
$imgtype=$_FILES['img']['type'];


$imgallowedextentions=array('jpg','jpeg','png','gif');
$imgextention=strtolower(end(explode('.', $imgname)));
    //validate the form
    $formerrors=array();
    if(empty($name)) {
        $formerrors[]='Name sholdn\'t be empty';
    }elseif (empty($desc)) {
        $formerrors[]='Description sholdn\'t be empty';
    }elseif (empty($author)) {
        $formerrors[]='Author Name sholdn\'t be empty';
    }
    foreach ($formerrors as $error) {
        echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        echo '<div class="alert alert-danger  text-center" role="alert">'. $error .'</div>';
            echo '</div></div></div>';

    }
    //check if the array of errors is empty to do sql stmt
    if (empty($formerrors)) {
        $bookimg=rand(0,5000000000) .'_' . $imgname;
        move_uploaded_file($imgtmp,"uploads/books/" .$bookimg);
        $stmt=$conn->prepare('UPDATE books set name=?,description=?,image=?,author=? where bookid=? ');
        $stmt->execute(array($name,$desc,$bookimg,$author,$bookid));
        //success 
        echo '<div class="content-wrapper"><div class="main-panel"><div class="content-wrapper">';
        $mssg= "<div class=' alert alert-success text-center' role='alert'>". $stmt->rowcount(). " book updated</div>";
        redirecthome($mssg,'back',0);
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