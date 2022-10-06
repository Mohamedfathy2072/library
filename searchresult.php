<?php session_start();
$pagetitle="SearchResult";
include "init.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_REQUEST);
    $stmt=$conn->prepare("SELECT * FROM books where name LIKE '%$search%'");
    $stmt->execute();
    $books=$stmt->fetchall();
   
            
?>

<!-- Masthead-->
        <div class="srbox ">
          <section class="">
            <div class="container" id="portfolio">
     
                <div class="row">
                    <?php 
            if (!empty($books)) {

                    foreach ($books as $book) {
                    ?>
                                    <!-- Portfolio item 1-->
                                      <div class="col-lg-3 col-md-6 mb-5">
                            <a href="s.php?bookid=<?php echo $book['bookid'] ?>" style="text-decoration: none; color: #3c3434;">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="admin/dashboard/uploads/books/<?php echo $book['image']?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $book['name']?></h5>
                                    <!-- Product price-->
                                    <span class="text-muted">Author : <?php echo $book['author']?></span>
                                    
                                </div>
                            </div>
                            <!-- Product actions-->
                      
                        </div>
                        </a>
                    </div>
                                                                    <?php }?>

                                    </div>
                                    
                                </div>
                            </section>
                    </div>
                    
                    <?php
                    
                }else {?>
        <header class="masthead">
            <div class="container">
<div class="alert alert-danger">Sorry this book isn't exist</div>
</div>
        <?php }
    }else {?>
        <header class="masthead">
            <div class="container">
<div class="alert alert-danger">You can't come this page directly</div>
</div>
        </header>
        <?php }















include $tpl . "fotter.php";?>