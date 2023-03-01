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
                    <a id="addCourseBtn" data-toggle="modal" data-target="#addCourseModal"
                        class="btn btn-primary btn-sm px-3 py-1">Add
                        Course</a>
                    <button id="delBtn" class="btn btn-danger btn-sm px-3 py-1 disabled" type="delete">Delete
                        Selected</button>
                </div>



                <table id="example" class="table table-striped table-bordered hover dt[-head|-body]-center"
                    style="width:100%;">
                    <thead class="table-dark">
                        <tr>

                            <th><input id="example-select-all" class="form-check-input" type="checkbox"
                                    name="select_all" value="1"></th>
                            <th>ID</th>
                            <th>Course Image</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Group Of Age</th>
                            <th>API_ID</th>
                            <th>Playlist Name</th>
                            <th>Playlist_ID</th>
                            <th>Datetime</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tfoot></tfoot>
                </table>

            </div>
        </div>




        <!-- Update Course Modal -->
        <div class="modal fade" id="EditCourseModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Course</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">API_ID</label>
                            <div class="col-md-9">
                                <select id="API_ID-select-Edit" class="selectpicker" title="All API_IDs"
                                    data-width="40%" data-size="5">
                                    <?php 
                                            include "../" . $func . "Dashboard/getCoursesAPI.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Playlist Name</label>
                            <div class="col-md-9">
                                <input id="PlaylistName-input-Edit" type="text" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Playlist id</label>
                            <div class="col-md-9">
                                <input id="PlaylistId-input-Edit" type="text" class="form-control" disabled>
                            </div>
                        </div>




                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Course Name</label>
                            <div class="col-md-9">
                                <input id="CourseName-input-Edit" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Type</label>
                            <div class="col-md-9">
                                <select id="Type-select-Edit" class="selectpicker" title="All Types"
                                    data-live-search="true" data-width="100%" data-size="5">
                                    <?php 
                                            include "../" . $func . "Dashboard/getTypes.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Group Of Age</label>
                            <div class="col-md-9">
                                <input id="GroupOfAge-input-Edit" type="number" class="form-control">
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Description</label>
                            <div class="col-md-9">
                                <textarea id="Description-input-Edit" class="form-control"
                                    placeholder="Write Course Description" rows="4"></textarea>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Requirements</label>
                            <div class="col-md-9">
                                <textarea id="Requirements-input-Edit" class="form-control"
                                    placeholder="Write Course Requirements" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Course Image</label>
                            <div class="col-md-9">
                                <input type="file" name="CourseImage" class="form-control"
                                    id="CourseImage-input-Edit" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div id="image-box"></div>
                        </div>




                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="updateCourseBtn" type="button" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <!-- Add Course Modal -->
        <div class="modal fade" id="addCourseModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Course</h5>
                        <button id="X-AddBtn" type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">API_ID</label>
                            <div class="col-md-9">
                                <select id="API_ID-select" class="selectpicker" title="All API_IDs" data-width="40%"
                                    data-size="5">
                                    <?php 
                                            include "../" . $func . "Dashboard/getCoursesAPI.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Playlist Name</label>
                            <div class="col-md-9">
                                <input id="PlaylistName-input" type="text" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="mb-5 row">
                            <label class="col-md-3 form-label">Playlist id</label>
                            <div class="col-md-9">
                                <input id="PlaylistId-input" type="text" class="form-control" disabled>
                            </div>
                        </div>




                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Course Name</label>
                            <div class="col-md-9">
                                <input id="CourseName-input" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Type</label>
                            <div class="col-md-9">
                                <select id="Type-select" class="selectpicker" title="All Types" data-live-search="true"
                                    data-width="100%" data-size="5">
                                    <?php 
                                            include "../" . $func . "Dashboard/getTypes.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Group Of Age</label>
                            <div class="col-md-9">
                                <input id="GroupOfAge-input" type="number" class="form-control">
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Description</label>
                            <div class="col-md-9">
                                <textarea id="Description-input" class="form-control"
                                    placeholder="Write Course Description" rows="4"></textarea>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Requirements</label>
                            <div class="col-md-9">
                                <textarea id="Requirements-input" class="form-control"
                                    placeholder="Write Course Requirements" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Course Image</label>
                            <div class="col-md-9">
                                <input type="file" name="CourseImage" class="form-control" id="CourseImage-input" />
                            </div>
                        </div>




                        <div class="modal-footer">
                            <button id="close-AddBtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="addCourse" type="button" class="btn btn-primary">Add</button>
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
        $('#API_ID-select').on('change', function() {
            let API_id = this.value;

            $.ajax({
                url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    action: "getPlaylistName&ID",
                    API_id: API_id
                },
                success: function(data) {

                    $('#PlaylistName-input').val(data.playlistName);
                    $('#PlaylistId-input').val(data.playlistId);
                    $('#CourseName-input').val(data.playlistName);
                }
            })
        });

        $('#API_ID-select-Edit').on('change', function() {
            let API_id = this.value;

            $.ajax({
                url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    action: "getPlaylistName&ID",
                    API_id: API_id
                },
                success: function(data) {

                    $('#PlaylistName-input-Edit').val(data.playlistName);
                    $('#PlaylistId-input-Edit').val(data.playlistId);
                }
            })
        });









        let course_id_Update;

        $(document).ready(function() {


            let table = $('#example').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '../<?php echo $func?>/Dashboard/getCoursesTB.php',

                dom: "<'row'<'col-md-12 mb-2'B>>" +
                    "<'row m-0'<'col-md-6'l><'col-md-6'f>><'clear'>rtip",
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                order: [
                    [1, "asc"]
                ],
                columnDefs: [{
                        targets: [0, 2, 10],
                        orderable: false,
                        searchable: false
                    },

                    {
                        className: "dt-center",
                        targets: "_all"
                    },

                    {
                        targets: [0, 1, 6, 10],
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
                        arrayDel.push($(this).attr("course-id"));
                    }
                });

                if (arrayDel.length === 0) {
                    alert("Please select rows !");
                } else {
                    $.ajax({
                        url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
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



            $('#GroupOfAge-input, #GroupOfAge-input-Edit').keyup(function() {
                let limit = 2
                if ($(this).val().length > limit) {
                    let val = $(this).val();
                    $(this).val(val.substring(0, limit));
                }
            })

            $("#X-AddBtn, #close-AddBtn").click(function(){
                resetAddInputs(); 
            })


            function inputIsEmpty(inputVal) {
                if (inputVal == '') {
                    return true;
                } else {
                    return false;
                }
            }



            $("#addCourse").click(function() {


                let API_ID = $("#API_ID-select").val();
                let CourseName = $("#CourseName-input").val();
                let Type = $("#Type-select").val();
                let GroupOfAge = $("#GroupOfAge-input").val();
                let Description = $("#Description-input").val();
                let Requirements = $("#Requirements-input").val();

                let CourseImage = $("#CourseImage-input");

                if (inputIsEmpty(API_ID) || inputIsEmpty(CourseName) || inputIsEmpty(Type) ||
                    inputIsEmpty(GroupOfAge) || inputIsEmpty(Description) || inputIsEmpty(
                        Requirements)) {
                    alert("Fill all inputs please.");
                    return;
                } else if (document.getElementById("CourseImage-input").files.length == 0) {
                    alert("Uplude course image please.");
                    return;
                } else {

                    var file = $('#CourseImage-input')[0].files[0];
                    var image_extension = file.name.split('.').pop().toLowerCase();
                    if (jQuery.inArray(image_extension, ['gif', 'jpg', 'jpeg', 'png', '']) == -1) {
                        alert("Invalid image file\nonly JPG, JPEG, PNG & GIF files are allowed.");
                        return;
                    }

                }

                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        action: 'insertCourse',
                        API_ID: API_ID,
                        CourseName: CourseName,
                        Type: Type,
                        GroupOfAge: GroupOfAge,
                        Description: Description,
                        Requirements: Requirements

                    },
                    success: function(data) {


                        if (typeof(data.message) != "undefined" && data.message !==
                            null) {
                            alert(data.message);
                            uploadImageCourse("CourseImage-input", data.inserted_id,
                                CourseName); //imageInputID,Courseid,CourseName
                        } else {
                            alert(data);
                        }
                        $('#addCourseModal').modal('hide');
                        table.ajax.reload();

                        resetAddInputs();
                    }
                })

            });



            function uploadImageCourse(imageInputID, course_id, course_name) {

                var file_data = $('#' + imageInputID)[0].files[0];
                var image_name = file_data.name;
                var image_extension = image_name.split('.').pop().toLowerCase();

                var form_data = new FormData();
                form_data.append("file", file_data);
                form_data.append("course_id", course_id);
                form_data.append("course_name", course_name);

                $.ajax({
                    url: '../<?php echo $func; ?>Dashboard/funcsCoursesTB.php',
                    method: 'POST',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: form_data,
                    success: function(data) {
                        console.log(data);
                        // $(".Btns").html(data);
                    }
                });



            }






            $("#updateCourseBtn").click(function() {
                let haveImage = false;

                let API_ID = $("#API_ID-select-Edit").val();
                let CourseName = $("#CourseName-input-Edit").val();
                let Type = $("#Type-select-Edit").val();
                let GroupOfAge = $("#GroupOfAge-input-Edit").val();
                let Description = $("#Description-input-Edit").val();
                let Requirements = $("#Requirements-input-Edit").val();

                if (inputIsEmpty(API_ID) || inputIsEmpty(CourseName) || inputIsEmpty(Type) ||
                    inputIsEmpty(GroupOfAge) || inputIsEmpty(Description) || inputIsEmpty(
                        Requirements)) {
                    alert("Fill all inputs please.");
                    return;
                } else if (!(document.getElementById("CourseImage-input-Edit").files.length == 0)) {

                    var file = $('#CourseImage-input-Edit')[0].files[0];
                    var image_extension = file.name.split('.').pop().toLowerCase();
                    haveImage = true;

                    if (jQuery.inArray(image_extension, ['gif', 'jpg', 'jpeg', 'png', '']) == -1) {
                        alert("Invalid image file\nonly JPG, JPEG, PNG & GIF files are allowed.");
                        return;
                    }
                }

                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
                    method: "POST",
                    data: {
                        action: 'updateCourse',
                        course_id: course_id_Update,
                        API_ID: API_ID,
                        CourseName: CourseName,
                        Type: Type,
                        GroupOfAge: GroupOfAge,
                        Description: Description,
                        Requirements: Requirements
                    },
                    success: function(data) {


                        if (haveImage == true) {
                            uploadImageCourse("CourseImage-input-Edit", course_id_Update,
                                CourseName); //imageInputID,course_id,CourseName
                        }
                        alert(data);
                        $('#EditCourseModal').modal('hide');
                        table.ajax.reload();

                    }
                })

            });


        });


        function UpdateCourse(course_id) {
            course_id_Update = course_id;

            $.ajax({
                url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    action: 'getCourse',
                    course_id: course_id
                },
                success: function(data) {

                    $("#API_ID-select-Edit").selectpicker('val', data.API_id);
                    $("#CourseName-input-Edit").val(data.course_name);
                    $("#Type-select-Edit").selectpicker('val', data.type_id);
                    $("#GroupOfAge-input-Edit").val(data.group_age);
                    $("#Description-input-Edit").val(data.Description);
                    $("#Requirements-input-Edit").val(data.Requirements);
                    $("#image-box").html(
                        `<img src="${data.ImageCourse}" alt="Course Image" style="width:300px;">`);

                    $.ajax({
                        url: "../<?php echo $func; ?>Dashboard/funcsCoursesTB.php",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            action: "getPlaylistName&ID",
                            API_id: data.API_id
                        },
                        success: function(data) {

                            $('#PlaylistName-input-Edit').val(data.playlistName);
                            $('#PlaylistId-input-Edit').val(data.playlistId);
                        }
                    })

                }
            })

        };


        function DeleteValues(input) {
                input.val('');
            }

        function resetAddInputs() {

            $("#API_ID-select").selectpicker('val', '');
            DeleteValues($("#PlaylistName-input"));
            DeleteValues($("#PlaylistId-input"));
            DeleteValues($("#CourseName-input"));
            $("#Type-select").selectpicker('val', '');
            DeleteValues($("#GroupOfAge-input"));
            DeleteValues($("#Description-input"));
            DeleteValues($("#Requirements-input"));
            DeleteValues($("#CourseImage-input"));
        }
        </script>


</body>

</html>