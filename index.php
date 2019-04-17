<?php
/**
 * Name: Sukhveer S Jawandha
 * 4/8/2019
 * 328/dating/index.php
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

// Define a default route for home page
$f3->route('GET /' , function (){

    //Display a view of home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route sign up information page
$f3 ->route('GET /signup/info' ,function(){

    //Display a views
    $view = new Template();
    echo $view->render('views/info.html');
});
// when click next it goes to profile info page
$f3 ->route('GET /signup/profile' ,function(){

    //Display a views
    $view = new Template();
    echo $view->render('views/profile.html');
});

//Run Fat-Free
$f3->run();