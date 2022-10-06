<?php
ob_start();
session_start();
$pagetitle="Dashboard";
if ($_SESSION['user']) {
        include "../init.php";
        ?>



    
    
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
           
            <div class="row">
              <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                      <a style="text-decoration:none;color:white" href="categories.php">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center w">
                            <i style="font-size:24px;padding:0 4px" class="mdi mdi-animation"></i>
                          <h3 class="mb-0">7</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Categories</h6>
                  </div>
                </div>
                </a>
              </div>
              
              <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                            <a style="text-decoration:none;color:white" href="members.php">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <i style="font-size:24px;padding:0 4px" class="mdi mdi-account-multiple"></i>
                          <h3 class="mb-0">4</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Members</h6>
                  </div>
                  </a>
                </div>
              </div>
             
              <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card ">
                        <a style="text-decoration:none;color:white" href="items.php">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <i style="font-size:24px;padding:0 4px" class="mdi mdi-cards-outline"></i>
                          <h3 class="mb-0 p-1 ">55</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal ">Books</h6>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                     <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">The latest users added</h4>
                    </div>
                     <div class="row">
                      <div class="col-12">
                        <div class="preview-list">
                          <!-- /////////////// -->
                          <?php $users=getlatest('*','users','userID');
                          foreach ($users as $user) {
                            
                  
                          ?>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                             
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject"><a style="text-decoration:none;color:white" href="members.php?do=edit&userid=<?php echo $user['userID'] ?>"><?php echo $user['username'] ?></a></h6>
                                <p class="text-muted mb-0"><?php echo $user['email'] ?></p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted"><?php echo $user['register_date'] ?></p>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                  <!-- ////////////// -->
                          
                        </div>
                      </div>
                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">The latest books added</h4>
                      <p class="text-muted mb-1">Your data status</p>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="preview-list">
                          <!-- /////////////// -->
                          <?php $books=getlatest('*','books','bookid');
                          foreach ($books as $book) {
                            
                  
                          ?>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-primary">
                                <img src="uploads/books/<?php echo $book['image'] ?>" alt="">
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject"><a style="text-decoration:none;color:white" href="items.php?do=edit&bookid=<?php echo $book['bookid'] ?>"><?php echo $book['name'] ?></a></h6>
                                <p class="text-muted mb-0"><?php echo $book['description'] ?></p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted"><?php echo $book['add_date'] ?>o</p>
                                <p class="text-muted mb-0">30 tasks, 5 issues </p>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                  <!-- ////////////// -->
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
<?php
         include '../' . $tpl . "fotter.php";

}else{
        header('location:login.php');           //redirect to login if username isn't exist 

}
ob_end_flush();