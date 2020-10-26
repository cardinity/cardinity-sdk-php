<?php

namespace Cardinity\Method\Payment;


use Cardinity\Method\Payment\BrowserInfoInterface;
use Cardinity\Method\Payment\Address;
use Cardinity\Method\Payment\CardHolderInfo;


class ThreeDS2Data
{
    /** @type string */
    private $notificationUrl;

    /** @type object */
    private $browserInfo;

    /** @type object */
    private $billingAddress;

    /** @type object */
    private $deliveryAddress;

    /** @type object */
    private $cardHolderInfo;


    /**
     * @return STRING of notification URL.
     */
    public function getNotificationUrl()
    {
        return $this->notificationUrl;
    }


    /**
     * @param STRING of notification URL
     * @return VOID
     */
    public function setNotificationUrl(string $url) : void
    {
        $this->notificationUrl = $url;
    }


    /** 
     * @return BrowserInfoInterface object of browser info.
     */
    public function getBrowserInfo()
    {
        return $this->browserInfo;
    }


    /**
     * @param BrowserInfo object of browser info.
     * @return VOID
     */
    public function setBrowserInfo(BrowserInfo $browserInfo) : void
    {
        $this->browserInfo = $browserInfo;
    }


    /**
     * @return Address object of billing address.
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }


    /**
     * @param Address object of billing address interface.
     * @return VOID
     */
    public function setBillingAddress(Address $billingAddress) : void
    {
        $this->billingAddress = $billingAddress;
    }


    /**
     * @return DeliveryAddress object of delivery address interface.
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }


    /**
     * @param Address object of delivery address interface.
     * @return VOID
     */
    public function setDeliveryAddress(Address $deliveryAddress) : void
    {
        $this->deliveryAddress = $deliveryAddress;
    }


    /**
     * @return CardHolderInfo object of card holder info interface.
     */
    public function getCardHolderInfo()
    {
        return $this->cardHolderInfo;
    }


    /**
     * @param CardHolderInfo object of card holder info interface.
     * @return VOID
     */
    public function setCardHolderInfo(CardHolderInfo $cardHolderInfo) : void
    {
        $this->cardHolderInfo = $cardHolderInfo;
    }
}