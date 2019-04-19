<?php
session_start();
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
$f3 ->route('POST /signup/profile' ,function(){

//    print_r($_POST);
    // assign post array to session
    $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname'] = $_POST['lname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];

    //Display a views
    $view = new Template();
    echo $view->render('views/profile.html');
});

// when click next it goes to summary page
$f3 ->route('POST /signup/interests' ,function(){

//    print_r($_POST);
    // assign post array to session
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['bio'] = $_POST['bio'];

    //Display a views
    $view = new Template();
    echo $view->render('views/interests.html');
});

// when click next it goes to summary page
$f3 ->route('POST /signup/summary' ,function(){

//    print_r($_POST);
    $_SESSION['indoor_interests[]'] = $_POST['indoor_interests[]'];
    $_SESSION['outdoor_interests[]'] = $_POST['outdoor_interests[]'];
    //Display a views
    $view = new Template();
    echo $view->render('views/summary.html');
});
//Run Fat-Free
$f3->run();