<?php
session_start();

if( !isset($_SESSION['UserID']) ){
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['UserID'];

include "init.php";
include $func.'connect.php';
include $langs . "English.php";
$title = "SportPath - Profile";



function getCountry($id){
    global $conn;

    $sql = "SELECT country_name FROM countries WHERE country_id ='$id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$countryRow = $result->fetch_assoc();
        return $countryRow['country_name'];

    	}
	else {
		echo "Not found country name from this id, 
        Or there`s tow country they have same id.";
	}
}


function getSAcity($id){
    global $conn;

    $sql = "SELECT nameEn FROM sa_cities WHERE id ='$id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$row = $result->fetch_assoc();
        return $row['nameEn'];

    	}
	else {
		echo "Not found city name from this id, 
        Or there`s tow city they have same id.";
	}
}




$sql = "SELECT * FROM users WHERE UserID=$user_id";
$result = $conn->query($sql);

// if the get is one row.
if ($result->num_rows > 0 && 2 > $result->num_rows) {  
    $userRow = $result->fetch_assoc();

} else {
    echo "there's no user in (users) table, or there`s 2 user they have same ID.";
}


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

    <center id="page-top">


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <h1 class="text-center border-bottom pt-4 pb-3">Profile</h1>

                <!-- Begin Page Content -->
                <div class="container py-5">

                    <div class="col">



                        <div class="row justify-content-center align-items-center mb-4">
                            <div class="col-7">
                                <div id="secc-box"></div>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <div class="col-7 d-flex flex-row-reverse">
                                <button id="ChangePass" class="btn btn-primary" data-toggle="modal"
                                    data-target="#ChangePassModal"><i class="fa-solid fa-key"></i> Change
                                    Password</button>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Username:</label>
                            <div class="col-5">
                                <input id="Username" type="text" class="form-control"
                                    value="<?php echo $userRow['Username'];?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Email:</label>
                            <div class="col-5">
                                <input id="Email" type="text" class="form-control"
                                    value="<?php echo $userRow['Email'];?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Phone Number:</label>
                            <div class="col-5">
                                <input id="PhoneNumber" type="text" class="form-control"
                                    value="<?php echo $userRow['PhoneNumber'];?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">First Name:</label>
                            <div class="col-5">
                                <input id="FirstName" type="text" class="form-control"
                                    value="<?php echo $userRow['FirstName'];?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Last Name:</label>
                            <div class="col-5">
                                <input id="LastName" type="text" class="form-control"
                                    value="<?php echo $userRow['LastName'];?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Gender:</label>
                            <div class="col-5">
                                <input id="Gender" type="text" class="form-control"
                                    value="<?php echo $userRow['Gender'];?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Country:</label>
                            <div class="col-5">
                                <input id="Country" type="text" class="form-control"
                                    value="<?php echo getCountry($userRow['country_id']);?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">City:</label>
                            <div class="col-5">
                                <input id="City" type="text" class="form-control" value="<?php if($userRow['city_id'] == NULL){
                                        echo 'NULL';
                                    }else{
                                        echo getSAcity($userRow['city_id']);
                                    }?>" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mb-4">
                            <label class="col-2 form-label">Birthday:</label>
                            <div class="col-5">
                                <input id="Birthday" type="text" class="form-control"
                                    value="<?php echo date('d/m/Y', strtotime($userRow['Birthday']));?>" disabled>
                            </div>
                        </div>



                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </center>

    <footer>
        <!-- inclodes footer -->
        <?php
        include $tpl . "footer.php";
        ?>
    </footer>



    <!-- Update Type Modal -->
    <div class="modal fade" id="ChangePassModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                    <button id="X-Btn" type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100">
                        <div class="row resetBox mb-3">
                            <div class="col-md-12">
                                <div class="input-group group mb-0">
                                    <input id="OldPassword-input" type="password"><i
                                        class="fa-regular fa-eye-slash hide"></i></input>
                                    <label class="form-label" for="OldPassword-input">Old Password</label>
                                </div>
                                <div id="oldPassword-errors"></div>
                            </div>
                        </div>

                        <div class="row resetBox mb-3">
                            <div class="col-md-12">
                                <div class="input-group group mb-0">
                                    <input id="NewPassword-input" type="password"><i
                                        class="fa-regular fa-eye-slash hide"></i></input>
                                    <label class="form-label" for="NewPassword-input">New Password</label>
                                </div>
                                <div id="newPassword-errors"></div>
                            </div>
                        </div>

                        <div class="row resetBox mb-3">
                            <div class="col-md-12">
                                <div class="input-group group mb-0">
                                    <input id="RepeatNewPassword-input" type="password"><i
                                        class="fa-regular fa-eye-slash hide"></i></input>
                                    <label class="form-label" for="RepeatNewPassword-input">Repeat New Password</label>
                                </div>
                                <div id="repeatNewPassword-errors"></div>
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button id="closeBtn" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button id="ChangePassBtn" type="button" class="btn btn-primary">Change</button>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <!-- inclodes Js libraries -->
    <?php
    include $tpl . "libraries.php";
    ?>




    <script type="text/javascript">
    $(document).ready(function() {


        $("#closeBtn, #X-Btn").click(function() {
            removeErrors();
            resetInputs();
        })

        $("#ChangePassBtn").click(function() {

            let UserID = <?php echo $user_id; ?>;
            let OldPassword = $("#OldPassword-input").val();
            let NewPassword = $("#NewPassword-input").val();
            let RepeatNewPassword = $("#RepeatNewPassword-input").val();

            $.ajax({
                url: "<?php echo $func; ?>ChangePass.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: 'ChangePassword',
                    UserID: UserID,
                    OldPassword: OldPassword,
                    NewPassword: NewPassword,
                    RepeatNewPassword: RepeatNewPassword
                },
                success: function(data) {

                    if (data.code == 1 && !$.isArray(data)) {
                        $('#ChangePassModal').modal('hide');
                        removeErrors();
                        resetInputs();

                        if (isEmpty($('#secc-box'))) {
                            $('#secc-box').append(
                                '<div id="secc-message" class="alert alert-success" role="alert">' +
                                data.message + '</div>');
                            $('#secc-box').slideDown().delay(10);

                            setTimeout(function() {
                                $('#secc-box').slideUp('slow');
                                setTimeout(function() {
                                    $('#secc-box').text('');
                                }, 500);
                            }, 3000);
                        }

                    } else {

                        errorTypes = ['oldPassword', 'newPassword', 'repeatNewPassword'];

                        data.forEach(e => {
                            if (e.code == 0) {

                                if (e.type == 'oldPassword') {
                                    errorBox = $('#oldPassword-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    } else if (errorBox.find('small').val() != e
                                        .message) {
                                        errorBox.find('small').text(e.message);
                                    }

                                    input = errorBox.parent().find('div input');
                                    label = errorBox.parent().find('div label');
                                    input.addClass("input-error");
                                    label.addClass("label-error");

                                    removeInArr(errorTypes, 'oldPassword');
                                }

                                if (e.type == 'newPassword') {
                                    errorBox = $('#newPassword-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    } else if (errorBox.find('small').val() != e
                                        .message) {
                                        errorBox.find('small').text(e.message);
                                    }

                                    input = errorBox.parent().find('div input');
                                    label = errorBox.parent().find('div label');
                                    input.addClass("input-error");
                                    label.addClass("label-error");

                                    removeInArr(errorTypes, 'newPassword');
                                }

                                if (e.type == 'repeatNewPassword') {
                                    errorBox = $('#repeatNewPassword-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    } else if (errorBox.find('small').val() != e
                                        .message) {
                                        errorBox.find('small').text(e.message);
                                    }

                                    input = errorBox.parent().find('div input');
                                    label = errorBox.parent().find('div label');
                                    input.addClass("input-error");
                                    label.addClass("label-error");

                                    removeInArr(errorTypes, 'repeatNewPassword');
                                }

                            }
                        });

                        if (!isEmptyArr(errorTypes)) {
                            errorTypes.forEach(type => {
                                errorBox = $('#' + type + '-errors');
                                errorBox.text('');

                                input = errorBox.parent().find('div input');
                                label = errorBox.parent().find('div label');
                                input.removeClass('input-error');
                                label.removeClass('label-error');
                            });
                        }

                    }




                }
            })

        });

    });



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

    function removeErrors() {
        errorTypes = ['oldPassword', 'newPassword', 'repeatNewPassword'];

        errorTypes.forEach(type => {
            errorBox = $('#' + type + '-errors');
            errorBox.text('');

            input = errorBox.parent().find('div input');
            label = errorBox.parent().find('div label');
            
            if(!$(input).siblings('.fa-regular').hasClass('hide')){
                $(input).siblings('.fa-regular').addClass('hide');
            }

            if(input.hasClass('input-error')){
                input.removeClass('input-error');
            }
            if(label.hasClass('label-error')){
                label.removeClass('label-error');
            }
            
        });
    }

    function resetInputs() {
        $('#OldPassword-input').val('');
        $('#NewPassword-input').val('');
        $('#RepeatNewPassword-input').val('');
    }
    </script>





</body>

</html>