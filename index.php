<?php
/**
 * Name: Sukhveer S Jawandha
 * 4/8/2019
 * 328/dating/index.php
 **/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');
session_start();
//validate form
require_once('model/formvalidation.php');

$db = new Database();
//create an instance of the Base class
$f3 = Base::instance();


$f3->set('indoor_interests', array('tv', 'movies', 'cooking', 'board games', 'puzzles', 'reading', 'playing cards', 'video games'));
$f3->set('outdoor_interests', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));
$f3->set('genders', array('Male', 'Female'));

////Turn on Fat-Free error reporting
//set_exception_handler(function($obj) use($f3){
//    $f3->error(500,$obj->getmessage(),$obj->gettrace());
//});
//set_error_handler(function($code,$text) use($f3)
//{
//    if (error_reporting())
//    {
//        $f3->error(500,$text);
//    }
//});
$f3->set('DEBUG', 3);


// Define a default route for home page
$f3->route('GET|POST /', function () {

    //Display a view of home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route sign up information page
$f3->route('GET|POST /signup/info',
    function ($f3) {

        //start with empty session array here
        $_SESSION = array();
        $isValid = true;

        if (!empty($_POST)) {

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];

            //Add data to hive
            $f3->set('fname', $fname);
            $f3->set('lname', $lname);
            $f3->set('age', $age);
            $f3->set('gender', $gender);
            $f3->set('phone', $phone);

            if (validName($fname)) {
                $_SESSION['fname'] = $fname;
            } else {
                $f3->set("errors['fname']", "Please enter your first name");
                $isValid = false;
            }
            // validate last name
            if (validName($lname)) {
                $_SESSION['lname'] = $lname;
            } else {
                $f3->set("errors['lname']", "Please enter your last name");
                $isValid = false;
            }
            // validate age
            if (validAge($age)) {
                $_SESSION['age'] = $age;
            } else {
                $f3->set("errors['age']", "Please enter your age (Must be 18 or older)");
                $isValid = false;
            }
            // saves gender if set
            if (isset($_POST['gender'])) {
                $_SESSION['gender'] = $gender;
            }
            // validate phone number
            if (validPhone($phone)) {
                $_SESSION['phone'] = $phone;
            } else {
                $f3->set("errors['phone']", "Please enter 10 digit phone number");
                $isValid = false;
            }
            if ($isValid) {
                //check if premium member is set
                if (isset($_POST['premium'])) {
                    $premium = new PremiumMember($fname, $lname, $age, $gender, $phone);
                    $_SESSION['memberType'] = $premium;
                } else {
                    $member = new Member($fname, $lname, $age, $gender, $phone);
                    $_SESSION['memberType'] = $member;
                }
                $f3->reroute("/signup/profile");
            }
        }

        //Display a views
        $view = new Template();
        echo $view->render('views/info.html');
    });


// when click next it goes to profile info page
$f3->route('GET|POST /signup/profile', function ($f3) {

    $isValid = true;

    // retrieve member object from session
    $memberType = $_SESSION['memberType'];

    if (!empty($_POST)) {

        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        //Add data to hive
        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $seeking);
        $f3->set('bio', $bio);

        if (!empty($email)) {
            $_SESSION['email'] = $email;
            $memberType->setEmail($email);
        } else {
            $f3->set("errors['email']", "Please enter your email address");
            $isValid = false;
        }

        if (!empty($state)) {
            $_SESSION['state'] = $state;
            $memberType->setState($state);
        } else {
            $f3->set("errors['state']", "Please select a state");
            $isValid = false;
        }

        if (isset($_POST['seeking'])) {
            $_SESSION['seeking'] = $seeking;
            $memberType->setSeeking($seeking);
        }

        if (!empty($bio)) {
            $_SESSION['bio'] = $bio;
            $memberType->setBio($bio);
        }
        if ($isValid) {
            $_SESSION['memberType'] = $memberType;

            // if member sign up for premium account than goes to interest page
            // otherwise goes to summary page
            if ($memberType instanceof PremiumMember) {
                $f3->reroute("/signup/interests");
//                echo "You are a Premium Member!";

            } else {
                $f3->reroute("/signup/summary");
            }
        }
    }
    //Display a views
    $view = new Template();
    echo $view->render('views/profile.html');
});

// when click next it goes to summary page
$f3->route('GET|POST /signup/interests', function ($f3) {

    $memberType = $_SESSION['memberType'];
    $isValid = true;

    if (!empty($_POST)) {
        $indoor = $_POST['indoor'];
        $outdoor = $_POST['outdoor'];

        //add data to hive
        $f3->set('indoor', $indoor);
        $f3->set('outdoor', $outdoor);

        if (validIndoor($indoor)) {
            $_SESSION['indoor'] = $indoor;

            if (empty($indoor)) {
                $_SESSION['indoor'] = ", No indoor interests selected";
            } else {
                $_SESSION['indoor'] = implode(', ', $indoor);
            }

            $memberType->setIndoorInterests($_SESSION['indoor']);
        } else {
            $f3->set("errors['indoor']", "Invalid Choice");
            $isValid = false;
        }

        // validate outdoor interests
        if (validOutdoor($outdoor)) {
            $_SESSION['outdoor'] = $outdoor;

            if (empty($outdoor)) {
                $_SESSION['outdoor'] = "No outdoor interests selected";
            } else {
                $_SESSION['outdoor'] = implode(', ', $outdoor);
            }

            $memberType->setOutdoorInterests($_SESSION['outdoor']);

        } else {
            $f3->set("errors['outdoor']", "Invalid Choice");
            $isValid = false;

        }
        if ($isValid) {
            //redirect to next form
            $f3->reroute('signup/summary');
        }
    }
    //Display a views
    $view = new Template();
    echo $view->render('views/interests.html');
});


// when click next it goes to summary page
$f3->route('GET|POST /signup/summary', function ($f3) {

    //get member and db object
    $member = $_SESSION['memberType'];
    global $db;
    //grab values for insertion
    $fname = $member->getFname();
    $lname = $member->getLname();
    $age = $member->getAge();
    $phone = $member->getPhone();
    $email = $member->getEmail();
    $gender = $member->getGender();
    $state = $member->getState();
    $seeking = $member->getSeeking();
    $bio = $member->getBio();
    $image = 0;
    //insert based on member type
    if($member instanceof PremiumMember) {
        $f3->set("indoor", $member->getIndoorInterests());
        $f3->set("outdoor", $member->getOutdoorInterests());
        // combine interests if necessary
        if ($f3->get("indoor") && $f3->get("outdoor") != null) {
            $interests = $f3->get("indoor") . " " . $f3->get("outdoor");
        } else if ($f3->get("indoor") != null) {
            $interests = $f3->get("indoor");
        } else if ($f3->get("outdoor") != null) {
            $interests = $f3->get("outdoor");
        }
        $interests = str_replace(" ", ", ", $interests);


        $member_id = $db->getMemberID($fname, $lname);


        $db->insertMember($fname, $lname, $age, $phone, $email,
            $gender, $state, $seeking, $bio, 1,$image);
        $db->insertInterest($member_id,$interests);

    }
    else {
        $db->insertMember($fname, $lname, $age, $phone, $email,
            $gender, $state, $seeking, $bio, 0,$image);
    }

    //Display a views
    $view = new Template();
    echo $view->render('views/summary.html');

});

//admin route
$f3->route('GET|POST /admin', function ($f3) {

    global $db;
    $db->connect();
    $members = $db->getMembers();
    //set members and db for use in admin
    $f3->set('members', $members);
    $f3->set('db', $db);
    //display a view
    $view = new Template();
    echo $view->render('views/admin.html');
});

// route to view profiles based on member id
$f3->route("GET /detail/@member_id", function($f3, $params) {
    global $db;
    $id = $params['member_id'];
    $member= $db->getMember($id);
    $f3->set("member", $member);
    $template = new Template();
    echo $template->render('views/member_summary.html');
});
//Run Fat-Free
$f3->run();