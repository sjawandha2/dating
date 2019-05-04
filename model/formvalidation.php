<?php
/**
 * Created by PhpStorm.
 * User: sjawa
 * Date: 4/22/2019
 * Time: 6:17 PM
 */

// first name validation
function validName($name) {
    //checks to see that a string is all alphabetic
    return
        (
            (!empty($name)) && ctype_alpha($name));
}

function validAge($age) {
    //checks to see that an age is numeric and between 18 and 118
    return is_numeric($age) && $age >= 18 && $age <= 118;
}

// phone number validation
function validPhone($phone) {
    //if user uses parentheses, dashes, or spaces
    // strip phone to just numbers
    $phone = str_replace("-", "", $phone);
    $phone = str_replace(" ", "", $phone);
    $phone = str_replace("(", "", $phone);
    $phone = str_replace(")", "", $phone);

    return (is_numeric($phone)) && (strlen($phone) == 10);
}

// indoor interests validation
function validIndoor($indoor)
{
    global $f3;
    //Interest are optional
    if (empty($indoor))
    {
        return true;
    }
    foreach ($indoor as $indoor_interests)
    {
        if (!in_array($indoor_interests, $f3->get('indoor')))
        {
            return false;
        }
        return true;
    }
    //If we're still here, then we have valid names
    return true;
}
// outdoor interests validation
function validOutdoor($outdoor)
{
    global $f3;
    //Interest are optional
    if (empty($outdoor))
    {
        return true;
    }
    foreach ($outdoor as $outdoor_interests)
    {
        if (!in_array($outdoor_interests, $f3->get('outdoor')))
        {
            return false;
        }
        return true;
    }
    //If we're still here, then we have valid names
    return true;
}