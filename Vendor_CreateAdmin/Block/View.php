<?php
/** 
 * Block to display admin user information for Vendor_CreateAdmin module       
 */     
namespace Vendor\CreateAdmin\Block;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\View\Element\Template;
use Vendor\CreateAdmin\Helper\Logger;
/** 
 * Block to display admin user information for Vendor_CreateAdmin module       
 */ 
class View extends Template
{
    /** @var Session */
    protected $authSession;
    /** @var Logger */
    protected $logger;
    /** 
     * Constructor to initialize the block
     * @param Session $authSession
     * @param Logger $logger
     */
    public function __construct(Session $authSession, Logger $logger)
    {
        $this->authSession = $authSession;
        $this->logger = $logger;
    }
    /** 
     * Method to get the current logged in admin user information
     * @return \Magento\User\Model\User|null The current logged in admin user or null if there is no user logged in
     */
    public function getCurrentUser()
    {
        $this->logger->add($this->authSession->getUser());
        return $this->authSession->getUser();
    }
}
