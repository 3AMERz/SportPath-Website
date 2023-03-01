<?php

function lang( $phrase ){

    static $langArr = array(
        
        //MainPage
        'MESSAGE' => '.اهلاً وسهلاً',
        'ERROR' => '.حدث هنالك خطأ'

    );


    return $langArr[$phrase];
}

?>