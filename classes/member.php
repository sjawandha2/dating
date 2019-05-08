<?php
/**
 * The member class represents a member in dating website.
 *
 * The member class represents a member with a name, age,gender,phone,
 * email,state,seeking, and bio.
 * @author Sukhveer S Jawandha <sjawandha2@mail.greenriver.edu>
 * @copyright 2019
 */

class Member
{
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Parameterized constructor for member Object.
     * @param String $fname The first name of member
     * @param String $lname The last name of member
     * @param int $age The age of member
     * @param String $gender The gender of member
     * @param int $phone The phone number of member
     */
    // Define parameterized constructor
    function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    /**
     * Get first name of the member
     * @return String $fname
     */
    public function getFname()
    {
        return $this->_fname;
    }
    /**
     * Set the first name of member
     * @param $fname first name of member
     * @return void
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }
    /**
     * Get the last name of member
     * @return String $lname
     */
    public function getLname()
    {
        return $this->_lname;
    }
    /**
     * Set the last name of member
     * @param $lname The last name of member
     * @return void
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }
    /**
     * Get the age of member
     * @return Int $age
     */
    public function getAge()
    {
        return $this->_age;
    }
    /**
     * Set the age of member
     * @param $age Age of member
     * @return void
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }
    /**
     * Get the gender of member
     * @return Gender
     */
    public function getGender()
    {
        return $this->_gender;
    }
    /**
     * Set the Gender of member
     * @param $gender gender of member
     * @return void
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }
    /**
     * Get the phone number of member
     * @return @phone Phone number

     */
    public function getPhone()
    {
        return $this->_phone;
    }
    /**
     * Set the phone number of member
     * @param $phone The phone number
     * @return void
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }
    /**
     * Get the email of member
     * @return String $email
     */
    public function getEmail()
    {
        return $this->_email;
    }
    /**
     * Set the email of member
     * @param String $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }
    /**
     * Get the state of member
     * @return String State
     */
    public function getState()
    {
        return $this->_state;
    }
    /**
     * Set the state of member
     * @param String $state
     * @return void
     */
    public function setState($state)
    {
        $this->_state = $state;
    }
    /**
     * Get the seeking of member
     * @return mixed
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }
    /**
     * Set the seeking of member
     * @param String $seeking
     * @return void
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }
    /**
     * Get the bio of member
     * @return String $bio
     *
     */
    public function getBio()
    {
        return $this->_bio;
    }
    /**
     * Set the bio of member
     * @param String $bio
     * @return void
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }

}