<?php session_start();
$pagetitle="Search";
include "init.php";
?>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <!-- Page heading-->
                            <h1 class="mb-5">Enter book name that you need !</h1>
                          
                            <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN" action="searchresult.php" method="post">
                                <!-- Email address input-->
                                <div class="row">
                                    <div class="col">
                                        <input name="search" class="form-control form-control-lg" id="emailAddress" type="text" placeholder="Book Name"  required/>
                                    </div>
                                    <div class="col-auto"><button class="btn btn-primary btn-lg " type="submit">Search</button></div>
                                </div>
                              
                                <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Icons Grid-->
        
        
<?php
include $tpl . "fotter.php";?>
