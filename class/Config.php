<?php

namespace Phpemailreader;

use DevCoder\DotEnv;



class Config
{
    private static $_instance = null;

    public string $sHostName;
    public string $sUserName;
    public string $sPassword;
    public string $sHostString;
    public string $sAttachedDir;
    public array $aKnownProviders;
    public string $sKnownProvider;

    public static function getInstance($sProvider)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config($sProvider);
        }

        return self::$_instance;
    }

    private function __construct(string $sProvider)
    {
        $this->setKnownProvider();
        if ($this->isProviderValid($sProvider)) {
            $oDotenv = (new DotEnv(__DIR__ . './../.Env'))->load();
            $this->setConfig($sProvider);
        }
    }

    private function setKnownProvider()
    {
        $this->aKnownProviders = [
            'gmail',
            'proton',
            'Outlook',
            'kMail',
            'Mailo',
            'GMX',
            'MailFence',
            'iCloudMail',
            'YahooMail',
        ];
    }

    private function setConfig(string $sProvider)
    {
        $this->sHostName = getenv(strtoupper($sProvider) . '_HOSTNAME');
        $this->sUserName = getenv(strtoupper($sProvider) . '_USERNAME');
        $this->sPassword = getenv(strtoupper($sProvider) . '_PASSWORD');
        $this->sKnownProvider = $sProvider;
        $this->sHostString = $sProvider;
        $this->sAttachedDir = __DIR__;
    }

    public function isProviderValid(string $sProvider)
    {
        return in_array($sProvider, $this->aKnownProviders);
    }

}