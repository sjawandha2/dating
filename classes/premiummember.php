<?php
/**
 * The premium member class represents a member as a premium member in dating website.
 *
 * The member class represents a member as a premium member  with a name, age,gender,phone,
 * email,state,seeking,bio, and interests.
 * @author Sukhveer S Jawandha <sjawandha2@mail.greenriver.edu>
 * @copyright 2019
 */


class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    /**
     * Parameterized constructor for premium member Object.
     * @param String $fname The first name of premium member
     * @param String $lname The last name of premium member
     * @param int $age The age of premium member
     * @param String $gender The gender of  premium member
     * @param int $phone The phone number of premium member
     */

    function __construct($fname, $lname, $age, $gender, $phone)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone);
    }
    /**
     * Get indoor interests of the premium member
     * @return string $_inDoorInterests
     */
    public function getIndoorInterests()
    {
        return $this->_indoorInterests;
    }
    /**
     * Set indoor interests of the premium member
     * @param $indoorInterests indoor interests of premium member.
     * @return void
     */
    public function setIndoorInterests($indoorInterests)
    {
        $this->_inDoorInterests = $indoorInterests;
    }
    /**
     * Get outdoor interests of the premium member
     * @return string $_outDoorInterests
     */
    public function getOutdoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Set outdoor interests of the premium member
     * @param $outdoorInterests  outdoor interests of premium member.
     * @return void
     */
    public function setOutdoorInterests($outdoorInterests)
    {
        $this->_outDoorInterests = $outdoorInterests;
    }

}
