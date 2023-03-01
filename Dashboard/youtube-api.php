<?php
session_start();

if( !(isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 1) ){
    header('Location: ../index.php');
    exit();
}


include "../init.php";
include "../" . $func.'connect.php';
include "../" . $langs . "English.php";
$title = "SportPath - Dashboard";







function getChannel_ID(){
    if(file_exists('../Files/Channel-ID.txt')){
        $Channel_ID = php_strip_whitespace("../Files/Channel-ID.txt");

        if($Channel_ID == ''){
            
            if(file_exists("../Files/Channel-ID(backup).txt")){
                $Channel_ID_Defulte = php_strip_whitespace("../Files/Channel-ID(backup).txt");
                file_put_contents('../Files/Channel-ID.txt', $Channel_ID_Defulte);
                $Channel_ID = $Channel_ID_Defulte;
            }
            else{
                echo "Not Found File in path: (../Files/Channel-ID(backup).txt)";
            }
        }
        return $Channel_ID;
    }
    else{
        if(file_exists("../Files/Channel-ID(backup).txt")){
            $Channel_ID_Defulte = php_strip_whitespace("../Files/Channel-ID(backup).txt");
            file_put_contents('../Files/Channel-ID.txt', $Channel_ID_Defulte);
            return $Channel_ID_Defulte;
        }
        else{
            echo "Not Found File in path: (../Files/Channel-ID(backup).txt)"; 
        }
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


    <center>

        <!-- sidebar -->
        <?php include "../" . $tpl . "Dashboard/sidebar.php"; ?>


        <div class="container-fluid px-5 mt-5 overflow-hidden">

            <div class="row mt-3">


                <div class="TopBar mb-5">
                    <div class="row align-items-center">

                        <div class="col-md-4">
                            <div class="row align-items-center">
                                <label class="col-md-3 form-label">Channel ID:</label>
                                <div class="col-md-9">
                                    <input id="Channel_ID-input" value=<?php echo getChannel_ID();?> type="text"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button id="refresh" class="btn btn-primary"><i
                                    class="fas fa-arrows-rotate fa-sm fa-fw "></i> Refresh</button>
                        </div>

                    </div>
                </div>



                <table id="example" class="table table-striped table-bordered" style="width:100%;">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>playlist Name</th>
                            <th>playlist ID</th>
                            <th>Datetime</th>
                        </tr>
                    </thead>
                    <tfoot></tfoot>
                </table>

            </div>
        </div>



        <!-- inclodes Js libraries -->
        <?php
            include "../" . $tpl . "Dashboard/libraries.php";
        ?>




        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js">
        </script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js">
        </script>
        <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/b-print-2.3.3/datatables.min.js">
        </script>


        <script type="text/javascript">
        let review_id_Update;

        $(document).ready(function() {


            let table = $('#example').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '../<?php echo $func?>/Dashboard/getYoutubeAPI_TB.php',

                dom: "<'row'<'col-md-12 mb-2'B>>" +
                    "<'row m-0'<'col-md-6'l><'col-md-6'f>><'clear'>rtip",
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: [0],
                    orderable: false,
                    searchable: false,
                    className: "dt-center",
                    width: '0px'
                }]
            });


            // Toggle the side navigation
            $("#sidebarToggle").on('click', function(e) {

                $("center").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                }
                table.draw();
            });



            $('#refresh').on('click', function() {
                let Channel_ID = $('#Channel_ID-input').val();

                if (inputIsEmpty(Channel_ID)) {
                    alert("Please enter the channel id.");
                    return;
                }

                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/reafreshCoursesAPI_TB.php",
                    method: "POST",
                    data: {
                        Channel_ID: Channel_ID
                    },
                    success: function(data) {

                        alert(data);
                        table.ajax.reload();

                    }
                })
            });


            function inputIsEmpty(inputVal) {
                if (inputVal == '') {
                    return true;
                } else {
                    return false;
                }
            }

        });
        </script>


</body>

</html>