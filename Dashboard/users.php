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

    <center id="page-top">

        <?php include "../" . $tpl . "Dashboard/sidebar.php"; ?>


        <div class="container-fluid px-5 mt-5 overflow-hidden">

            <div class="row  mt-3">


                <div class="Btns mb-4">

                    <a id="addUserBtn" data-toggle="modal" data-target="#addUserModal"
                        class="btn btn-primary btn-sm px-3 py-1">Add
                        User</a>
                    <button id="delUsersBtn" class="btn btn-danger btn-sm px-3 py-1 disabled" type="delete">Delete
                        Selected</button>

                </div>

                <table id="example" class="table table-striped table-bordered" style="width:100%;">
                    <thead class="table-dark">
                        <tr>

                            <th><input id="example-select-all" class="form-check-input" type="checkbox"
                                    name="select_all" value="1"></th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>PhoneNumber</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>Gender</th>
                            <th>Coutry</th>
                            <th>KSA City</th>
                            <th>Birthday</th>
                            <th>GroupID</th>
                            <th>Datetime</th>
                            <th>loginWith</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tfoot></tfoot>
                </table>

            </div>
        </div>




        <!-- Update User Modal -->
        <div class="modal fade" id="EditUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update User</h5>
                        <button id="X-EditBtn" type="button" class="btn-close" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Username</label>
                            <div class="col-md-9">
                                <input id="username-input-Edit" type="text" class="form-control">
                                <div id="username-EditErrors"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Password</label>
                            <div class="col-md-9">
                                <input id="password-input-Edit" type="password" class="form-control"><i
                                    class="fa-regular fa-eye-slash mr-2"></i></input>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Email</label>
                            <div class="col-md-9">
                                <input id="email-input-Edit" type="email" class="form-control">
                                <div id="email-EditErrors"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Phone Number</label>
                            <div class="col-md-9">
                                <input id="PhoneNumber-input-Edit" type="number" class="form-control">
                                <div id="phoneNumber-EditErrors"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">First Name</label>
                            <div class="col-md-9">
                                <input id="FirstName-input-Edit" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Last Name</label>
                            <div class="col-md-9">
                                <input id="LastName-input-Edit" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Gender</label>
                            <div class="form-check form-check col-md-2 ml-3">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="maleGender-Edit" value="male" />
                                <label class="form-check-label">Male</label>
                            </div>

                            <div class="form-check form-check col-md-3">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="famaleGender-Edit" />
                                <label class="form-check-label">Female</label>
                            </div>

                            <div class="form-check form-check col-md-3">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="NotGender-Edit" />
                                <label class="form-check-label">Not Defined</label>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Coutry</label>
                            <div class="col-md-9">
                                <select id="country-select-Edit" class="selectpicker" title="Country"
                                    data-live-search="true" data-width="100%" data-size="5">
                                    <?php 
                                            include "../" . $func . "getCountries.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div id="city-select-Edit-Box" class="mb-3 row none">
                            <label class="col-md-3 form-label">City</label>
                            <div class="col-md-9">
                                <select id="city-select-Edit" class="selectpicker" title="city" data-live-search="true"
                                    data-width="100%" data-size="5">
                                    <option value="NULL">NULL</option>
                                    <?php 
                                            include "../" . $func . "getCities.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div id="loginWith-select-Edit-Box" class="row mb-3">
                            <label class="col-md-3 form-label">Login With</label>
                            <div class="col-md-9">
                                <select id="loginWith-select-Edit" class="selectpicker" title="Login With"
                                    data-live-search="true" data-width="100%" data-size="5">
                                    <option value="Default">Default</option>
                                    <option value="Google">Google</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="GitHub">GitHub</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Birthday</label>
                            <div class="col-md-9">
                                <input id="birtDayInput-Edit" type="date" name="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 form-label">Admin</label>
                            <div class="col-md-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="Admin-Edit">
                            </div>
                        </div>
                    </div>




                    <div class="modal-footer">
                        <button id="close-EditBtn" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button id="updateUserBtn" type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Add user Modal -->
        <div class="modal fade" id="addUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                        <button id="X-AddBtn" type="button" class="btn-close" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Username</label>
                            <div class="col-md-9">
                                <input id="username-input" type="text" class="form-control">
                                <div id="username-AddErrors"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Password</label>
                            <div class="col-md-9">
                                <input id="password-input" type="password" class="form-control"><i
                                    class="fa-regular fa-eye-slash hide mr-2"></i></input>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Email</label>
                            <div class="col-md-9">
                                <input id="email-input" type="email" class="form-control">
                                <div id="email-AddErrors"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Phone Number</label>
                            <div class="col-md-9">
                                <input id="PhoneNumber-input" type="number" class="form-control">
                                <div id="phoneNumber-AddErrors"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">First Name</label>
                            <div class="col-md-9">
                                <input id="FirstName-input" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Last Name</label>
                            <div class="col-md-9">
                                <input id="LastName-input" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Gender</label>
                            <div class="form-check form-check col-md-2 ml-3">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maleGender"
                                    value="male" />
                                <label class="form-check-label">Male</label>
                            </div>

                            <div class="form-check form-check col-md-3">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="famaleGender" />
                                <label class="form-check-label">Female</label>
                            </div>

                            <div class="form-check form-check col-md-3">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="NotGender" />
                                <label class="form-check-label">Not Defined</label>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Coutry</label>
                            <div class="col-md-9">
                                <select id="country-select" class="selectpicker" title="Country" data-live-search="true"
                                    data-width="100%" data-size="5">
                                    <?php 
                                            include "../" . $func . "getCountries.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div id="city-select-Box" class="row none mb-3">
                            <label class="col-md-3 form-label">City</label>
                            <div class="col-md-9">
                                <select id="city-select" class="selectpicker" title="city" data-live-search="true"
                                    data-width="100%" data-size="5">
                                    <option value="NULL">NULL</option>
                                    <?php 
                                            include "../" . $func . "getCities.php";
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div id="loginWith-select-Box" class="row mb-3">
                            <label class="col-md-3 form-label">Login With</label>
                            <div class="col-md-9">
                                <select id="loginWith-select" class="selectpicker" title="Login With"
                                    data-live-search="true" data-width="100%" data-size="5">
                                    <option value="Default">Default</option>
                                    <option value="Google">Google</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="GitHub">GitHub</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 form-label">Birthday</label>
                            <div class="col-md-9">
                                <input id="birtDayInput" type="date" name="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 form-label">Admin</label>
                            <div class="col-md-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="Admin">
                            </div>
                        </div>
                    </div>




                    <div class="modal-footer">
                        <button id="close-AddBtn" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button id="addUser" type="button" class="btn btn-primary">Add</button>
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
        let user_id_Update;

        $(document).ready(function() {



            let table = $('#example').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '../<?php echo $func?>/Dashboard/getUsersTB.php',

                dom: "<'row'<'col-md-12 mb-2'B>>" +
                    "<'row m-0'<'col-md-6'l><'col-md-6'f>><'clear'>rtip",
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                order: [
                    [1, "asc"]
                ],
                columnDefs: [{
                        targets: [0, 14],
                        orderable: false,
                        searchable: false
                    },

                    {
                        className: "dt-center",
                        targets: "_all"
                    },

                    {
                        targets: [0, 1, 7, 11, 14],
                        width: '0px'
                    },

                    {
                        targets: [12],
                        width: '5%'
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
            $('#delUsersBtn').click(function() {
                var usersDel = [];
                // Iterate over all checkboxes in the table
                table.$('input[type="checkbox"]').each(function() {
                    // If checkbox is checked
                    if (this.checked) {
                        // Create a hidden element
                        usersDel.push($(this).attr("user-id"));
                    }
                });

                if (usersDel.length === 0) {
                    alert("Please select rows !");
                } else {
                    $.ajax({
                        url: "../<?php echo $func; ?>Dashboard/funcsUsersTB.php",
                        method: "POST",
                        data: {
                            usersDel: usersDel
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
                    $("#delUsersBtn").html('Delete Selected (' + checked + ')');
                    $("#delUsersBtn").removeClass("disabled");
                } else {
                    $("#delUsersBtn").html("Delete Selected");
                    $("#delUsersBtn").addClass("disabled");
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



            // show (city) dropdown if Country is Saudi Arabia, and hide it if else.
            // for Add.
            $("#country-select").change(function() {
                let country_id = $(this).val();
                if (country_id == 190) {
                    if ($("#city-select-Box").is(":hidden")) {
                        $("#city-select-Box").slideDown({
                            start: function() {
                                $(this).css({
                                    display: "flex"
                                })
                            }
                        });

                    }
                } else {
                    if ($("#city-select-Box").is(":visible")) {
                        $("#city-select-Box").slideUp();
                        $("#city-select").selectpicker('val', '');
                    }
                }
            });

            // show (city) dropdown if Country is Saudi Arabia, and hide it if else.
            // for Edit.
            $("#country-select-Edit").change(function() {
                let country_id = $(this).val();
                if (country_id == 190) {
                    if ($("#city-select-Edit-Box").is(":hidden")) {
                        $("#city-select-Edit-Box").slideDown({
                            start: function() {
                                $(this).css({
                                    display: "flex"
                                })
                            }
                        });

                    }
                } else {
                    if ($("#city-select-Edit-Box").is(":visible")) {
                        $("#city-select-Edit-Box").slideUp();
                        $("#city-select-Edit").selectpicker('val', '');
                    }
                }
            });



            $("#city-select-Edit").change(function() {
                let city_id = $(this).val();
                if (city_id == 'NULL') {
                    $("#city-select-Edit").selectpicker('val', '');
                }
            })
            $("#city-select").change(function() {
                let city_id = $(this).val();
                if (city_id == 'NULL') {
                    $("#city-select").selectpicker('val', '');
                }
            })


            $('#PhoneNumber-input, #PhoneNumber-input-Edit').keyup(function() {
                if ($(this).val().length > 10) {
                    let val = $(this).val();
                    $(this).val(val.substring(0, 10));
                }
            })


            $("#X-AddBtn, #close-AddBtn").click(function() {
                resetAddInputs();
                removeAddErrors();
            })
            $("#X-EditBtn, #close-EditBtn").click(function() {
                removeEditErrors();
            })





            $("#addUser").click(function() {

                let Username = $("#username-input").val();
                let Password = $("#password-input").val();
                let Email = $("#email-input").val();
                let PhoneNumber = $("#PhoneNumber-input").val();
                let FirstName = $("#FirstName-input").val();
                let LastName = $("#LastName-input").val();

                //Get Gender value.
                let Gender;
                if ($('#maleGender').is(':checked')) {
                    Gender = "Male";
                } else if ($('#famaleGender').is(':checked')) {
                    Gender = "Female";
                } else if ($('#NotGender').is(':checked')) {
                    Gender = "Not Defined";
                }

                console.log($('#NotGender'));
                console.log(Gender);

                let country_id = $("#country-select").val();
                let city_id = $("#city-select").val();
                let loginWith = $("#loginWith-select").val();
                let Birthday = $("#birtDayInput").val();

                //Get GroupID value.
                let GroupID;
                if ($("#Admin").is(":checked")) {
                    GroupID = 1;
                } else {
                    GroupID = 0;
                }


                if (loginWith == 'Default') {
                    if (inputIsEmpty(Username) || inputIsEmpty(Password) || inputIsEmpty(Email) ||
                        inputIsEmpty(PhoneNumber) || inputIsEmpty(FirstName) || inputIsEmpty(
                            LastName) ||
                        inputIsEmpty(country_id) || (typeof Gender === "undefined") ||
                        inputIsEmpty(Birthday) || (country_id == 190 && inputIsEmpty(city_id))) {
                        alert("Fill all inputs please.");
                        return;
                    }
                } else {
                    if (inputIsEmpty(Username) || inputIsEmpty(Password) || (typeof Gender ===
                            "undefined") ||
                        inputIsEmpty(loginWith) || (country_id == 190 && inputIsEmpty(city_id))) {
                        alert("Fill all inputs please.");
                        return;
                    }
                }


                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/funcsUsersTB.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: 'insertUser',
                        Username: Username,
                        Password: Password,
                        Email: Email,
                        PhoneNumber: PhoneNumber,
                        FirstName: FirstName,
                        LastName: LastName,
                        Gender: Gender,
                        country_id: country_id,
                        city_id: city_id,
                        loginWith: loginWith,
                        Birthday: Birthday,
                        GroupID: GroupID
                    },
                    success: function(data) {

                        if (data.code == 1 && !$.isArray(data)) {
                            alert(data.message);
                            $('#addUserModal').modal('hide');
                            table.ajax.reload();
                            resetAddInputs();
                            removeAddErrors();
                        } else {

                            errorTypes = ['username', 'email', 'phoneNumber'];

                            data.forEach(e => {
                                if (e.code == 0) {

                                    if (e.type == 'username') {
                                        errorBox = $('#' + e.type + '-AddErrors');
                                        if (isEmpty(errorBox)) {
                                            errorBox.append(
                                                '<small class="error">' + e
                                                .message + '</small>');
                                        } else if (errorBox.find('small').val() != e
                                            .message) {
                                            errorBox.find('small').text(e.message);
                                        }
                                        removeInArr(errorTypes, 'username');
                                    } else if (e.type == 'email') {
                                        errorBox = $('#' + e.type + '-AddErrors');
                                        if (isEmpty(errorBox)) {
                                            errorBox.append(
                                                '<small class="error">' + e
                                                .message + '</small>');
                                        } else if (errorBox.find('small').val() != e
                                            .message) {
                                            errorBox.find('small').text(e.message);
                                        }
                                        removeInArr(errorTypes, 'email');
                                    } else if (e.type == 'phoneNumber') {
                                        errorBox = $('#' + e.type + '-AddErrors');
                                        if (isEmpty(errorBox)) {
                                            errorBox.append(
                                                '<small class="error">' + e
                                                .message + '</small>');
                                        } else if (errorBox.find('small').val() != e
                                            .message) {
                                            errorBox.find('small').text(e.message);
                                        }
                                        removeInArr(errorTypes, 'phoneNumber');
                                    }
                                }
                            });

                            if (!isEmptyArr(errorTypes)) {
                                errorTypes.forEach(type => {
                                    errorBox = $('#' + type + '-AddErrors');
                                    errorBox.text('');
                                });
                            }

                        }

                    }
                })

            });






            $("#updateUserBtn").click(function() {


                let Username = $("#username-input-Edit").val();
                let Password = $("#password-input-Edit").val();
                let Email = $("#email-input-Edit").val();
                let PhoneNumber = $("#PhoneNumber-input-Edit").val();
                let FirstName = $("#FirstName-input-Edit").val();
                let LastName = $("#LastName-input-Edit").val();

                //Set Gender value.
                let Gender;
                if ($('#maleGender-Edit').is(':checked')) {
                    Gender = "Male";
                } else if ($('#famaleGender-Edit').is(':checked')) {
                    Gender = "Female";
                } else if ($('#NotGender-Edit').is(':checked')) {
                    Gender = "Not Defined";
                }

                let country_id = $("#country-select-Edit").val();
                let city_id = $("#city-select-Edit").val();
                let loginWith = $("#loginWith-select-Edit").val();
                let Birthday = $("#birtDayInput-Edit").val();

                //Set GroupID value.
                let GroupID;
                if ($("#Admin-Edit").is(":checked")) {
                    GroupID = 1;
                } else {
                    GroupID = 0;
                }

                if (loginWith == 'Default') {
                    if (inputIsEmpty(Username) || inputIsEmpty(Password) || inputIsEmpty(Email) ||
                        inputIsEmpty(PhoneNumber) || inputIsEmpty(FirstName) || inputIsEmpty(
                            LastName) ||
                        inputIsEmpty(country_id) || (typeof Gender === "undefined") ||
                        inputIsEmpty(Birthday) || (country_id == 190 && inputIsEmpty(city_id))) {
                        alert("Fill all inputs please.");
                        return;
                    }
                } else {
                    if (inputIsEmpty(Username) || inputIsEmpty(Password) || (typeof Gender ===
                            "undefined") ||
                        inputIsEmpty(loginWith) || (country_id == 190 && inputIsEmpty(city_id))) {
                        alert("Fill all inputs please.");
                        return;
                    }
                }



                $.ajax({
                    url: "../<?php echo $func; ?>Dashboard/funcsUsersTB.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: 'updateUser',
                        UserID: user_id_Update,
                        Username: Username,
                        Password: Password,
                        Email: Email,
                        PhoneNumber: PhoneNumber,
                        FirstName: FirstName,
                        LastName: LastName,
                        Gender: Gender,
                        country_id: country_id,
                        city_id: city_id,
                        loginWith: loginWith,
                        Birthday: Birthday,
                        GroupID: GroupID
                    },
                    success: function(data) {

                        if (data.code == 1 && !$.isArray(data)) {
                            alert(data.message);
                            $('#EditUserModal').modal('hide');
                            table.ajax.reload();
                            removeEditErrors();
                        } else {
                            errorTypes = ['username', 'email', 'phoneNumber'];

                            data.forEach(e => {
                                if (e.code == 0) {

                                    if (e.type == 'username') {
                                        errorBox = $('#' + e.type + '-EditErrors');
                                        if (isEmpty(errorBox)) {
                                            errorBox.append(
                                                '<small class="error">' + e
                                                .message + '</small>');
                                        } else if (errorBox.find('small').val() != e
                                            .message) {
                                            errorBox.find('small').text(e.message);
                                        }
                                        removeInArr(errorTypes, 'username');
                                    } else if (e.type == 'email') {
                                        errorBox = $('#' + e.type + '-EditErrors');
                                        if (isEmpty(errorBox)) {
                                            errorBox.append(
                                                '<small class="error">' + e
                                                .message + '</small>');
                                        } else if (errorBox.find('small').val() != e
                                            .message) {
                                            errorBox.find('small').text(e.message);
                                        }
                                        removeInArr(errorTypes, 'email');
                                    } else if (e.type == 'phoneNumber') {
                                        errorBox = $('#' + e.type + '-EditErrors');
                                        if (isEmpty(errorBox)) {
                                            errorBox.append(
                                                '<small class="error">' + e
                                                .message + '</small>');
                                        } else if (errorBox.find('small').val() != e
                                            .message) {
                                            errorBox.find('small').text(e.message);
                                        }
                                        removeInArr(errorTypes, 'phoneNumber');
                                    }
                                }
                            });

                            if (!isEmptyArr(errorTypes)) {
                                errorTypes.forEach(type => {
                                    errorBox = $('#' + type + '-EditErrors');
                                    errorBox.text('');
                                });
                            }

                        }

                    }
                })

            });


        });


        function UpdateUser(user_id) {
            user_id_Update = user_id;

            $.ajax({
                url: "../<?php echo $func; ?>Dashboard/funcsUsersTB.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    action: 'getUser',
                    user_id: user_id
                },
                success: function(data) {

                    $("#username-input-Edit").val(data.Username);
                    $("#password-input-Edit").val(data.Password);
                    $("#email-input-Edit").val(data.Email);
                    $("#PhoneNumber-input-Edit").val(data.PhoneNumber);
                    $("#FirstName-input-Edit").val(data.FirstName);
                    $("#LastName-input-Edit").val(data.LastName);

                    if (data.Gender == "Male") {
                        $('#maleGender-Edit').prop('checked', true);
                    } else if (data.Gender == "Female") {
                        $('#famaleGender-Edit').prop('checked', true);
                    } else if (data.Gender == "Not Defined") {
                        $('#NotGender-Edit').prop('checked', true);
                    } else {
                        alert("Gender is not (Male) or (Famale) or (Not Defined).");
                    }

                    $("#country-select-Edit").selectpicker('val', data.country_id);

                    if (data.country_id == 190 && data.city_id != '') {
                        if ($('#city-select-Edit-Box').hasClass('none')) {
                            $('#city-select-Edit-Box').removeClass('none');
                        }
                        $("#city-select-Edit").selectpicker('val', data.city_id);
                    } else {
                        if (!$('#city-select-Edit-Box').hasClass('none')) {
                            $('#city-select-Edit-Box').addClass('none');
                        }
                        $("#city-select-Edit").selectpicker('val', '');
                    }
                    console.log(data.loginWith);
                    $("#loginWith-select-Edit").selectpicker('val', data.loginWith);

                    $("#birtDayInput-Edit").val(data.Birthday);


                    if (data.GroupID == 1) {
                        $('#Admin-Edit').prop('checked', true);
                    } else if (data.GroupID == 0) {
                        $('#Admin-Edit').prop('checked', false);
                    } else {
                        alert("GroupID it`s not (0) or (1).");
                    }
                }
            })

        };


        function inputIsEmpty(inputVal) {
            if (inputVal == '') {
                return true;
            } else {
                return false;
            }
        }

        function DeleteValues(input) {
            input.val('');
        }

        function resetAddInputs() {
            DeleteValues($("#username-input"));
            DeleteValues($("#password-input"));
            DeleteValues($("#email-input"));
            DeleteValues($("#PhoneNumber-input"));
            DeleteValues($("#FirstName-input"));
            DeleteValues($("#LastName-input"));
            $('#maleGender').prop('checked', false);
            $('#famaleGender').prop('checked', false);
            $('#NotGender').prop('checked', false);
            $("#country-select").selectpicker('val', '');
            $("#city-select").selectpicker('val', '');
            $("#loginWith-select").selectpicker('val', '');
            $("#birtDayInput").val("yyyy-MM-dd");
            $('#Admin').prop('checked', false);
        }


        function removeInArr(arr) {
            var what, a = arguments,
                L = a.length,
                ax;
            while (L > 1 && arr.length) {
                what = a[--L];
                while ((ax = arr.indexOf(what)) !== -1) {
                    arr.splice(ax, 1);
                }
            }
            return arr;
        }

        function isEmpty(e) {
            if (e.text() == '') {
                return true;
            } else {
                return false
            }
        }

        function isEmptyArr(e) {
            if (e == '') {
                return true;
            } else {
                return false
            }
        }

        function removeAddErrors() {
            $('#username-AddErrors').text('');
            $('#email-AddErrors').text('');
            $('#phoneNumber-AddErrors').text('');
        }

        function removeEditErrors() {
            $('#username-EditErrors').text('');
            $('#email-EditErrors').text('');
            $('#phoneNumber-EditErrors').text('');
        }
        </script>


</body>

</html>