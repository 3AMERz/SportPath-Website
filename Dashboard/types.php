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


                <div class="Btns mb-4">
                    <a id="addCourseBtn" data-toggle="modal" data-target="#addTypeModal"
                        class="btn btn-primary btn-sm px-3 py-1">Add
                        Type</a>
                    <button id="delBtn" class="btn btn-danger btn-sm px-3 py-1 disabled" type="delete">Delete
                        Selected</button>
                </div>



                <table id="example" class="table table-striped table-bordered" style="width:100%;">
                    <thead class="table-dark">
                        <tr>

                            <th><input id="example-select-all" class="form-check-input" type="checkbox"
                                    name="select_all" value="1"></th>
                            <th>ID</th>
                            <th>Type Name</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tfoot></tfoot>
                </table>

            </div>
        </div>




        <!-- Update Type Modal -->
        <div class="modal fade" id="EditTypeModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Type</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Type Name</label>
                            <div class="col-md-9">
                                <input id="TypeName-input-Edit" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="updateTypeBtn" type="button" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <!-- Add Type Modal -->
        <div class="modal fade" id="addTypeModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Type</h5>
                        <button id="X-AddBtn" type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Type Name</label>
                            <div class="col-md-9">
                                <input id="TypeName-input" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button id="close-AddBtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="addType" type="button" class="btn btn-primary">Add</button>
                        </div>

                    </div>
                </div>
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

        let Type_id_Update;

        $(document).ready(function() {


            let table = $('#example').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '../<?php echo $func?>/Dashboard/getTypesTB.php',

                dom: "<'row'<'col-md-12 mb-2'B>>" +
                    "<'row m-0'<'col-md-6'l><'col-md-6'f>><'clear'>rtip",
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                order: [
                    [1, "asc"]
                ],
                columnDefs: [{
                        targets: [0, 3],
                        orderable: false,
                        searchable: false
                    },

                    {
                        className: "dt-center",
                        targets: [0, 1, 3]
                    },

                    {
                        targets: [0, 1, 3],
                        width: '0px'
                    }
                ]

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






            // Handle click on "Select all" control
            $('#example-select-all').on('click', function() {
                // Get all rows with search applied
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                countChecked();
            });

            // Handle click on checkbox to set state of "Select all" control
            $('#example tbody').on('change', 'input[type="checkbox"]', function() {
                // If checkbox is not checked
                if (!this.checked) {
                    var el = $('#example-select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });







            // Handle form submission event
            $('#delBtn').click(function() {
                var arrayDel = [];
                // Iterate over all checkboxes in the table
                table.$('input[type="checkbox"]').each(function() {
                    // If checkbox is checked
                    if (this.checked) {
                        // Create a hidden element
                        arrayDel.push($(this).attr("type-id"));
                    }
                });

                if (arrayDel.length === 0) {
                    alert("Please select rows !");
                } else {
                    $.ajax({
                        url: "../<?php echo $func; ?>Dashboard/funcsTypesTB.php",
                        method: "POST",
                        data: {
                            arrayDel: arrayDel
                        },
                        success: function(data) {
                            alert(data);
                            table.ajax.reload();

                            checked = 0;
                            printChecked();
                        }
                    })
                }

            });





            let checked = 0;
            $('#example tbody').on('change', 'input[type="checkbox"]', function() {

                // If checkbox is checked
                if (this.checked) {
                    checked += 1;
                } else {
                    checked -= 1;
                }
                printChecked();

            });

            function printChecked() {
                if (checked > 0) {
                    $("#delBtn").html('Delete Selected (' + checked + ')');
                    $("#delBtn").removeClass("disabled");
                } else {
                    $("#delBtn").html("Delete Selected");
                    $("#delBtn").addClass("disabled");
                }
            };

            function countChecked() {
                checked = 0;
                $('#example tbody input[type="checkbox"]').each(function() {
                    // If checkbox is checked
                    if (this.checked) {
                        checked += 1;
                    }
                });
                printChecked();
            }





            $("#X-AddBtn, #close-AddBtn").click(function() {
                resetAddInputs();
            })


            function inputIsEmpty(inputVal) {
                if (inputVal == '') {
                    return true;
                } else {
                    return false;
                }
            }



            $("#addType").click(function() {

                let TypeName = $("#TypeName-input").val();

                if (inputIsEmpty(TypeName)) {
                    alert("Fill all inputs please.");
                    return;
                }

                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/funcsTypesTB.php",
                    method: "POST",
                    data: {
                        action: 'insertType',
                        type_name: TypeName
                    },
                    success: function(data) {

                        alert(data);
                        $('#addTypeModal').modal('hide');
                        table.ajax.reload();

                        resetAddInputs();

                    }
                })

            });



            $("#updateTypeBtn").click(function() {

                let TypeName = $("#TypeName-input-Edit").val();

                if (inputIsEmpty(TypeName)) {
                    alert("Fill all inputs please.");
                    return;
                }

                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/funcsTypesTB.php",
                    method: "POST",
                    data: {
                        action: 'updateType',
                        type_id: type_id_Update,
                        type_name: TypeName
                    },
                    success: function(data) {

                        alert(data);
                        $('#EditTypeModal').modal('hide');
                        table.ajax.reload();

                    }
                })

            });


        });


        function UpdateType(type_id) {
            type_id_Update = type_id;

            $.ajax({
                url: "../<?php echo $func; ?>Dashboard/funcsTypesTB.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    action: 'getType',
                    type_id: type_id
                },
                success: function(data) {
                    $("#TypeName-input-Edit").val(data.type_name);
                }
            })

        };

        function resetAddInputs(){
            $("#TypeName-input").val('');
        }
        </script>


</body>

</html>