<?php 

?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Navbar brand -->
        <a class="navbar-brand me-5 p-0" href="index.php">
            <img src="/images/icon-2.png" alt="" width="100px">
        </a>

        <!-- Toggle button -->
        <button class="navbar-toggler" data-target="#navbarButtonsExample" data-toggle="collapse" type="button"
            aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarButtonsExample">

            <!-- Left links -->
            <ul class="navbar-nav mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="courses.php">Courses</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="aboutus.php">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>

                <?php 
                if(isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 1){
                    echo '<li class="nav-item">
                            <a class="nav-link" href="Dashboard/dashboard.php">Dashboard</a>
                          </li>';
                }
                ?>



                

            </ul>

            <!-- right links -->
            <div class="navbar-nav d-flex align-items-center">
                
            <?php 
            
            if(isset($_SESSION['Username'])){

                echo '
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hello, ' . $_SESSION['Username'] .
                    '</a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="profile.php">
                            <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="mycourses.php">
                            <i class="fas fa-list fa-sm fa-fw mr-2"></i>
                            My Course
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="' . $func . 'logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                            Logout
                        </a>
                    </div>
                </li>';
            }
            else{
                echo '<button type="button" id="navLoginBtn" class="btn btn-outline-primary px-3 me-2 mb-2 mb-md-0">Login</button>
                    <button type="button" id="navSignupBtn" class="btn btn-primary">Sign Up</button>';
            }
            
            ?>

            </div>


        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->