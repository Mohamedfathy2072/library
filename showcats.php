<?php session_start();
$pagetitle="Books";
include "init.php";
?>

        <!-- Masthead-->
        <div class="srbox">
                        <div class="container">
        <?php $catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? $_GET['catid']:0;
$stmt=$conn->prepare("SELECT books.*, categories.name as catname FROM books inner join categories on books.catID = categories.catID where books.catID=?");
                        $stmt->execute(array($catid));

                        $books=$stmt->fetchAll();
                        if (!empty($books)) {
                        ?>                
                <div class="text-center">
                    <h2 class="section-heading text-uppercase mb-3">Books</h2>
                    <h3 class="section-subheading text-muted mb-4">Choose book you need and know more about it</h3>
                </div>
                        
                <div class="row">
                     <?php 
                    
                        foreach ($books as $book) {
                    ?>
                       <div class="col-lg-3 col-md-6 mb-5">
                                                    <a href="s.php?bookid=<?php echo $book['bookid'] ?>" style="text-decoration: none; color: #3c3434;">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="admin/dashboard/uploads/books/<?php echo $book['image']?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder" style="color:black"><?php echo $book['name']?></h5>
                                    <!-- Product price-->
                                    <span class="text-muted">Author : <?php echo $book['author']?></span>
                                    
                                </div>
                            </div>
                        </a>
                            <!-- Product actions-->
                      
                        </div>
                    
                    </div>
                     <?php  }?>
                    
            <?php }else{?>
        <div class="alert alert-info m-5">this category is empty</div>
           <?php }?>
</div>
        
       
<?php
include $tpl . "fotter.php";?>