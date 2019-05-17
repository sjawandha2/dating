<?php
/* Sukhveer S Jawandha
 * 05/20/2019
 * 328/dating/model/database.php
 * Database functions to connect database
 */

require('/home2/sjawandh/config.php');

function connectDatabase()
{
//Connect to the DB
    try {
        //instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        echo 'Connected to database!';
    } catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }
}

function insertMember()
{
    global $dbh;
//Define the query

    $sql = ;
//Prepare the statement
    $statement = $dbh->prepare($sql);
//Bind the parameters
    $type = 'kangaroo';
    $name = 'Joey';
    $color = 'purple';
    $statement->bindParam(':type', $type, PDO::PARAM_STR);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':color', $color, PDO::PARAM_STR);

    //Execute
    $statement->execute();
    echo '<p>kangaroo added!</p>';
}

function getMember($member_Id)
{
    global $dbh;
    $sql =;
    $statement = $dbh->prepare($sql);
    $statement->execute();
}

function getInterests($member_Id)
{
    global $dbh;
    $sql =;
    $statement = $dbh->prepare($sql);
    $statement->execute();
}