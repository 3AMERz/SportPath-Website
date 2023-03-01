<?php
session_start();

include "init.php";
include $func.'connect.php';
include $langs . "English.php";
$title = "SportPath - Contact Us";

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


        <div class="content">
            <div class="container">
                <div class="row justify-content-center py-6">

                    <div class="col-md-10">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="row ">

                                    <h3 class="heading mb-4">Let's talk about everything!</h3>
                                    <p>Use our contact form for all information requests or contact us directly using the contact information below.</p>
                                    <img src="images/contact.svg" alt="Image" class="img-fluid"
                                        style="height: 275px!important;">

                                </div>
                            </div>


                            <div id="contactForm" class="col-md-6">

                                <div id="secc-box" class="mb-3"></div>

                                <div class="box mb-3">
                                    <div class="input-group group m-0">
                                        <input id="name_input" type="text">
                                        <label class="form-label" for="name_input">Name</label>
                                    </div>
                                    <div id="name-errors"></div>
                                </div>


                                <div class="box mb-3">
                                    <div class="input-group group m-0">
                                        <input id="email_input" type="Email">
                                        <label class="form-label" for="email_input">Email</label>
                                    </div>
                                    <div id="email-errors"></div>
                                </div>


                                <div class="box mb-3">
                                    <div class="input-group group m-0">
                                        <input id="subject_input" type="text">
                                        <label class="form-label" for="subject_input">Subject</label>
                                    </div>
                                    <div id="subject-errors"></div>
                                </div>


                                <div class="box mb-3">
                                    <div>
                                        <label for="message-textarea"
                                            class="form-label message-label mb-1">Message</label>
                                        <textarea class="form-control textAr" id="message-textarea" cols="30" rows="7"
                                            aria-required="true"></textarea>
                                    </div>
                                    <div id="message-errors"></div>
                                </div>


                                <input id="submit" type="submit" value="Send Message" class="btn btn-dark py-2 px-4">





                            </div>
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

        function resetError() {
            $('#name-errors').text('');
            $('#email-errors').text('');
            $('#subject-errors').text('');
            $('#message-errors').text('');
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
                setTimeout(function() {
                    $('#secc-box').text('');
                }, 1000);

            }
        }

        $('#submit').click(function() {
            resetSeccessBox();

            formData = {
                'name': $('#name_input').val(),
                'email': $('#email_input').val(),
                'subject': $('#subject_input').val(),
                'message': $('#message-textarea').val()
            };


            $.ajax({
                url: "<?php echo $func; ?>contact.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(data, textStatus, jqXHR) {

                    console.log(data);

                    if (!$.isArray(data)) {
                        resetError();
                        resetInputs();
                        if (isEmpty($('#secc-box'))) {
                            $('#secc-box').append(
                                '<div id="secc-message" class="alert alert-success" role="alert">' +
                                data.message + '</div>');

                            $('#secc-box').slideDown().delay(10);
                        }

                    } else {
                        // if(!isEmpty($('#secc-box'))){}

                        errorTypes = ['name', 'email', 'subject', 'message'];

                        data.forEach(e => {
                            if (e.code == 0) {

                                if (e.type == 'name') {
                                    if (isEmpty($('#name-errors'))) {
                                        $('#name-errors').append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    }
                                    removeInArr(errorTypes, 'name');
                                }

                                if (e.type == 'email') {
                                    if (isEmpty($('#email-errors'))) {
                                        $('#email-errors').append(
                                            '<small id="email-errors-message" class="error">' +
                                            e
                                            .message + '</small>');
                                    } else if ($('#email-errors-message').val() != e
                                        .message) {
                                        $('#email-errors-message').text(e.message);
                                    }
                                    removeInArr(errorTypes, 'email');
                                }

                                if (e.type == 'subject') {
                                    if (isEmpty($('#subject-errors'))) {
                                        $('#subject-errors').append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    }
                                    removeInArr(errorTypes, 'subject');
                                }

                                if (e.type == 'message') {
                                    if (isEmpty($('#message-errors'))) {
                                        $('#message-errors').append(
                                            '<small class="error">' + e
                                            .message + '</small>');
                                    }
                                    removeInArr(errorTypes, 'message');
                                }
                            }
                        });
                        if (!isEmptyArr(errorTypes)) {
                            errorTypes.forEach(e => {
                                $('#' + e + '-errors').text('');
                            });
                        }
                    }

                    
                }
            });

        })


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
    </script>





</body>

</html>