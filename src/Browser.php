<?php

namespace Sinergi\BrowserDetector;

class Browser
{
    const UNKNOWN = 'unknown';
    const VIVALDI = 'Vivaldi';
    const OPERA = 'Opera';
    const OPERA_MINI = 'Opera Mini';
    const WEBTV = 'WebTV';
    const IE = 'Internet Explorer';
    const POCKET_IE = 'Pocket Internet Explorer';
    const KONQUEROR = 'Konqueror';
    const ICAB = 'iCab';
    const OMNIWEB = 'OmniWeb';
    const FIREBIRD = 'Firebird';
    const FIREFOX = 'Firefox';
    const SEAMONKEY = 'SeaMonkey';
    const ICEWEASEL = 'Iceweasel';
    const SHIRETOKO = 'Shiretoko';
    const MOZILLA = 'Mozilla';
    const AMAYA = 'Amaya';
    const LYNX = 'Lynx';
    const SAFARI = 'Safari';
    const SAMSUNG_BROWSER = 'SamsungBrowser';
    const CHROME = 'Chrome';
    const NAVIGATOR = 'Android Navigator';
    const BLACKBERRY = 'BlackBerry';
    const ICECAT = 'IceCat';
    const NOKIA_S60 = 'Nokia S60 OSS Browser';
    const NOKIA = 'Nokia Browser';
    const MSN = 'MSN Browser';
    const NETSCAPE_NAVIGATOR = 'Netscape Navigator';
    const GALEON = 'Galeon';
    const NETPOSITIVE = 'NetPositive';
    const PHOENIX = 'Phoenix';
    const GSA = 'Google Search Appliance';
    const YANDEX = 'Yandex';
    const EDGE = 'Edge';
    const DRAGON = 'Dragon';
    const NSPLAYER = 'Windows Media Player';
    const UCBROWSER = 'UC Browser';
    const MICROSOFT_OFFICE = 'Microsoft Office';
    const APPLE_NEWS = 'Apple News';
    const DALVIK = 'Android';

    const VERSION_UNKNOWN = 'unknown';

    const ENGINE_UNKNOWN = 'unknown';
    const ENGINE_BLINK = 'Blink'; //Google Chrome, Opera 15+, Sleipnir 5+, Maxthon 4.2+
    const ENGINE_DILLO = 'Dillo'; //Dillo. TODO: Detect Dillo browser
    const ENGINE_EDGEHTML = 'EdgeHTML'; //Microsoft Edge
    const ENGINE_GECKO = 'Gecko'; //Firefox, Camino, K-Meleon, SeaMonkey, Netscape, etc..
    const ENGINE_GOANNA = 'Goanna'; //Pale Moon TODO: Detect Pale Moon
    const ENGINE_HTML_LAYOUT = 'HTMLayout'; //TODO: Detect HTMlayout
    const ENGINE_ICAB = 'iCab'; //Versions 1-3
    const ENGINE_KHTML = 'KHTML'; //Konqueror
    const ENGINE_LINKS = 'Links'; //Links, text-based TODO: Detect Links
    const ENGINE_LINKS2 = 'Links2'; //Links launched with -g TODO: DetectLinks
    const ENGINE_LYNX = 'Lynx'; //Lynx, Text-based
    const ENGINE_NETFRONT = 'NetFront'; //Access NetFront TODO: Detect NetFront
    const ENGINE_NETSCAPE = 'Netscape'; //NetScape < 6.0 TODO: Proper netscape detection
    const ENGINE_NETSURF = 'NetSurf'; //NetSurf TODO: Detect NetSurf
    const ENGINE_OFFBYONE = 'OffByOne'; //OffbyOne TODO: Detect OffbyOne
    const ENGINE_OMNIWEB = 'Omniweb'; //Omniweb 1-4
    const ENGINE_OPERA = 'Opera'; //Opera < 7
    const ENGINE_PRESTO = 'Presto'; //Opera 7-15
    const ENGINE_PRINCE = 'Prince'; //Web-page printer - i.e Prince/11.1 (www.princexml.com) TODO: Detect prince
    const ENGINE_ROBIN = 'Robin'; //The Bat! TODO: Detect The Bat
    const ENGINE_SERVO = 'Servo'; //By mozilla/samsung TODO: Detect Servo
    const ENGINE_TASMAN = 'Tasman'; //IE 5 for mac, Office 2004 for mac, office 2008 for mac TODO: Detect Tasman
    const ENGINE_TRIDENT = 'Trident'; //IE
    const ENGINE_TKHTML = 'TKHTML'; //hv3 TODO: Detect hv3
    const ENGINE_W3M = 'W3m'; //TODO: Detect W3m
    const ENGINE_U3 = 'U3'; //Usee by UCBrowser. Based on WebKit.
    const ENGINE_WEBKIT = 'Webkit'; //Safari, Arora, Midori, OmniWeb < 5, Shiira, iCab, Web, SRWare Iron, Rekonq, Sleipnir, Maxthon 3, Google chrome <= 27

    /**
     * @var UserAgent
     */
    private $userAgent;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $layoutEngine;

    /**
     * @var bool
     */
    private $isChromeFrame = false;

    /**
     * @var bool
     */
    private $isFacebookWebView = false;

    /**
     * @var bool
     */
    private $isTwitterWebView = false;

    /**
     * @var bool
     */
    private $isCompatibilityMode = false;

    /**
     * @param null|string|UserAgent $userAgent
     *
     * @throws \Sinergi\BrowserDetector\InvalidArgumentException
     */
    public function __construct($userAgent = null)
    {
        if ($userAgent instanceof UserAgent) {
            $this->setUserAgent($userAgent);
        } elseif (null === $userAgent || is_string($userAgent)) {
            $this->setUserAgent(new UserAgent($userAgent));
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * Set the name of the Browser.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * Return the name of the Browser.
     *
     * @return string
     */
    public function getName()
    {
        if (!isset($this->name)) {
            BrowserDetector::detect($this, $this->getUserAgent());
        }

        return $this->name;
    }

    /**
     * Check to see if the specific browser is valid.
     *
     * @param string $name
     *
     * @return bool
     */
    public function isBrowser($name)
    {
        return (0 == strcasecmp($this->getName(), trim($name)));
    }

    /**
     * Set the version of the browser.
     *
     * @param string $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = (string)$version;

        return $this;
    }

    /**
     * The version of the browser.
     *
     * @return string
     */
    public function getVersion()
    {
        if (!isset($this->name)) {
            BrowserDetector::detect($this, $this->getUserAgent());
        }

        return (string) $this->version;
    }

    /**
     * Set the layout engine of the browser.
     *
     * @param string $layoutEngine
     *
     * @return $this
     */
    public function setLayoutEngine($layoutEngine)
    {
        $this->layoutEngine = (string)$layoutEngine;

        return $this;
    }

    /**
     * The layout engine of the browser.
     *
     * @return string
     */
    public function getLayoutEngine()
    {
        if (!isset($this->name)) {
            BrowserDetector::detect($this, $this->getUserAgent());
        }

        return (string) $this->layoutEngine;
    }

    /**
     * Detects scripted agents (robots / bots)
     * Returns a resolved ScriptedAgent object if detected.
     * Otherwise returns false.
     *
     * @return ScriptedAgent|bool
     */
    public function detectScriptedAgent()
    {
        $ua = $this->getUserAgent()->getUserAgentString();
        if (stripos($ua, 'bot') !== FALSE ||
            stripos($ua, 'spider') !== FALSE ||
            stripos($ua, 'crawler') !== FALSE ||
            stripos($ua, 'preview') !== FALSE ||
            stripos($ua, 'slurp') !== FALSE ||
            stripos($ua, 'facebookexternalhit') !== FALSE ||
            stripos($ua, 'mediapartners') !== FALSE ||
            stripos($ua, 'google-adwords') !== FALSE ||
            stripos($ua, 'adxvastfetcher') !== FALSE ||
            stripos($ua, 'adbeat') !== FALSE ||
            stripos($ua, 'google favicon') !== FALSE ||
            stripos($ua, 'webdav client') !== FALSE ||
            stripos($ua, 'metauri api') !== FALSE ||
            stripos($ua, 'tlsprobe') !== FALSE ||
            stripos($ua, 'wpif') !== FALSE ||
            stripos($ua, 'imgsizer') !== FALSE ||
            stripos($ua, 'netcraft ssl server survey') !== FALSE ||
            stripos($ua, 'curl/') !== FALSE ||
            stripos($ua, 'go-http-client/') !== FALSE ||
            stripos($ua, 'python') !== FALSE ||
            stripos($ua, 'libwww') !== FALSE ||
            stripos($ua, 'wget/') !== FALSE ||
            stripos($ua, 'zgrab/') !== FALSE ||
            stripos($ua, 'Java/') !== FALSE ||
            stripos($ua, '() { :;}; /bin/bash -c') !== FALSE ||
            stripos($ua, 'browsershots') !== FALSE ||
            stripos($ua, 'magereport') !== FALSE ||
            stripos($ua, 'ubermetrics-technologies') !== FALSE ||
            stripos($ua, 'W3C') !== FALSE ||
            stripos($ua, 'Validator') !== FALSE ||
            stripos($ua, 'Jigsaw/') !== FALSE ||
            stripos($ua, 'bing') !== FALSE ||
            stripos($ua, 'msn') !== FALSE ||
            stripos($ua, 'Google Web Preview') !== FALSE ||
            stripos($ua, 'ips-agent') !== FALSE ||
            (stripos($ua, 'Chrome/51.0.2704.103') !== FALSE && !isset($_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS']) && stristr($_SERVER['HTTP_ACCEPT_LANGUAGE'], "ru-RU") !== FALSE) //ICQ Preview
        )
        {
            $scriptedAgent = new ScriptedAgent($ua);
            if ($scriptedAgent->getName()==ScriptedAgent::UNKNOWN)
            {
                return false;
            }
            else
            {
                return $scriptedAgent;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * @param bool $isChromeFrame
     *
     * @return $this
     */
    public function setIsChromeFrame($isChromeFrame)
    {
        $this->isChromeFrame = (bool)$isChromeFrame;

        return $this;
    }

    /**
     * Used to determine if the browser is actually "chromeframe".
     *
     * @return bool
     */
    public function getIsChromeFrame()
    {
        if (!isset($this->name)) {
            BrowserDetector::detect($this, $this->getUserAgent());
        }

        return $this->isChromeFrame;
    }

    /**
     * @return bool
     */
    public function isChromeFrame()
    {
        return $this->getIsChromeFrame();
    }

    /**
     * @param bool $isFacebookWebView
     *
     * @return $this
     */
    public function setIsFacebookWebView($isFacebookWebView)
    {
        $this->isFacebookWebView = (bool) $isFacebookWebView;

        return $this;
    }

    /**
     * Used to determine if the browser is actually "facebook".
     *
     * @return bool
     */
    public function getIsFacebookWebView()
    {
        if (!isset($this->name)) {
            BrowserDetector::detect($this, $this->getUserAgent());
        }

        return $this->isFacebookWebView;
    }

    /**
     * @return bool
     */
    public function isFacebookWebView()
    {
        return $this->getIsFacebookWebView();
    }

    /**
     * @param bool $isTwitterWebView
     *
     * @return $this
     */
    public function setIsTwitterWebView($isTwitterWebView)
    {
        $this->isTwitterWebView = (bool) $isTwitterWebView;

        return $this;
    }

    /**
     * Used to determine if the browser is actually "Twitter".
     *
     * @return bool
     */
    public function getIsTwitterWebView()
    {
        if (!isset($this->name)) {
            BrowserDetector::detect($this, $this->getUserAgent());
        }

        return $this->isTwitterWebView;
    }

    /**
     * @return bool
     */
    public function isTwitterWebView()
    {
        return $this->getIsTwitterWebView();
    }

    /**
     * @param UserAgent $userAgent
     *
     * @return $this
     */
    public function setUserAgent(UserAgent $userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * @return UserAgent
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param bool
     *
     * @return $this
     */
    public function setIsCompatibilityMode($isCompatibilityMode)
    {
        $this->isCompatibilityMode = $isCompatibilityMode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCompatibilityMode()
    {
        return $this->isCompatibilityMode;
    }

    /**
     * Render pages outside of IE's compatibility mode.
     */
    public function endCompatibilityMode()
    {
        header('X-UA-Compatible: IE=edge');
    }
}
