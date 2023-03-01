<?php

function lang( $phrase ){

    static $langArr = array(
        
        //MainPage
        'MESSAGE' => 'Welcome Here.',
        'ERROR' => 'Sorry there`s a problem.'

    );


    return $langArr[$phrase];
}

?>