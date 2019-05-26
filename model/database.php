<?php
/* Sukhveer S Jawandha
 * 05/20/2019
 * 328/dating/model/database.php
 * Database functions to connect database
 */

/*
CREATE TABLE member (
 member_id INT AUTO_INCREMENT PRIMARY KEY,
 fname VARCHAR(30) NOT NULL,
 lname VARCHAR(30) NOT NULL,
 age VARCHAR(30) NOT NULL,
 gender CHAR(6),
 phone VARCHAR(20) NOT NULL,
 email VARCHAR(320) NOT NULL,
 state VARCHAR(30),
 seeking CHAR(6),
 bio TEXT,
 premium TINYINT,
 image VARCHAR(30)
 );
 CREATE TABLE interest (
 interest_id INT AUTO_INCREMENT PRIMARY KEY,
 interest VARCHAR(30),
 type VARCHAR(20)
 );
 CREATE TABLE member_interest (
 member_id INT NOT NULL,
 interest_id INT NOT NULL,
 FOREIGN KEY(member_id) references member(member_id),
 FOREIGN KEY(interest_id) references interest(interest_id)
 );
 */
require "/home2/sjawandh/config.php";

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
//            echo "connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function insertMember($fname, $lname, $age, $gender, $phone, $email, $state, $seeking, $bio, $premium, $image)
    {
        global $dbh;
        $dbh = $this->connect();
        //1. define the query
        $sql = '
INSERT INTO member(fname, lname, age, gender, phone, email, state, seeking, bio, premium, image) VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :image)';
        //2. prepare the statement
        $statement = $this->_dbh->prepare($sql);

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
        $statement->bindParam(':image', $image, PDO::PARAM_STR);


        $statement->execute();
    }

    function getMembers()
    {
        global $dbh;
        $dbh = $this->connect();

        $sql = "SELECT * FROM member ORDER BY lname";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getMember($member_id)
    {
        global $dbh;
        $dbh = $this->connect();

        $sql = "SELECT * FROM member WHERE member_id = :member_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function insertInterest($interest_id, $member_id)
    {

        $sql = 'INSERT INTO member_interest (member_id, interest_id)
                  VALUES (:member_id, :interest_id)';

        $statement = $this->_db->prepare($sql);
        //bind parameters
        $statement->bindParam(':interest_id', $interest_id, PDO::PARAM_STR);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        //execute statement
        $statement->execute();
    }

    function getInterests($member_id)
    {
        global $dbh;
        $dbh = $this->connect();
        $sql = "SELECT interest,type FROM interest,member_interest WHERE member_id = :member_id AND member_interest.interest_id = interest.interest_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
