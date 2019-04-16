<?php
/**
 * Name: Sukhveer S Jawandha
 * 4/8/2019
 * 328/howdy/index.php
 */

//Turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require autoload file
require_once ('vendor/autoload.php');

//create an instance of the Base class
$f3 = Base::instance();
////Turn on Fat-Free error reporting
//$f3->set('DEBUG', 3);

// Define a default route
$f3->route('GET /' , function (){

    //Display a views
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route with a parameter
$f3 ->route('GET /signup' ,function(){

    //Display a views
    $view = new Template();
    echo $view->render('views/info.html');
});
//Run Fat-Free
$f3->run();