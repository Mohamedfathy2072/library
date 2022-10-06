<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Libra</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                          <li class="nav-item"><a style="font-size: 18px;" class="nav-link" href="search.php">Search</a></li> 
                      <?php if (isset($_SESSION['user'])) {
                        echo' <li class="nav-item"><a style="font-size: 18px;" class="nav-link" href="#"> '.$_SESSION['user'].'</a></li>';
                        echo' <li class="nav-item"><a style="font-size: 18px;" class="nav-link" href="logout.php"> Logout</a></li>';
                      }else{?>
                        <li class="nav-item"><a class="nav-link" href="login.php" style="">Login</a></li> 
                        <li class="nav-item"><a class="nav-link" href="signup.php">Create account</a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </nav>