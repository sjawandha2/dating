<?php
/* Sukhveer S Jawandha
 * 05/20/2019
 * 328/dating/model/database.php
 * Database functions to connect database
 */

/*
CREATE TABLE member (
 member_id INT AUTO_INCREMENT PRIMARY KEY,
 fname VARCHAR(50) NOT NULL,
lname VARCHAR(50) NOT NULL,
age VARCHAR(10) NOT NULL,
gender CHAR(6),
phone VARCHAR(20) NOT NULL,
email VARCHAR(100) NOT NULL,
state VARCHAR(30),
seeking CHAR(6),
bio TEXT,
premium TINYINT,
 image VARCHAR(10) )

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
/**
 * database Class is for a database for members
 *
 * The Pet class represents a pet in a pet store.
 *
 * The database class represents a database to insert and get the data of member.
 * @author Sukhveer S Jawandha <sjawandha2@mail.greenriver.edu>
 * @copyright 2019
 */
class Database
{
    private $_dbh;

    /**
     * Database constructor.
     */
    // constructor
    function __construct()
    {
        $this->connect();
    }

    // connect to database

    /**
     *
     * connect to the database
     * @return PDO the database
     *
     */
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

    /**
     *
     * Parameterized function for insert info for member
     * @return  void
     * @param String $fname The first name of member
     * @param String $lname The last name of member
     * @param Int $age age of member
     * @param String $phone  phone of member
     * @param String $email email of member
     * @param String $gender gender of member
     * @param String $state State of member
     * @param String $seeking seeking gender of member
     * @param String $bio bio of member
     * @param String $premium member is premium or not
     * @param String $image image of member
     */
    function insertMember($fname, $lname, $age, $phone, $email,
                          $gender, $state, $seeking, $bio, $premium , $image)
    {
        if (isset($this->_dbh)) {
            //1. define the query
            $sql = '
INSERT INTO member(fname,lname,age,gender,phone,email,state,seeking,bio,premium,image) VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :image)';
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
    }

    /**
     * The insert interest of premium member
     * @param int $interest_id interest ID of member
     * @param int $member_id member id of member
     */
    function insertInterest($interest_id, $member_id)
    {
        $sql = "INSERT INTO member_interest(member_id, interest_id)
                VALUES(:member_id, :interest_id)";
        $statement = $this->_dbh->prepare($sql);
            // bind interest id and member id
            $statement->bindParam(":member_id", $member_id, PDO::PARAM_INT);
            $statement->bindParam(":interest_id", $interest_id, PDO::PARAM_INT);
            //Execute the statement
            $statement->execute();

    }

    /**
     * get the interest id of member
     * @param int $interest_id  interest id
     * @return mixed interest id
     */
    function getInterestID($interest_id)
    {
        $sql = "SELECT interest_id FROM interest WHERE interest_id = :interest_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':interest_id', $interest_id, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * get the member id of member
     *
     * @param String $fname  first name of member
     * @param String $lname last name of member
     * @return mixed member id
     */
    function getMemberID($fname, $lname)
    {
        //define query
        $sql= "SELECT member_id FROM member
                  WHERE fname = :fname 
                  AND lname = :lname";
        //prepare statement
        $statement = $this->_dbh->prepare($sql);
        //bind parameters
        $statement->bindParam(':fname', $fname);
        $statement->bindParam(':lname', $lname);
        //execute
        $statement->execute();
        //get result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * get all info of member in order of last name
     * @return mixed All info of member like (first name, last name,phone,email ,etc;)
     */
    function getMembers()
    {

        $sql = "SELECT * FROM member ORDER BY lname";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * get all info of member by member_id.
     * @param $member_id
     * @return mixed All info of member based on member id like (first name, last name,phone,email ,etc;)
     */
    function getMember($member_id)
    {
        $sql = "SELECT * FROM member WHERE member_id = :member_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     *
     * get interest of member by member_id.
     * @param $member_id
     * @return mixed interest of member based on member id.
     */
    function getInterests($member_id)
    {
        $sql = "SELECT interest,type FROM interest,member_interest WHERE member_interest.interest_id = interest.interest_id AND member_id = :member_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
