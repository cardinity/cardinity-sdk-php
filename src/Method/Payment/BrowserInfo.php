<?php

namespace Cardinity\Method\Payment;


class BrowserInfo
{
    /** @type STRING */
    private $acceptHeader;

    /** @type STRING */
    private $browserLanguage;

    /** @type INT */
    private $screenWidth;
    
    /** @type INT */
    private $screenHeight;
    
    /** @type STRING */
    private $challengeWindowSize;

    /** @type STRING */
    private $userAgent;
    
    /** @type INT */
    private $colorDepth;
 
    /** @type INT */
    private $timeZone;
    
    /** @type STRING */
    private $ipAddress;

    /** @type BOOL */
    private $javaEnabled;
    
    /** @type BOOL */
    private $javascriptEnabled;

    /**
     * @return STRING header
     */
    public function getAcceptHeader()
    {
        return $this->acceptHeader;
    }


    /**
     * @param STRING accept header
     * @return VOID
     */
    public function setAcceptHeader(string $acceptHeader) : void
    {
        $this->acceptHeader = $acceptHeader;
    }


    /**
     * @return STRING of browser language
     */
    public function getBrowserLanguage()
    {
        return $this->browserLanguage;
    }


    /**
     * @param STRING of browser language
     * @return VOID
     */
    public function setBrowserLanguage(string $browserLanguage) : void
    {
        $this->browserLanguage = $browserLanguage;
    }


    /**
     * @return INT of browser screen width
     */
    public function getScreenWidth()
    {
        return $this->screenWidth;
    }


    /**
     * @param INT browser screen width
     * @return VOID
     */
    public function setScreenWidth(int $screenWidth) : void
    {
        $this->screenWidth = $screenWidth;
    }


    /**
     * @return INT browser screen height
     */
    public function getScreenHeight()
    {
        return $this->screenHeight;
    }


    /**
     * @param INT browser screen height
     * @return VOID
     */
    public function setScreenHeight(int $screenHeight) : void
    {
        $this->screenHeight = $screenHeight;
    }


    /**
     * @return STRING of window size
     */
    public function getChallengeWindowSize()
    {
        return $this->challengeWindowSize;
    }


    /**
     * @param STRING of window size
     * @return VOID
     */
    public function setChallengeWindowSize($challengeWindowSize) : void
    {
        $this->challengeWindowSize = $challengeWindowSize;
    }


    /**
     * @return STRING of user agent
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }


    /**
     * @param STRING of user agent
     * @return VOID
     */
    public function setUserAgent(string $userAgent) : void
    {
        $this->userAgent = $userAgent;
    }


    /**
     * @return INT of color depth
     */
    public function getColorDepth()
    {
        return $this->colorDepth;
    }


    /**
     * @param INT of color depth
     * @return VOID
     */
    public function setColorDepth(int $colorDepth) : void
    {
        $this->colorDepth = $colorDepth;
    }


    /**
     * @return INT of time zone
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }


    /**
     * @param INT of time zone
     * @return VOID
     */
    public function setTimeZone(int $timeZone) : void
    {
        $this->timeZone = $timeZone;
    }


    /**
     * @return STRING ip adress
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }
    

    /**
     * @param STRING ip adress
     * @return VOID
     */
    public function setIpAddress(string $ipAddress) : void
    {
        $this->ipAddress = $ipAddress;
    }


    /**
     * @return BOOL is java enabled?
     */
    public function getJavaEnabled()
    {
        return $this->javaEnabled == true;
    }


    /**
     * @param BOOL is java enabled?
     * @return VOID
     */
    public function setJavaEnabled(bool $javaEnabled) : void
    {
        $this->javaEnabled = $javaEnabled;
    }


    /**
     * @return BOOL is javascript enabled?
     */
    public function getJavascriptEnabled()
    {
        return $this->javascriptEnabled == true;
    }
    

    /**
     * @param BOOL is javascript enabled?
     * @return VOID
     */
    public function setJavascriptEnabled(bool $javascriptEnabled) : void
    {
        $this->javascriptEnabled == $javascriptEnabled;
    }
}