<?php session_start();
$pagetitle="new item";
include "init.php";
if (isset($_SESSION['user'])) {
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
extract($_REQUEST);
    $price      =filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
    $status     =filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
    $category   =filter_var($_POST['cat'],FILTER_SANITIZE_NUMBER_INT);
    $ferrors=array();

    if (empty($name)) {
        $ferrors[]='Name can\'t be empty';
    }if (empty($desc)) {
        $ferrors[]='Describtion can\'t be empty';
    }if (empty($price)) {
        $ferrors[]='Price can\'t be empty';
    }if (empty($status)) {
        $ferrors[]='Status can\'t be empty';
    }if (empty($country)) {
        $ferrors[]='Status can\'t be empty';
    }if (empty($category)) {
        $ferrors[]='Status can\'t be empty';
    }
     if (empty($ferrors)) {            
                    //insert Item info  in dATABASE
                    $stmt=$conn->prepare('INSERT into
                                                items(name,description,price,country_made,add_date,status,userID,catID) 
                                        values
                                                (:name,:description,:price,:country,now(),:status,:userid,:catid)');

                    $stmt->execute(array(
                        'name'           => $name,
                        'description'    =>$desc,
                        'price'          =>$price,
                        'country'        => $country,
                        'status'         => $status,
                        'userid'         => $_SESSION['userid'],
                        'catid'         => $category,


                    ));
                    //success message
                    echo "<div class='container alert alert-success text-center mt-2 mb-2' role='alert'>Item added successfully</div>";

                
            }
    
}

?>
<div class="row">
<div class=" flex-md-equal w-100 ">
    <div class="bg-dark me-md-6  px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden ph">
    <div class="my-3 py-3 cb">
        <h2 class="display-5">Hellow <?php echo $sessionuser; ?></h2>
        <p class="lead">Here you can add new item</p>
    </div>
    <div class="bg-light shadow-sm mx-auto" style="width: 90%; height: 100%; border-radius: 21px 21px 0 0; background-color:#eee !important; ">
    <div class="container">
    
    
        <div class="container marketing">
    <!-- Three columns of text below the carousel -->
    <div class="row">
        <h1 class="text-center pt-4" style="color:#19283f">Add Item</h1>

        <div class="col-7">

            <form class="container pt-3 f" acttion="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="col-7 mb-3  ">
            <label for="exampleInputPassword1" class="form-label ladd " style="color:#19283f;">Name</label>
            <input type="text" class="form-control live-name" name="name" placeholder="name of category " id="exampleInputPassword1"  required>

        </div>
        <div class="col-7 mb-3  ">
            <label for="exampleInputPassword1" class="form-label ladd "style="color:#19283f">Description</label>
            <input type="text" class="form-control live-description"name="desc" placeholder="descripe the category" id="exampleInputPassword1" required>
        </div>
        <div class="col-7 mb-3  ">
            <label for="exampleInputPassword1" class="form-label ladd " style="color:#19283f">Price</label>
            <input type="text" class="form-control live-price"name="price" placeholder="price of the item" id="exampleInputPassword1" required>
        </div>
        <div class="col-7 mb-3 ">
            <label for="exampleInputPassword1" class="form-label ladd " style="color:#19283f">Country Made</label>
            <input type="text" class="form-control"name="country" placeholder="country made" id="exampleInputPassword1"required >
        </div>
            <!-- start status field-->
            <div class="col-7 mb-3  ">
            <label for="exampleInputPassword1" class="form-label ladd " style="color:#19283f">Status</label>
            <select name="status" class="form-select" aria-label="Default select example">
                <option value="0" selected>...</option>
                <option value="1">new</option>
                <option value="2">like new</option>
                <option value="3">used</option>
                <option value="4">old</option>
            </select>
        </div>
            <!-- end members field-->
            <!-- start categories field-->
        <div class="col-7 mb-3 ">
            <label for="exampleInputPassword1" style="color:#19283f" class="form-label ladd">Categories</label>
            <select name="cat" class="form-select" aria-label="Default select example">
                <option value="0" selected>...</option>
                <?php
                $stmt=$conn->prepare('select * from categories');
                $stmt->execute();
                $rows=$stmt->fetchall();
                foreach ($rows as $row) {
                echo "<option value='".$row['catID']."' >".$row['name']."</option>";
                }

                ?>
            </select>
        </div>
            <!-- end categories field-->
        <button type="submit"  class="btn btn-primary col   mb-3">Add Item</button>
        <?php if (!empty($ferrors
)) {
            foreach ($ferrors
 as $error) {
                echo "<div class='alert alert-danger'>".$error."</div>";
            }
        } ?>
        </form>
        </div>
        <div class="col-lg-5">
            <div class="subitemadd live-review">
                <div class="price "><span>0</span>$</span></div>
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" style="" xmlns="" role="img"
                aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice"
                focusable="false">
                
                
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>
        <h2 class="caption" style="padding: 36px 0 5px;overflow:hidden">Title</h2>
        <p class="1" style="margin-top: 23px;">Describtion</p>
        <p class="2" style="margin-top: 54px; "><a class="btn btn-secondary" href="#">View details &raquo;</a></p>
        </div>
    </div>
    
    <!-- /.col-lg-4 -->

    </div><!-- /.row -->


    </li>
            
            </div>
        </ul>
</div>
    </div>
</div>

<?php }else {
    header('location:login.php');
    exit();
}
include $tpl . "fotter.php";?>

