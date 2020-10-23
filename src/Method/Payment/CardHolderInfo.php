<?php

namespace Cardinity\Method\Payment;

class CardHolderInfo
{
    /** @var string */
    private $emailAddress;
    
    /** @var string */
    private $mobilePhoneNumber;
    
    /** @var string */
    private $homePhoneNumber;
    
    /** @var string */
    private $workPhoneNumber;


    /**
     * @return STRING email
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }


    /**
     * @param STRING email
     * @return VOID
     */
    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }


    /**
     * @return STRING mobile phone number
     */
    public function getMobilePhoneNumber()
    {
        return $this->mobilePhoneNumber;
    }


    /**
     * @param STRING mobile phone number
     * @return VOID
     */
    public function setMobilePhoneNumber(string $mobilePhoneNumber)
    {
        $this->mobilePhoneNumber = $mobilePhoneNumber;
    }


    /**
     * @return STRING home phone number
     */
    public function getHomePhoneNumber()
    {
        return $this->homePhoneNumber;
    }


    /**
     * @param STRING home phone number
     * @return VOID
     */
    public function setHomePhoneNumber(string $homePhoneNumber)
    {
        $this->homePhoneNumber = $homePhoneNumber;
    }


    /**
     * @return STRING work phone number
     */
    public function getWorkPhoneNumber()
    {
        return $this->workPhoneNumber;
    }


    /**
     * @param STRING work phone number
     * @return VOID
     */
    public function setWorkPhoneNumber(string $workPhoneNumber)
    {
        $this->workPhoneNumber = $workPhoneNumber;
    }
}