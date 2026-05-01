<?php

namespace Encora\CreateAdmin\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\State;
use Magento\Framework\App\Helper\AbstractHelper;
use \Symfony\Component\Console\Input\Input;
use \Magento\User\Model\UserFactory;
use Magento\Framework\Exception\LocalizedException;
use Encora\CreateAdmin\Helper\Logger;

class AdminHelper extends AbstractHelper
{
    const ADMIN_USERNAME = "admin-user-name";
    const ADMIN_EMAIL = 'email';
    const ADMIN_FIRSTNAME = 'firstname';
    const ADMIN_LASTNAME = 'lastname';
    const ADMIN_PASSWORD = 'password';

    protected $storeManager;
    protected $state;
    protected $data;
    protected $_userFactory;
    protected $_logger;

    public function __construct(
        Context $context,
        State $state,
        UserFactory $userFactory,
        Logger $_logger
    )
    {
        $this->state = $state;
        $this->_userFactory = $userFactory;
        $this->_logger=$_logger;

        parent::__construct($context);
    }

    public function setData(Input $input)
    {
        $this->data = $input;
        return $this;
    }

    public function execute()
    {
        $userName = $this->data->getOption(self::ADMIN_USERNAME);
        $email = $this->data->getOption(self::ADMIN_EMAIL);
        $firstname = $this->data->getOption(self::ADMIN_FIRSTNAME);
        $lastname = $this->data->getOption(self::ADMIN_LASTNAME);
        $password = $this->data->getOption(self::ADMIN_PASSWORD);

        try {
            if (!$userName || !$email || !$firstname || !$lastname || !$password) {
                throw new LocalizedException(__("Parameter Missing"));
            }

            $adminUser = $this->_userFactory->create();
            $adminInfo = [
                'username' => "enc_".$userName,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'interface_locale' => 'en_US',
                'is_active' => 1
            ];
            $adminUser->setData($adminInfo);
            $adminUser->setRoleId(1);
            $adminUser->save();
            return $adminUser;
        } catch (\Exception $e) {
             $this->_logger->error($e);
             return false;
        }
    }


}
