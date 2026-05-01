<?php
/**
 * Logger helper for Vendor_CreateAdmin module
 */
namespace Vendor\CreateAdmin\Helper;
/**
 * Logger class to log messages and errors for Vendor_CreateAdmin module
 */
class Logger
{   
    /** @var string */
    private $logFileName = "/var/log/vendor_adminuser.log";
    /** @var \Zend\Log\Logger */
    private $logger;
    /** 
     * Constructor to initialize the logger with a file writer      
     * */   
    public function __construct()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . $this->logFileName);
        $this->logger = new \Zend\Log\Logger();
        $this->logger->addWriter($writer);
    }

    /** 
     * Method to log informational messages
     * @param string $msg The message to be logged
     */
    public function add($msg)
    {
        $this->logger->info($msg);
    }

    /** 
     * Method to log error messages
     * @param string $error The error message to be logged
     */   
    public function error($error)
    {
        $this->logger->err($error);
    }
}
