<?php
/* Sukhveer S Jawandha
 * 05/20/2019
 * 328/dating/model/database.php
 * Database functions to connect database
 */

/*
CREATE TABLE members (
    member_id INT PRIMARY KEY AUTO_INCREMENT,
    fname VARCHAR(50),
    lname VARCHAR(50),
    age INT(3),
    gender VARCHAR(10),
    phone VARCHAR(10),
    email VARCHAR(50),
    state VARCHAR(50),
    seeking VARCHAR(6),
    bio VARCHAR(500),
    premium TINYINT(1)
    );
CREATE TABLE interest (
interest_id INT PRIMARY KEY AUTO_INCREMENT,
 interest varchar(255),
type varchar(50),
 PRIMARY KEY (interest_id)
 );

 */
require "/home2/sjawandh/config-student.php";

class Database
{
    private $_dbh;

    function __construct()
    {
        $this->connect();
    }

    function connect()
    {
        try {


            // instantiate a db object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            return $this->_dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function insertMember($fname, $lname, $age, $gender, $phone, $email, $state,
                          $seeking, $bio, $premium, $interests)
    {
        global $dbh;
        $sql = "INSERT INTO members (fname, lname, age, gender, phone, 
            email, state, seeking, bio, premium, interests)
            VALUES(:fname, :lname, :age, :gender, :phone, :email, 
            :state, :seeking, :bio, :premium)";
        $statement = $dbh->prepare($sql);
        //bind parameters
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_INT);

        return $statement->execute();
    }

    function getMembers()
    {
        global $dbh;
        $sql = "SELECT * FROM members";
        $statement = $dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function getMember($member_Id)
    {
        global $dbh;
        $sql = "SELECT * FROM members WHERE member_id = '$member_Id'";
        $statement = $dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
