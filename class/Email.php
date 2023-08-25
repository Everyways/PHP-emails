<?php
namespace Phpemailreader;

use Phpemailreader\Config;
use PhpImap\Mailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;
use PhpImap\Exceptions\ConnectionException as MyException;


class Email
{
    public string $sAttachdir;
    public object $oConfig;
    public $oEmails;


    function __construct(string $sProvider)
    {
        $this->oConfig = Config::getInstance($sProvider);
    }

    function setProvider(string $sProvider)
    {
        if ($this->oConfig->isProviderValid($sProvider)) {
        } else {
            throw new \Exception('Provider unknown');
        }
    }

    function getProvider()
    {
        return $this->oConfig->sProvider;
    }

    function connect()
    {
        try {
            return new Mailbox($this->oConfig->sHostString, $this->oConfig->sUserName, $this->oConfig->sPassword, $this->oConfig->sAttachedDir);
        } catch (MyException $ex) {
            return 'Message: ' . $ex->getMessage();

        }
    }

    function __destruct()
    {
    }
}