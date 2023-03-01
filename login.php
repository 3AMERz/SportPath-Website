<?php
session_start();

if(isset($_SESSION['Username'])){
    header('Location: index.php');
    exit();
}


include "init.php";
include $func.'connect.php';
include $langs . "English.php";
$title = "SportPath - Login";


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include $tpl . "head.php";
    ?>

</head>


<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $usernameOrEmail = $_POST['userOrEmail'];
    $password = $_POST['password'];
    $hashedPass = sha1($password);

    $stmt = $conn->prepare("SELECT UserName, Password, GroupID FROM users WHERE UserName = ? AND Password = ?");
    $stmt->execute(array($usernameOrEmail,$hashedPass));
    $count = $stmt->rowCount();

    if($count > 0){
        echo $usernameOrEmail . " " . $password . " " . $hashedPass;
    }

}

?>


<body>

    <header>
        <?php
        include $tpl . "header.php";
        ?>
    </header>


    <center>

        <style>

        </style>



        <section class="section-of-middle-box">
            <div class="container py-5 ">
                <div class="row d-flex justify-content-center align-items-center ">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6 d-flex align-items-center">
                                    <div class="card-body p-md-5 mx-md-4">


                                        <div class="text-center">
                                            <h1 class="mt-1 mb-5 pb-1">Login</h1>
                                        </div>


                                        <div id="loginForm">

                                            <div id="Errors-Box">

                                            </div>


                                            <div id="EmailOrUser-input" class="input-group group">
                                                <input class="login-inputs" id="EmailorUsername_input"
                                                    type="EmailOrUsername" name="userOrEmail"
                                                    value="kit.craft1421@gmail.com">
                                                <label class="form-label" for="EmailorUsername_input">Email or
                                                    Username</label>
                                            </div>

                                            <div id="pass-input" class="input-group group">
                                                <input class="login-inputs" id="Password_input" type="password"
                                                    name="password" value="12341234qq"><i
                                                    class="fa-regular fa-eye-slash hide"></i></input>
                                                <label class="form-label" for="Password_input">Password</label>
                                            </div>

                                            <div class="text-center pt-1 ">
                                                <button id="loginBtn"
                                                    class="btn btn-primary btn-block fa-lg">Login</button>
                                            </div>

                                        </div>



                                        <div class="d-flex align-items-center justify-content-center ">
                                            <p class="mb-0 me-2">Don't have an account?</p>
                                            <a href="sign-up.php" style="text-decoration: none;">Create new</a>
                                        </div>


                                        <!-- (Apps Icons) -->
                                        <div id="icons" class="text-center mt-3">
                                            <div class="separator pb-2">OR</div>

                                            <div class="d-flex justify-content-center overflow-hidden mb-3">
                                                <div id="buttonDiv"></div>
                                            </div>



                                            <button id="faceBtn" onclick="fbLogin()" type="button"
                                                class="btn btn-floating mx-1" style="background:#3b5998 !important;">
                                                <i class="fab fa-facebook-f fa-2x"></i>
                                            </button>

                                            <!-- <button id="googleBtn" type="button" class="btn btn-floating mx-1"
                                                style="background:#db4437 !important;">
                                                <i class="fab fa-google fa-2x"></i>
                                            </button> -->

                                            <button id="twitterBtn" type="button" class="btn btn-floating mx-1"
                                                style="background:#1DA1F2 !important;">
                                                <i class="fab fa-twitter fa-2x"></i>
                                            </button>

                                            <button id="gitBtn" onclick="location.href='<?php echo $func;?>github-login.php'" type="button" class="btn  btn-floating mx-1"
                                                style="background:#00405d !important;">
                                                <i class="fab fa-github fa-2x"></i>
                                            </button>
                                        </div>



                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="/images/login-image.jpg" alt="" width="100%">
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

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
    function handleCredentialResponse(response) {
        // console.log("Encoded JWT ID token: " + response.credential);
        $.ajax({
            url: "<?php echo $func; ?>loginWithApps.php",
            method: "POST",
            // dataType: "json",
            data: {
                action: "loginWithGoogle",
                id_token: response.credential
            },
            success: function(data) {
                // console.log(data);
                if (data == true) {
                    window.location.replace("index.php");
                }
            }
        })
    }


    window.onload = function() {
        google.accounts.id.initialize({
            client_id: "55778147542-anttm3dblrmpknog1ad1lfqf9uaiskfl.apps.googleusercontent.com",
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.getElementById("buttonDiv"), {
                size: 'large'
            } // customization attributes
        );
        google.accounts.id.prompt(); // also display the One Tap dialog
    }

    // function SignOut() {
    //     google.accounts.id.revoke('sportpath10@gmail.com', done => {
    //         console.log('consent revoked');
    //     });
    // }
    </script>

    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '731594688539578',
            cookie: true,
            xfbml: true,
            version: 'v16.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));



    function fbLogin() {
        FB.login(function(response) {
            if (response.authResponse) {
                fbAfterLogin();
            }
        });
    }

    function Logout() {
        FB.logout(function(response) {});
    }


    function fbAfterLogin() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {

                FB.api('/me', function(response) {
                    $.ajax({
                        url: "<?php echo $func; ?>loginWithApps.php",
                        method: "POST",
                        data: {
                            action: "loginWithFacebook",
                            id: response.id,
                            name: response.name
                        },
                        success: function(data) {
                            if (data == true) {
                                Logout();
                                window.location.replace("index.php");
                            }
                        }
                    })
                });

            }
        });
    }
    </script>


    <?php

    // require_once $func . 'TwitterConfig.php';
  
    // try {
    //     $adapter->authenticate();
    //     $userProfile = $adapter->getUserProfile();
    //     print_r($userProfile);
    //     echo '<a href="logout.php">Logout</a>';
    // }
    // catch( Exception $e ){
    //     echo $e->getMessage() ;
    // }


    ?>
    



    <script>
    $(document).ready(function() {


        // $().click(function(){
        //     $.ajax({
        //                 url: "<?php echo $func; ?>loginWithApps.php",
        //                 method: "POST",
        //                 data: {
        //                     action: "loginWithGithub",
        //                     id: response.id,
        //                     name: response.name
        //                 },
        //                 success: function(data) {
        //                     if (data == true) {
        //                         Logout();
        //                         window.location.replace("index.php");
        //                     }
        //                 }
        //             })
        // })



        function ArrayisEmpty(arr) {
            if (arr.length === 0) {
                return true;
            } else {
                return false;
            }
        }

        function DeleteSpaces(str) {
            return str.split(" ").join("");
        }



        function LoginValidation(EmailOrUsername, Password) {

            Error = [];

            if (EmailOrUsername == "" || Password == "") {
                Error.push("Please fill in the fields.");
            }


            if (ArrayisEmpty(Error) === false) {
                let html;

                html = `<div class="alert alert-danger p-2" role="alert">`;
                for (let i = 0; i < (Error.length); i++) {
                    html += Error[i];
                }
                html += `</div>`;

                $("#Errors-Box").html(html);
                $("#Errors-Box").slideDown();
                return false;

            } else {

                $("#Errors-Box").html("");
                $("#Errors-Box").slideUp();

                return true;
            }
        }




        $('#loginBtn').click(function() {

            resetErrorBox();

            var EmailOrUsername = $('#EmailorUsername_input').val();
            var Password = DeleteSpaces($('#Password_input').val());


            if (LoginValidation(EmailOrUsername, Password) == true) {

                var input1_is;
                if (isEmail(EmailOrUsername)) {
                    input1_is = "Email";
                } else {
                    input1_is = "Username";
                }


                if (input1_is == "Email") { //if input is Email.

                    $.ajax({
                        url: "<?php echo $func ;?>login.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            Email: EmailOrUsername,
                            Password: Password
                        },
                        success: function(data) {

                            if (data.code == 0) {
                                let ErrorBox = $("#Errors-Box");
                                if (ErrorBox.text() != data.message) {

                                    ErrorBox.append(`<div class="alert alert-danger p-2" role="alert">
                                                    ${data.message}
                                                    </div>`);
                                    ErrorBox.slideDown().delay(10);
                                }
                            } else {
                                window.location.replace("index.php");
                            }
                        }
                    })

                } else if (input1_is == "Username") {

                    $.ajax({
                        url: "<?php echo $func ;?>login.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            Username: EmailOrUsername,
                            Password: Password
                        },
                        success: function(data) {

                            if (data.code == 0) {
                                let ErrorBox = $("#Errors-Box");
                                if (ErrorBox.text() != data.message) {

                                    ErrorBox.append(`<div class="alert alert-danger p-2" role="alert">
                                                    ${data.message}
                                                    </div>`);
                                    ErrorBox.slideDown().delay(10);
                                }
                            } else {
                                window.location.replace("index.php");
                            }
                        }
                    })
                }


            }










        });




    });



    function isEmail(str) {
        var re =
            /^(([a-zA-Z0-9]+)|([a-zA-Z0-9]+((?:\_[a-zA-Z0-9]+)|(?:\.[a-zA-Z0-9]+))*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-zA-Z]{2,6}(?:\.[a-zA-Z]{2})?)$)/;
        return re.test(str);
    }

    function resetErrorBox() {
        let ErrorsBox = $('#Errors-Box');
        if (ErrorsBox.text() != '') {
            ErrorsBox.slideUp();
            ErrorsBox.text('').delay(100);
        }
    }

    function waiting() {
        setTimeout(5000);
    }
    </script>



</body>

</html>