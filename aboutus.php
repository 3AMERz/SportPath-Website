<?php
session_start();

include "init.php";
include $func.'connect.php';
include $langs . "English.php";
$title = "SportPath - About Us";


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include $tpl . "head.php";
    ?>

</head>







<body>


    <header id="header">

        <?php include $tpl . "header.php" ;?>

    </header>

    <center>

        <div class="intro py-5 w-100">
            <div class="container">
                <div class="row row-eq-height">
                    <div class="col-lg-7">
                        <div class="intro_content">
                            <div class="section_title">
                                <h1>About Us</h1>
                            </div>
                            <div class="intro_text">
                                <p>
                                    SPORTPATH is an online platform for physical education, coaches & trainers, sports
                                    associations and clubs that offers support in training (top)athletes. The system is
                                    set up in such a way that it can be used for any sport. Every sport has its own type
                                    in the platform.
                                </p>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="mt-4">
                                <h1 class="mb-3">Our Team</h1>
                                <p><i class="fa-solid fa-circle fa-sm me-2"></i> Mansour Al-Harbi</p>
                                <p><i class="fa-solid fa-circle fa-sm me-2"></i> Ibrahim Al-Zaid</p>
                                <p><i class="fa-solid fa-circle fa-sm me-2"></i> Amer Alswelim</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex justify-content-center align-items-center">
                        <div class="intro_image">
                            <img src="images/AboutUs.png" alt="" style="width:400px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </center>

    <footer>
        <!-- inclodes footer -->
        <?php
        include $tpl . "footer.php";
        ?>
    </footer>




    <!-- inclodes Js libraries -->
    <?php
    include $tpl . "libraries.php";
    ?>




    <script type="text/javascript">
    $(document).ready(function() {

    });
    </script>





</body>

</html>