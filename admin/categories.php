<?php
ob_start();//start buffering output
session_start();
$pagetitle='Categories';
/*
categories =>[manage | edit | delete | add | insert | update]
*/
if (isset($_SESSION['username'])) {
include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';
if ($do=='manage') {
    /*manage page*/
    $sort='asc';
    $sort=isset($_GET['sort']) && in_array($sort,['asc','desc'])?$_GET['sort']:'';
    
    $stmt=$conn->prepare("SELECT * from categories where perant = 0 order by ordering $sort");
    $stmt->execute();
    $rows=$stmt->fetchall();
    ?>
    <h1 class="text-center pt-3 "> Manage Categories</h1>
    <div class="container pt-5">
        <ul class="list-group ">
            <li class="list-group-item fw-bold" style="background-color:#eee;font-size:19px;"><i class='fa-solid fa-pen-to-square ' style="position: relative;font-size: 17px;"></i> Manage Categories
            <div class="sort float-end">
                Ordering :
                <a href='?sort=asc' class="<?php if ($sort=='asc') {echo 'active';} ?>">ASC</a> |
                <a href='?sort=desc' class="<?php if ($sort=='desc') {echo 'active';} ?>">DESC</a>
            </div>
            </li>
            <?php
            foreach ($rows as $cat) {
                echo "<div class='cat fz-10'>";
                    echo "<li class='list-group-item'>";
                    echo "<div class='hidden-buttons'>
                    <a href='?do=edit&catid=".$cat['catID']."' class='btn btn-sm btn-primary ' ;padding:4px 8px'><i class='fa-solid fa-pen-to-square '></i> Edit</a> 
                    <a href='?do=delete&catid=".$cat['catID']."' class='btn btn-sm btn-danger ' ;padding:4px 8px'><i class='fa-solid fa-close '></i> Delete</a>";
                    

                    echo "</div>";
                    echo "<h3 class='mb-3'>".$cat['name']."</h3>";
                    echo '<div class="full-view">';
                     echo '<div class="full-view">';
                    if ($cat['description']=="") {
                        echo "<h5 class='mb-3'>This category has't describtion</h5>";
                    }else {
                        echo "<h5 class='mb-3'>".$cat['description']."</h5>";

                    }
                    $stmtsup=$conn->prepare("SELECT * from categories where perant= {$cat['catID']}");
                    $stmtsup->execute();
                    $supcats=$stmtsup->fetchALL();
                    $count=$stmtsup->rowcount();
                    if (!empty($supcats)) {
                        
                
                    ?>
                    <ul class="list-group ">
                        <?php
                        foreach ($supcats as $supcat) {
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start subcat">
                            <div class="ms-2 me-auto ">
                            <div class="fw-bold subhead" >subcategories </div>
                            <div class="fw-bold"><a style="text-decoration: none !important;"
                            href="?do=edit&catid=<?php echo $supcat['catID']?> ">- <?php echo $supcat['name']?> <a>
                            <a class="confirm" href="?do=delete&catid=<?php echo $supcat['catID']?>"><i class="fa-solid fa-circle-minus deletesub"></i></a>
                            
                            </div>
                            </div>
                            <span class="badge bg-primary rounded-pill"><?php echo $count ?></span>
                        </li>
                       <?php }?>
                </ul>
                    <?php
                    }
                  
                    if ($cat['visibility']==1) {
                        echo "<span class='visibilityl'><i class='fa-solid fa-eye '></i> Hidden</span>";
                    }
                    if ($cat['allow_comments']==1) {
                        echo "<span class='commentingl'><i class='fa-solid fa-close '></i> Comments Disabled</span>";
                    }
                    if ($cat['allow_ads']==1) {
                        echo "<span class='adsl'><i class='fa-solid fa-close '></i> Ads Disabled</span>";
                    }
                    echo "</div>";

                    echo "</li>";
                echo  "</div>";
            }
         

            ?>
            
    </ul>
            <a href="?do=add"  class="btn btn-sm btn-primary col mt-2"><i class="fa-solid fa-plus"></i> Add New Category</a>'

        </div>
    </div>
    
    
    <?php
}elseif ($do=='add') {
        /*add page*/
        ?>   
  <h1 class="text-center pt-3 ">Add Category</h1>
        <form class="container pt-5 f" action="?do=insert" method="POST">
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Name</label>
            <input type="text" class="form-control" name="name" placeholder="name of category " id="exampleInputPassword1" autocomplete="off"  required>

        </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Description</label>
            <input type="text" class="form-control"name="desc" placeholder="descripe the category" id="exampleInputPassword1" autocomplete="off">
        </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Sub category</label>
            <select name="perant" class="form-select" aria-label="Default select example">
                <option value="0" selected>Main category</option>
                <?php
                $stmt=$conn->prepare('SELECT * from categories where perant = 0');
                $stmt->execute();
                $rows=$stmt->fetchall();
                foreach ($rows as $value) {
                echo "<option value='".$value['catID']."'>".$value['name']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Oredering</label>
            <input type="text" class="form-control"name="oredering" placeholder="number of order" id="exampleInputPassword1" autocomplete="off">
        </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Visibility</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="vis-yes" value='0' checked>
            <label class="form-check-label" for="vis-yes">
                yes
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="vis-no"  value='1' >
            <label class="form-check-label" for="vis-no">
                no
            </label>
            </div>        </div>
            <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Allow comments</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="commenting" id="com-yes" value='0' checked>
            <label class="form-check-label" for="com-yes">
                yes
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="commenting" id="com-no" value='1'>
            <label class="form-check-label" for="com-no">
                No
            </label>
            </div>        </div>
            <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Allow ads</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="ads" id="ads-yes" value='0' checked>
            <label class="form-check-label" for="ads-yes">
               yes
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="ads" id="ads-no"value='1' >
            <label class="form-check-label" for="ads-no">
                no
            </label>
            </div> 
            </div>
        <button type="submit"  class="btn btn-primary col offset-2">Add Category</button>
        </form>
<?php

}elseif ($do=='insert') {
    /*insert page*/
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        
        echo  '<h1 class="text-center pt-3 pb-5 ">Insert Category</h1>';
    extract($_POST);

        
        //check if the array of errors is empty to do sql stmt
        if (!empty($name)) {
            //check if username is exist in databse
            $count=checkitem('name','categories',$name);
            if ($count == 1){
            $msg="<div class='container alert alert-danger text-center b' role='alert'>this category is already exist</div>";
            redirecthome($msg,'back',3);


                            }else{
                    //insert category info  in dATABASE
                    $stmt=$conn->prepare('INSERT into
                                                categories(name,description,perant,ordering,visibility,allow_comments,allow_ads) 
                                        values
                                                (:name,:description,:subcategory,:ordering,:visibility,:allow_comments,:allow_ads)');

                    $stmt->execute(array(
                        'name'  => $name,
                        'description'  =>$desc,
                        'subcategory'   =>$perant,
                        'ordering'     =>$oredering,
                        'visibility'  => $visibility,
                        'allow_comments'  => $commenting,
                        'allow_ads'  => $ads,


                    ));
                    //success message
                    $mssg="<div class='container alert alert-success text-center b' role='alert'>".$stmt->rowcount(). " row inserted</div>";
                    redirecthome($mssg,'back',5);

                }
            }else{
                echo '<div class="container alert alert-danger text-center">name can\'n be empty</div>';

            }
        

                     }else{
        $mssg='<div class="container alert alert-danger text-center">YOU CAN\'T BROSE THIS PAGE DIRECTLY</div>';
        redirecthome($mssg,5);
                                }
                            
}elseif ($do=='edit') {
    /*edit page*/
    $catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? $_GET['catid']:0;
// echo $userid;
    //fetch data from database
$stmt=$conn->prepare('SELECT * from categories where catID=? and perant=0 limit 1');
$stmt->execute(array($catid));
    //but data in array
$row=$stmt->fetch();
   //count the a
$count=$stmt->rowcount();
// var_dump($row);
    // check if user id is exist in database and but info in the form
if ($stmt->rowcount()>0) {
        ?>   

                <h1 class="text-center pt-3 ">Edit Category</h1>
        <form class="container pt-3" action="?do=update" method="POST">
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Name</label>
            <input type="text" class="form-control" name="name" id="exampleInputPassword1" autocomplete="off" value="<?php echo $row['name'] ?>" required>
            <input type="hidden" name="catid" class="form-control" value="<?php echo $row['catID'] ?>">

        </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Description</label>
            <input type="text" class="form-control" value="<?php echo $row['description'] ?>" name="desc" id="exampleInputPassword1" autocomplete="off">
        </div>
        <div class="col-8 mb-3 offset-2">
         <label for="exampleInputPassword1" class="form-label b">Sun category</label>
        <select name="perant" class="form-select" aria-label="Default select example">
                <option value="0" >Main category</option>
                <?php
                $stmt=$conn->prepare('SELECT * from categories where perant = 0');
                $stmt->execute();
                $subc=$stmt->fetchall();
                foreach ($subc as $c) {
                echo "<option value='".$c['catID']."'";
                if ($row['perant']==$c['catID']) {
                    echo 'selected';
                                }
                echo">".$c['name']."</option>";
                }
                ?>
            </select>
            </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Ordering</label>
            <input type="text" class="form-control" name="ordering" id="exampleInputPassword1" autocomplete="off" value="<?php echo $row['ordering'] ?>" required>
        </div>
        <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Visibility</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="vis-yes" value='0' <?php if ($row['visibility']==0) { echo 'checked'; } ?>>
            <label class="form-check-label" for="vis-yes">
                yes
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="vis-no"  value='1' <?php if ($row['visibility']==1) { echo 'checked'; } ?>>
            <label class="form-check-label" for="vis-no">
                no
            </label>
            </div>        </div>
            <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Allow comments</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="commenting" id="com-yes" value='0' <?php if ($row['allow_comments']==0) { echo 'checked'; } ?>>
            <label class="form-check-label" for="com-yes">
                yes
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="commenting" id="com-no" value='1'<?php if ($row['allow_comments']==1) { echo 'checked'; } ?>>
            <label class="form-check-label" for="com-no">
                No
            </label>
            </div>        </div>
            <div class="col-8 mb-3 offset-2">
            <label for="exampleInputPassword1" class="form-label b">Allow ads</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="ads" id="ads-yes" value='0' <?php if ($row['allow_ads']==0) { echo 'checked'; } ?>>
            <label class="form-check-label" for="ads-yes">
                yes
            </label>
            </div>
            <input class="form-check-input" type="radio" name="commenting" id="com-no" value='1'<?php if ($row['allow_ads']==1) { echo 'checked'; } ?>>
            <label class="form-check-label" for="com-no">
                No
            </label>
        </div>
        <button type="submit"  class="btn btn-primary col offset-2">Confirm</button>
        </form>
        <?php
}else {
    echo "<h1 class='container text-center pt-3'>" . '[this id isn\'t exist]' . "</h1>";
}
}elseif ($do=='delete') {
    /*delete page*/
     echo  '<h1 class="text-center pt-3 pb-5 ">Delete Category</h1>';
$catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? $_GET['catid']:0;
// echo $userid;
    //fetch data from database
$stmt=$conn->prepare('SELECT * from categories where catID=? limit 1');
    //execute the quere
$stmt->execute(array($catid));

   //count the row
$count=$stmt->rowcount();
// var_dump($row);
    // check if user id is exist in database and but info in the form
if ($stmt->rowcount()>0) {
//delete member from database
$stmt=$conn->prepare('DELETE from categories where catID= :catid');
$stmt->bindparam('catid',$catid);
$stmt->execute();
//success 
            $mssg= "<div class='container alert alert-success text-center b' role='alert'>".$stmt->rowcount()." row Deleted</div>";
             redirecthome($mssg,'back',2);


 }     
}elseif ($do=='update') {
    /*update page*/
    if ($_SERVER['REQUEST_METHOD']=='POST') {
       
    
        echo  '<h1 class="text-center pt-3 pb-5 ">Update Category</h1>';
        extract($_POST);
        
        
        //check if the array of errors is empty to do sql stmt
        if (!empty($name)) {
            $stmt=$conn->prepare('UPDATE categories set name=?,description=?,perant=?,ordering=?,visibility=?,allow_comments=?,allow_ads=? where catID=? ');
            $stmt->execute(array($name,$desc,$perant,$ordering,$visibility,$commenting,$ads,$catid));
            //success 
            $mssg= "<div class='container alert alert-success text-center b' role='alert'>". $stmt->rowcount(). " row updated</div>";
            redirecthome($mssg,'back',5);

        }else {
            $mssg= "<div class='container alert alert-success text-center b' role='alert'>Name is required </div>";
            redirecthome($mssg,'back',5);
        }
        

    }else {
    echo "<h1 class='container text-center pt-3'>" . 'YOU CAN\'T BROSE THIS PAGE DIRECTLY' . "</h1>";
    }
}elseif ($do=='activate') {
    /*activate page*/
}

include $tpl.'fotter.php';

}else {
    header('location:login.php');
    exit();
}
ob_end_flush();
?>