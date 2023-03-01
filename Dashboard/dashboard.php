<?php
session_start();

if( !(isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 1) ){
    header('Location: ../index.php');
    exit();
}


include "../init.php";
include "../" . $func.'connect.php';
include "../" . $func.'Dashboard/getUsersCountriesChart.php';
include "../" . $func.'Dashboard/getUsersSAcitiesChart.php';
include "../" . $func.'Dashboard/getGenderChart.php';
include "../" . $func.'Dashboard/getCoursesTypesChart.php';
include "../" . $langs . "English.php";
$title = "SportPath - Dashboard";



function getUsers(){
    
    global $conn;
    
    $sql = "SELECT UserID FROM users";
    if($result = $conn->query($sql)){
        
        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "NULL";
        }
        

    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}

function getCourses(){
    global $conn;
    
    $sql = "SELECT course_id FROM courses";
    if($result = $conn->query($sql)){

        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "NULL";
        }
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getTypes(){
    global $conn;
    
    $sql = "SELECT type_id FROM types";
    if($result = $conn->query($sql)){
    
        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "NULL";
        }
    
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getReviews(){
    global $conn;
    
    $sql = "SELECT review_id FROM reviews";
    if($result = $conn->query($sql)){
    
        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "NULL";
        }
    
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include "../" . $tpl . "Dashboard/head.php";
    ?>

</head>







<body>


    <header id="header">

        <?php include "../" . $tpl . "Dashboard/header.php" ;?>

    </header>

    <center id="page-top">

        <?php include "../" . $tpl . "Dashboard/sidebar.php"; ?>



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container">


                    <!-- Content Row -->
                    <div class="row mb-4 mt-4">

                        <!-- Users Card Example -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo getUsers();?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Courses Card Example -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Courses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getCourses();?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Types Card Example -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Types of Courses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo getTypes();?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Rivews Card Example -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Reviews</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getReviews();?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row justify-content-center">

                        <!-- Area Chart -->
                        <!-- <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4"> -->
                        <!-- Card Header - Dropdown -->
                        <!-- <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                </div> -->
                        <!-- Card Body -->
                        <!-- <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Users Countries Chart -->
                        <div class="col-xl-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Users Countries</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="UsersCountriesChart" class="my-2" style="width:100%;"></canvas>
                                </div>
                            </div>
                        </div>


                        <!-- Users SA Cities Chart -->
                        <div class="col-xl-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Users From SA Cities</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="UsersSAcitiesChart" class="my-2" style="width:100%;"></canvas>
                                </div>
                            </div>
                        </div>



                        <!-- Users Gender Chart -->
                        <div class="col-xl-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Users Gender</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="GenderChart" class="my-2" style="width:100%;"></canvas>
                                </div>
                            </div>
                        </div>


                        <!-- Courses Types Chart -->
                        <div class="col-xl-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Course Types</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="CoursesTypesChart" class="my-2" style="width:100%;"></canvas>
                                </div>
                            </div>
                        </div>





                    </div>




                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </center>





    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#header">
        <i class="fas fa-angle-up"></i>
    </a>




    <!-- inclodes Js libraries -->
    <?php
    include "../" . $tpl . "Dashboard/libraries.php";
    ?>




    <script type="text/javascript">
    $(document).ready(function() {

        // Toggle the side navigation
        $("#sidebarToggle").on('click', function(e) {

            $("center").toggleClass("sidebar-toggled");
            $(".sidebar").toggleClass("toggled");
            if ($(".sidebar").hasClass("toggled")) {
                $('.sidebar .collapse').collapse('hide');
            }
        });


        var barColors = [
            "#3366CC", "#DC3912", "#FF9900", "#109618", "#990099", "#3B3EAC", "#0099C6",
            "#DD4477", "#66AA00", "#B82E2E", "#316395", "#994499", "#22AA99", "#AAAA11",
            "#6633CC", "#E67300", "#8B0707", "#329262", "#5574A6", "#651067"
        ];

        var UCounriesChartxVlues = <?php echo json_encode($UsersCountriesChart_Xvalues);?>;
        var UCounriesChartyVlues = <?php echo json_encode($UsersCountriesChart_Yvalues);?>;
        new Chart("UsersCountriesChart", {
            type: "pie",
            data: {
                labels: UCounriesChartxVlues,
                datasets: [{
                    backgroundColor: barColors,
                    data: UCounriesChartyVlues
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: (tooltipItem, data) => {
                            var value = data.datasets[0].data[tooltipItem.index];
                            var total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            var pct = 100 / total * value;
                            var pctRounded = Math.round(pct * 10) / 10;
                            return ' ' + data.labels[tooltipItem.index] + ' (' + pctRounded + '%)';
                        },
                        footer: function(tooltipItems, data) {
                            var sum = 0;

                            tooltipItems.forEach(function(tooltipItem) {
                                sum += data.datasets[tooltipItem.datasetIndex].data[
                                    tooltipItem.index];
                            });
                            return 'Sum: ' + sum;
                        }
                    }
                }
            }
        });


        var U_SAcitiesChart_xVlues = <?php echo json_encode($UsersSAcitesChart_Xvalues);?>;
        var U_SAcitiesChart_yVlues = <?php echo json_encode($UsersSAcitesChart_Yvalues);?>;
        new Chart("UsersSAcitiesChart", {
            type: "pie",
            data: {
                labels: U_SAcitiesChart_xVlues,
                datasets: [{
                    backgroundColor: barColors,
                    data: U_SAcitiesChart_yVlues
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: (tooltipItem, data) => {
                            var value = data.datasets[0].data[tooltipItem.index];
                            var total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            var pct = 100 / total * value;
                            var pctRounded = Math.round(pct * 10) / 10;
                            return ' ' + data.labels[tooltipItem.index] + ' (' + pctRounded + '%)';
                        },
                        footer: function(tooltipItems, data) {
                            var sum = 0;

                            tooltipItems.forEach(function(tooltipItem) {
                                sum += data.datasets[tooltipItem.datasetIndex].data[
                                    tooltipItem.index];
                            });
                            return 'Sum: ' + sum;
                        }
                    }
                }
            }
        });



        var UGenderChart_yVlues = <?php echo json_encode($GenderChart_Yvalues);?>;
        new Chart("GenderChart", {
            type: "doughnut",
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    backgroundColor: ['blue', 'pink'],
                    data: UGenderChart_yVlues
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: (tooltipItem, data) => {
                            var value = data.datasets[0].data[tooltipItem.index];
                            var total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            var pct = 100 / total * value;
                            var pctRounded = Math.round(pct * 10) / 10;
                            return ' ' + data.labels[tooltipItem.index] + ' (' + pctRounded + '%)';
                        },
                        footer: function(tooltipItems, data) {
                            var sum = 0;

                            tooltipItems.forEach(function(tooltipItem) {
                                sum += data.datasets[tooltipItem.datasetIndex].data[
                                    tooltipItem.index];
                            });
                            return 'Sum: ' + sum;
                        }
                    }
                }
            }
        });



        var CoursesTypesChart_xVlues = <?php echo json_encode($CoursesTypesChart_Xvalues);?>;
        var CoursesTypesChart_yVlues = <?php echo json_encode($CoursesTypesChart_Yvalues);?>;
        new Chart("CoursesTypesChart", {
            type: "doughnut",
            data: {
                labels: CoursesTypesChart_xVlues,
                datasets: [{
                    backgroundColor: barColors,
                    data: CoursesTypesChart_yVlues
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: (tooltipItem, data) => {
                            var value = data.datasets[0].data[tooltipItem.index];
                            var total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            var pct = 100 / total * value;
                            var pctRounded = Math.round(pct * 10) / 10;
                            return ' ' + data.labels[tooltipItem.index] + ' (' + pctRounded + '%)';
                        },
                        footer: function(tooltipItems, data) {
                            var sum = 0;

                            tooltipItems.forEach(function(tooltipItem) {
                                sum += data.datasets[tooltipItem.datasetIndex].data[
                                    tooltipItem.index];
                            });
                            return 'Sum: ' + sum;
                        }
                    }
                }
            }
        });

    });
    </script>

</body>

</html>