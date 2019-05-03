<?php
session_start();
/**
 * Name: Sukhveer S Jawandha
 * 4/8/2019
 * 328/dating/index.php
 **/

//Turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require autoload file
require_once ('vendor/autoload.php');
require_once ('model/formvalidation.php');

//create an instance of the Base class
$f3 = Base::instance();


$f3->set('indoor_interests', array('tv','movies','cooking','board games','puzzles','reading','playing cards','video games'));
$f3->set('outdoor_interests', array('hiking','biking','swimming','collecting','walking','climbing'));
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
$f3 ->route('GET|POST /signup/profile' ,function($f3) {

    $isValid = true;

    // validate that the email was not left empty
    if (!empty($_POST)) {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!empty($email)) {
                $_SESSION['email'] = $email;
            } else {
                $f3->set("errors['email']", "Please enter your email address");
                $isValid = false;
            }
        }
        if (isset($_POST['state'])) {
            $state = $_POST['state'];
            if ($state != "") {
                $_SESSION['state'] = $state;
            } else {
                $f3->set("errors['state']", "Please select a state");
                $isValid = false;
            }
        }
        if (isset($_POST['seeking'])) {
            $seeking = $_POST['seeking'];
            if (!empty($seeking)) {
                $_SESSION['seeking'] = $seeking;
            }
        }
        if (isset($_POST['bio'])) {
            $bio = $_POST['bio'];
            if (!empty($bio)) {
                $_SESSION['bio'] = $bio;
            }
        }
        if ($isValid) {
            $f3->reroute("/signup/interests");
        }

//        print_r($_POST);
    }
    //Display a views
    $view = new Template();
    echo $view->render('views/profile.html');
});

// when click next it goes to summary page
$f3 ->route('GET|POST /signup/interests' ,function($f3){

    $isValid = true;
    if (!empty($_POST)) {
        $indoor = $_POST['indoor'];

        if (validIndoor($indoor))
        {
            $_SESSION['indoor'] = $indoor;
            if (empty($pname)) {
                $_SESSION['indoor'] = "No Names selected";
            }
            else {

                $_SESSION['indoor'] = implode(', ', $indoor);
            }

        }
        else
        {
            $f3->set("errors['indoor']","Invalid Choice");
            $isValid = false;

        }
        if($isValid)
        {
            //redirect to next form
            $f3->reroute('signup/summary');
        }

    }

    //Display a views
    $view = new Template();
    echo $view->render('views/interests.html');
});


// when click next it goes to summary page
$f3 ->route('GET|POST /signup/summary' ,function($f3){

    //Display a views
    $view = new Template();
    echo $view->render('views/summary.html');
});
//Run Fat-Free
$f3->run();