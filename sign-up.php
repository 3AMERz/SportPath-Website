<?php
session_start();

if(isset($_SESSION['Username'])){
    header('Location: index.php');
    exit();
}


include "init.php";
include $func.'connect.php';
include $langs . "English.php";
$title = "SportPath - Sign Up";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include $tpl . "head.php";
    ?>

</head>


<body>

    <header>
        <?php
        include $tpl . "header.php";
        ?>
    </header>


    <center>

        <section class="gradient-form section-of-middle-box py-5">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6 d-flex align-items-center">
                                    <div class="card-body p-md-5 mx-md-4">

                                        <div class="text-center">
                                            <h1 class="mt-1 mb-5 pb-1">Sign Up</h1>
                                        </div>

                                        <form>

                                            <div id="secc-box" class="mb-3"></div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="input-group group m-0">
                                                        <input id="FirstName-input" type="text">
                                                        <label class="form-label" for="FirstName-input">First
                                                            Name</label>
                                                    </div>
                                                    <div id="firstName-errors"></div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="input-group group mb-0">
                                                        <input id="LastName-input" type="text">
                                                        <label class="form-label" for="LastName-input">Last Name</label>
                                                    </div>
                                                    <div id="lastName-errors"></div>
                                                </div>
                                            </div>

                                            <div class="mb-4">

                                                <span id="availableOrNotBox"></span>

                                                <div class="input-group group m-0">
                                                    <input id="Username-input" type="text">
                                                    <label class="form-label" for="Username-input">Username</label>
                                                </div>
                                                <div id="username-errors"></div>

                                                <div id="username-info"
                                                    class="alert alert-primary position-absolute z-index-2 rounded-0 p-2 mt-2"
                                                    role="alert">
                                                    <small><i class="fa-solid fa-circle-info"></i> <b> Must be :</b>
                                                        <hr class="m-1"> *At least <b>3</b> characters <br> *Must start
                                                        with a
                                                        letter
                                                    </small>
                                                </div>
                                            </div>


                                            <div class="row mb-4">
                                                <div class="col-md-6 mb-4 mb-md-0">
                                                    <div class="input-group group mb-0">
                                                        <input id="Password-input" type="password"><i
                                                            class="fa-regular fa-eye-slash hide"></i></input>
                                                        <label class="form-label" for="Password-input">Password</label>
                                                    </div>
                                                    <div id="password-errors"></div>
                                                    <div id="password-info"
                                                        class="alert alert-primary position-absolute z-index-2 rounded-0 p-2 mt-2 "
                                                        role="alert">
                                                        <small><i class="fa-solid fa-circle-info"></i> <b> Must be :</b>
                                                            <hr class="m-1"> *At least <b>8</b> characters <br> *Has a
                                                            <b>Uppercase</b>
                                                            letter<br> *Has a <b>Lowercase</b> letter<br> *Has a
                                                            <b>Number</b><br> *Has a
                                                            <b>SpecialChars</b>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4 mb-md-0">
                                                    <div class="input-group group mb-0">
                                                        <input id="Re-Password-input" type="password"><i
                                                            class="fa-regular fa-eye-slash hide"></i></input>
                                                        <label class="form-label"
                                                            for="Re-Password-input">Re-Password</label>
                                                    </div>
                                                    <div id="rePassword-errors"></div>
                                                </div>

                                            </div>

                                            <div class="mb-4">
                                                <div class="input-group group mb-0">
                                                    <input id="Email-input" type="Email">
                                                    <label class="form-label" for="Email-input">Email</label>
                                                </div>
                                                <div id="email-errors"></div>
                                            </div>

                                            <div class="row resetBox mb-4">
                                                <div class=" input-group group mb-0">
                                                    <input id="PhoneNumber-input" type="text">
                                                    <label class="form-label" for="PhoneNumber-input">Phone
                                                        Number</label>
                                                </div>
                                                <div id="phoneNumber-errors" class="col-md-6"></div>
                                                <div class="col-md-6 d-flex justify-content-end"><small
                                                        id="phoneExample">Example:
                                                        05XXXXXXXX</small>
                                                </div>
                                            </div>


                                            <div class="gender-box mb-4">
                                                <div class="col-md-12 d-flex justify-content-evenly">
                                                    <h6 class="m-0 d-inline">Gender : </h6>

                                                    <div class="form-check form-check-inline m-0">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="femaleGender"
                                                            value="option1" />
                                                        <label class="form-check-label" for="femaleGender">Male</label>
                                                    </div>

                                                    <div class="form-check form-check-inline m-0">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="maleGender" value="option2" />
                                                        <label class="form-check-label" for="maleGender">Female</label>
                                                    </div>
                                                </div>

                                                <div id="gender-errors"></div>
                                            </div>


                                            <div id="Country-box" class="mb-4">
                                                <select id="country-select" class="selectpicker" title="Country"
                                                    data-live-search="true" data-width="100%" data-size="5">
                                                    <?php 
                                                        include $func . "getCountries.php";
                                                        ?>
                                                </select>
                                                <div id="country-errors"></div>
                                            </div>

                                            <div id="city-box" class="mb-4">
                                                <select id="city-select" class="selectpicker" title="city"
                                                    data-live-search="true" data-width="100%" data-size="5">
                                                    <?php 
                                                        include $func . "getCities.php";
                                                        ?>
                                                </select>
                                                <div id="city-errors"></div>
                                            </div>


                                            <div class="row birthday-box justify-content-center d-flex mb-4">
                                                <div class="col-md-4">
                                                    <h6 class="d-inline">Birthday :</h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <input id="birtDayInput" type="date">
                                                    <div id="birthday-errors"></div>
                                                </div>

                                            </div>




                                            <div class="text-center pt-1 mb-4 pb-2">
                                                <button id="signBtn" class="btn btn-primary btn-block fa-lg"
                                                    type="button">Submit</button>
                                            </div>

                                        </form>



                                        <div class="d-flex align-items-center justify-content-center ">
                                            <p class="mb-0 me-2">Already have an account?</p>
                                            <a href="login.php" style="text-decoration: none;">Go to login</a>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="/images/register-image.jpg" alt="" width="100%" height="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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

        $("#Username-input").focus(function() {
            $("#username-info").fadeIn();
        })
        $("#Username-input").blur(function() {
            $("#username-info").fadeOut();
        })

        $("#Password-input").focus(function() {
            $("#password-info").fadeIn();
        })
        $("#Password-input").blur(function() {
            $("#password-info").fadeOut();
        })
        
        $('#PhoneNumber-input').keyup(function() {
                let limit = 10
                if ($(this).val().length > limit) {
                    let val = $(this).val();
                    $(this).val(val.substring(0, limit));
                }
            })


        $("#Username-input").keyup(function() {
            Username = $("#Username-input").val();

            if (Username.length < 3) {
                Box = $('#availableOrNotBox');
                Box.text('');
                return;
            }

            $.ajax({
                url: "<?php echo $func; ?>register.php",
                method: "POST",
                data: {
                    action: 'CheckUsername',
                    Username: Username
                },
                success: function(data) {
                    Box = $('#availableOrNotBox');
                    if (data == 'Available') {
                        html =
                            '<small class="col-md-12 d-flex justify-content-end align-items-center text-success"> <p class="m-0 mr-1">Available</p> <i class = "fa fa-check"></i> </small>';
                        if (isEmpty(Box)) {
                            Box.append(html);
                        } else if (Box.text() != html) {
                            Box.text('');
                            Box.append(html);
                        }
                    } else {
                        html =
                            '<small class="col-md-12 d-flex justify-content-end align-items-center text-danger"> <p class="m-0 mr-1">Unavailable</p> <i class="fa-solid fa-xmark"></i> </small>';
                        if (isEmpty(Box)) {
                            Box.append(html);
                        } else if (Box.text() != html) {
                            Box.text('');
                            Box.append(html);
                        }
                    }
                }
            })

        })


        $("#signBtn").click(function() {

            resetSeccessBox();

            let FirstName = $("#FirstName-input").val();
            let LastName = $("#LastName-input").val();
            let Username = $("#Username-input").val();
            let Password = $("#Password-input").val();
            let RePassword = $("#Re-Password-input").val();
            let Email = $("#Email-input").val();
            let PhoneNumber = $("#PhoneNumber-input").val();


            //Get Gender value.
            let Gender;
            if ($('#maleGender').is(':checked')) {
                Gender = "Male";
            } else if ($('#femaleGender').is(':checked')) {
                Gender = "Female";
            } else {
                Gender = null;
            }

            let country_id = $("#country-select").val();
            let city_id = $("#city-select").val();
            let Birthday = $("#birtDayInput").val();


            $.ajax({
                url: "<?php echo $func; ?>register.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: 'insertUser',
                    Username: Username,
                    Password: Password,
                    RePassword: RePassword,
                    Email: Email,
                    PhoneNumber: PhoneNumber,
                    FirstName: FirstName,
                    LastName: LastName,
                    Gender: Gender,
                    country_id: country_id,
                    city_id: city_id,
                    Birthday: Birthday
                },
                success: function(data) {

                    if (data.code == 1 && !$.isArray(data)) {
                        removeErrors();
                        resetInputs();

                        if (isEmpty($('#secc-box'))) {

                            $('#secc-box').append(
                                '<div id="secc-message" class="alert alert-success" role="alert">' +
                                data.message + '</div>');
                            $('#secc-box').slideDown().delay(10);

                            $.ajax({
                                url: "<?php echo $func ;?>login.php",
                                method: "POST",
                                data: {
                                    Username: Username,
                                    Password: Password
                                },
                                success: function(data) {
                                    setTimeout(function() {
                                        window.location.replace(
                                            "index.php");
                                    }, 3000);
                                }
                            })

                        }

                    } else {

                        errorTypes = ['username', 'password', 'rePassword', 'email',
                            'phoneNumber', 'firstName', 'lastName', 'gender',
                            'country', 'city', 'birthday'
                        ];

                        data.forEach(e => {
                            if (e.code == 0) {

                                if (e.type == 'username') {
                                    errorBox = $('#username-errors');
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

                                    removeInArr(errorTypes, 'username');
                                }

                                if (e.type == 'password') {
                                    errorBox = $('#password-errors');
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

                                    removeInArr(errorTypes, 'password');
                                }

                                if (e.type == 'rePassword') {
                                    errorBox = $('#rePassword-errors');
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

                                    removeInArr(errorTypes, 'rePassword');
                                }

                                if (e.type == 'email') {
                                    errorBox = $('#email-errors');
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

                                    removeInArr(errorTypes, 'email');
                                }

                                if (e.type == 'phoneNumber') {
                                    errorBox = $('#phoneNumber-errors');
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

                                    removeInArr(errorTypes, 'phoneNumber');
                                }

                                if (e.type == 'firstName') {
                                    errorBox = $('#firstName-errors');
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

                                    removeInArr(errorTypes, 'firstName');
                                }

                                if (e.type == 'lastName') {
                                    errorBox = $('#lastName-errors');
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

                                    removeInArr(errorTypes, 'lastName');
                                }

                                if (e.type == 'gender') {
                                    errorBox = $('#gender-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    }

                                    removeInArr(errorTypes, 'gender');
                                }

                                if (e.type == 'country') {
                                    errorBox = $('#country-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    }

                                    removeInArr(errorTypes, 'country');
                                }

                                if (e.type == 'city') {
                                    errorBox = $('#city-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    }

                                    removeInArr(errorTypes, 'city');
                                }

                                if (e.type == 'birthday') {
                                    errorBox = $('#birthday-errors');
                                    if (isEmpty(errorBox)) {
                                        errorBox.append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    } else if (errorBox.find('small').val() != e
                                        .message) {
                                        errorBox.find('small').text(e.message);
                                    }

                                    removeInArr(errorTypes, 'birthday');
                                }

                            }
                        });


                        if (!isEmptyArr(errorTypes)) {
                            errorTypes.forEach(type => {
                                errorBox = $('#' + type + '-errors');
                                errorBox.text('');

                                if (type != 'birthday' || type != 'city' ||
                                    type !=
                                    'country' || type != 'gender') {
                                    input = errorBox.parent().find('div input');
                                    label = errorBox.parent().find('div label');
                                    input.removeClass('input-error');
                                    label.removeClass('label-error');
                                }


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

    function isEmptyVal(input) {
        if (input.val() == '') {
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
        $('#username-errors').text('');
        $('#password-errors').text('');
        $('#rePassword-errors').text('');
        $('#email-errors').text('');
        $('#phoneNumber-errors').text('');
        $('#firstName-errors').text('');
        $('#lastName-errors').text('');
        $('#gender-errors').text('');
        $('#country-errors').text('');
        $('#city-errors').text('');
        $('#birthday-errors').text('');
    }

    function resetInputs() {
        $('#name_input').val('');
        $('#email_input').val('');
        $('#subject_input').val('');
        $('#message-textarea').val('');
    }

    function resetSeccessBox() {
        if (!isEmpty($('#secc-box'))) {
            $('#secc-box').slideUp();
            $('#secc-box').text('').delay(10);
        }
    }
    </script>
</body>

</html>