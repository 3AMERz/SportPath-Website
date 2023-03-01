$(document).ready(function() {

    // function to change label color when focus on input has (.group) class.
    $(".group input").focus(function() {
        label = $(this).parent().find('label');
        if(label.hasClass('label-error')){
            label.css("color", "rgb(175, 0, 0)"); //red color
        }else{
            label.css("color", "rgb(0, 89, 255)"); //blue color
        }
    });
    $(".group input").blur(function() {
        label = $(this).parent().find('label');
        label.css("color", "grey");
    });


    // function to verify if any input has (.group) class and valid gets (input-isValid) class.
    $(".group input").change(function() {
        if ($(this).val()) {
            $(this).siblings('label').addClass("input-isValid");
        }
        else {
            $(this).siblings('label').removeClass("input-isValid");
        }
        
    });



    // function to do shadow of apps icons when hover.
    $("#icons button").mouseenter(function() {
        let back = $(this).css("background-color");
        $(this).css("box-shadow", `0px 0px 6px 1px ${back}`);
    });

    $("#icons button").mouseleave(function() {
        $(this).css("box-shadow", "0px 0px 0px 0px");
    });



// function for (eye icon) in password inputs. -----------------------------------    
    

    // function to show and hide (eye icon).
    $(".fa-regular").siblings('input').keyup(function() {
        let input_pass = $(this);

        if(input_pass.val()) {    
            if(input_pass.siblings('.fa-regular').is(":hidden")){
                input_pass.siblings('.fa-regular').removeClass("hide");
            }
        }else{
            if(input_pass.siblings('.fa-regular').is(":visible")){
                input_pass.siblings('.fa-regular').addClass("hide");
            }
        }
    });
    
    // function to replace icon between slasha and normale eye.
    $(".fa-regular").click(function() {
        let input_pass = $(this).siblings("input");
        let type ;

        // replace type pass input between (password) and (text).
        if(input_pass.attr("type") === "password"){type = "text";}
        else{type ="password";} 
        input_pass.attr("type", type);

        // replace icon between slasha and normale eye.
        if(type == "text"){
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
            $(this).addClass("m-eye");
        }
        else if(type == "password"){
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
            $(this).removeClass("m-eye");
        }  
    });



    // add border for each dropdown.
    $(".selectpicker").siblings("button").css("border","solid 1px grey");
    $(".selectpicker").siblings("button").mouseenter(function() {
        $(this).css("border","solid 1px black");
    });
    $(".selectpicker").siblings("button").mouseleave(function() {
        $(this).css("border","solid 1px grey");
    });

    

    // show (city) dropdown if Country is Saudi Arabia, and hide it if else.
    $("#Country-box").change(function() {
        let tittle = $(this).find("button").attr("title");

        if(tittle == "Saudi Arabia"){
            if($("#city-box").is(":hidden")){
            $("#city-box").slideDown();
            }
        }
        
        else{
            if($("#city-box").is(":visible")){
                $("#city-box").slideUp();
            }
        }
    });



    $("#navLoginBtn").click(function(){
        window.location.href = "login.php";
    });

    $("#navSignupBtn").click(function(){
        window.location.href = "sign-up.php";
    });





    // on click logout Btn.
    $('#logoutBtn').click(function(){
        $.ajax({
            url: "<?php echo $func ;?>logout.php",
            method: "POST",
            success: function(data) {
                let ErrorBox = $("#Errors-Box");
                window.location.href = "index.php";

                if(data == "FALSE"){

                    let html = `<div class="alert alert-danger p-2" role="alert">
                                The username or password or both are incorrect.
                                </div>`;
                                
                    if(!($(ErrorBox).html() == html)){
                        $(ErrorBox).html(html);
                        $("#Errors-Box").slideDown();
                    }

                }
            }
        })
    });




});



function visible(partial) {
    var $t = partial,
        $w = jQuery(window),
        viewTop = $w.scrollTop(),
        viewBottom = viewTop + $w.height(),
        _top = $t.offset().top,
        _bottom = _top + $t.height(),
        compareTop = partial === true ? _bottom : _top,
        compareBottom = partial === true ? _top : _bottom;

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop) && $t.is(':visible'));
}

$(window).scroll(function(){

  if(visible($('.count-digit'))){

    if($('.count-digit').hasClass('counter-loaded')) return;
    $('.count-digit').addClass('counter-loaded');
      
    $('.count-digit').each(function () {
    var $this = $(this);
    jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
        duration: 4000,
        easing: 'swing',
        step: function () {
        $this.text(Math.ceil(this.Counter));
        }
    });
    });

    }
})


