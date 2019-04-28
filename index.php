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
require_once ('model/formvalidation.php');

//create an instance of the Base class
$f3 = Base::instance();
////Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// Define a default route for home page
$f3->route('GET|POST /' , function (){

    //Display a view of home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route sign up information page
$f3 ->route('GET|POST /signup/info',
    function($f3){

    //start with empty session array here
    $_SESSION = array();

    $isValid = true;

        if (!empty($_POST)) {
            if (isset($_POST['fname'])) {
                $fname = $_POST['fname'];
                if (validName($fname)) {
                    $_SESSION['fname'] = $fname;
                } else {
                    $f3->set("errors['fname']", "Please enter your first name");
                    $isValid = false;
                }
            }

            // validate last name
            if (isset($_POST['lname'])) {
                $lname = $_POST['lname'];
                if (validName($lname)) {
                    $_SESSION['lname'] = $lname;
                } else {
                    $f3->set("errors['lname']", "Please enter your last name");
                    $isValid = false;
                }
            }

            // validate age
            if (isset($_POST['age'])) {
                $age = $_POST['age'];
                if (validAge($age)) {
                    $_SESSION['age'] = $age;
                } else {
                    $f3->set("errors['age']", "Please enter your age (Must be 18 or older)");
                    $isValid = false;
                }
            }

            // saves gender if set
            if (isset($_POST['gender'])) {
                $_SESSION['gender'] = $_POST['gender'];
            }
            // validate phone number
            if (isset($_POST['phone'])) {
                $phone = $_POST['phone'];
                if (validPhone($phone)) {
                    $_SESSION['phone'] = $phone;
                } else {
                    $f3->set("errors['phone']", "Please enter full 10-digit number");
                    $isValid = false;
                }
            }

            if ($isValid) {
                $f3->reroute("/signup/profile");
            }
        }
//        print_r($_POST);


        //Display a views
    $view = new Template();
    echo $view->render('views/info.html');
});


// when click next it goes to profile info page
$f3 ->route('GET|POST /signup/profile' ,function(){

    //Display a views
    $view = new Template();
    echo $view->render('views/profile.html');
});

// when click next it goes to summary page
$f3 ->route('GET|POST /signup/interests' ,function(){


    //Display a views
    $view = new Template();
    echo $view->render('views/interests.html');
});

// when click next it goes to summary page
$f3 ->route('GET|POST /signup/summary' ,function(){

//    print_r($_POST);
    $_SESSION['indoor_interests'] = $_POST['indoor_interests[]'];
    $_SESSION['outdoor_interests'] = $_POST['outdoor_interests[]'];

    //Display a views
    $view = new Template();
    echo $view->render('views/summary.html');
});
//Run Fat-Free
$f3->run();