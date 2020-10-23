<?php

namespace Cardinity\Method\Payment;

use Cardinity\Method\ResultObject;


class Address extends ResultObject
{
    
    /** @var string */
    private $addressLine1;
    
    /** @var string */
    private $addressLine2;
    
    /** @var string */
    private $addressLine3;
    
    /** @var string */
    private $city;
    
    /** @var string */
    private $country;
    
    /** @var string */
    private $postalCode;
    
    /** @var string */
    private $state;


    /**
     * @return STRING of address line 1
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }


    /**
     * @param STRING of address line 1
     * @return VOID
     */
    public function setAddressLine1(string $addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }


    /**
     * @return STRING of address line 2
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }


    /**
     * @param STRING of address line 2
     * @return VOID
     */
    public function setAddressLine2(string $addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }
    

    /**
     * @return STRING of address line 3
     */
    public function getAddressLine3()
    {
        return $this->addressLine3;
    }


    /**
     * @param STRING of address line 3
     * @return VOID
     */
    public function setAddressLine3(string $addressLine3)
    {
        $this->addressLine3 = $addressLine3;
    }


    /**
     * @return STRING of city
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * @param STRING of city
     * @return VOID
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }


    /**
     * @return STRING of country
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * @param STRING of country
     * @return VOID
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * @return STRING of postal code
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }


    /**
     * @param STRING of postal code
     * @return VOID
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }


    /**
     * @return STRING of state
     */
    public function getState()
    {
        return $this->state;
    }


    /**
     * @param STRING of state
     * @return VOID
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }
}