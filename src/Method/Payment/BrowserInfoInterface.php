<?php

namespace Cardinity\Method\Payment;


interface BrowserInfoInterface
{
    // private $acceptHeader;
    // private $browserLanguage;
    // private $screenWidth;
    // private $screenHeight;
    // private $challengeWindowSize;
    // private $userAgent;
    // private $colorDepth;
    // private $timeZone;
    // private $ipAddress;
    // private $javaEnabled;
    // private $javascriptEnabled;

    public function getAcceptHeader(string $acceptHeader);

    public function setAcceptHeader();

    public function getBrowserLanguage();

    public function setBrowserLanguage();

    public function getScreenWidth();

    public function setScreenWidth();

    public function getScreenHeight();

    public function setScreenHeight();

    public function getChallengeWindowSize();

    public function setChallengeWindowSize();

    public function getUserAgent();

    public function setUserAgent();

    public function getColorDepth();

    public function setColorDepth();

    public function getTimeZone();

    public function setTimeZone();

    public function getIpAddress();
    
    public function setIpAddress();

    public function getJavaEnabled();

    public function setJavaEnabled();

    public function getJavascriptEnabled();
    
    public function setJavascriptEnabled();
}