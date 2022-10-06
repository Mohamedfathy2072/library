<?php session_start();
$pagetitle="SearchResult";
include "init.php";

$bookid=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? $_GET['bookid']:0;
$stmt=$conn->prepare("SELECT books.*, categories.name as catname FROM books inner join categories on books.catID = categories.catID where bookid=?");
    $stmt->execute(array($bookid));
    $book=$stmt->fetch();
    if ($stmt->rowCount()>0) {
    

?>

<!-- Masthead-->
          <div class="s">
             <section class="py-5">
            <div class="container px-4 px-lg-5 my-5 ">
                <div class="sbox">
                <div class="row gx-4 gx-lg-5 align-items-center mt-5">
                    <div class="col-md-4"><img class="card-img-top mb-5 mb-md-0" src="admin/dashboard/uploads/books/<?php echo $book['image']?>" alt="..." /></div>
                    <div class="col-md-6">
                        <div class="lead mb-1">Date : <?php echo $book['add_date']?></div>
                        <h1 class="display-5 fw-bolder"><?php echo $book['name']?></h1>
                        <div class="fs-5 mb-3">
                            <span>author : <?php echo $book['author']?></span>
                        </div>
                        <p class="fs-3 small"> <?php echo $book['description']?></p>
                       
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
         </div>
     
  
        
        <?php }else{?>
            <div class="s">
<div class="container px-4 px-lg-5 my-5">
                <div class="sbox">
                <div class="row gx-4 gx-lg-5 align-items-center mt-5">
                    <div class="alert alert-danger">this id is not exist</div>
                </div>
            </div>
            </div>
       <?php }



include $tpl . "fotter.php";?>