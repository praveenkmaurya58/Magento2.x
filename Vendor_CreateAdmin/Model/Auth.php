<?php

namespace Vendor\CreateAdmin\Model;

class Auth extends \Magento\Backend\Model\Auth
{
    // Overriding the default login function of Class \Magento\Backend\Model\Auth

    public function login($username, $password){
        // Checks for Custom created user by this module
        if (strpos($username, 'vendor_') !== false) {
            self::throwException(
                __(
                    'You are not allow to login..'.'Because of checks for Custom Admin.'
                )
            );
        }

        // For Normal Admin Customer

        if (empty($username) || empty($password)) {
            self::throwException(
                __(
                    'The account sign-in was incorrect or your account is disabled temporarily. '
                    . 'Please wait and try again later.'
                )
            );
        }

        try {
            $this->_initCredentialStorage();
            $this->getCredentialStorage()->login($username, $password);
            if ($this->getCredentialStorage()->getId()) {
                $this->getAuthStorage()->setUser($this->getCredentialStorage());
                $this->getAuthStorage()->processLogin();

                $this->_eventManager->dispatch(
                    'backend_auth_user_login_success',
                    ['user' => $this->getCredentialStorage()]
                );
            }

            if (!$this->getAuthStorage()->getUser()) {
                self::throwException(
                    __(
                        'The account sign-in was incorrect or your account is disabled temporarily. '
                        . 'Please wait and try again later.'
                    )
                );
            }
        } catch (PluginAuthenticationException $e) {
            $this->_eventManager->dispatch(
                'backend_auth_user_login_failed',
                ['user_name' => $username, 'exception' => $e]
            );
            throw $e;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_eventManager->dispatch(
                'backend_auth_user_login_failed',
                ['user_name' => $username, 'exception' => $e]
            );
            self::throwException(
                __(
                    $e->getMessage()? : 'The account sign-in was incorrect or your account is disabled temporarily. '
                        . 'Please wait and try again later.'
                )
            );
        }
    }
}
