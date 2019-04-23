<?php
/**
 * Created by PhpStorm.
 * User: sjawa
 * Date: 4/22/2019
 * Time: 6:17 PM
 */

// first name validation
function validName($name) {
    return ((!empty($name)) && ctype_alpha($name));
}