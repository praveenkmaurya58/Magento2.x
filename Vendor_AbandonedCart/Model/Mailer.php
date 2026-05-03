<?php
declare(strict_types=1);

namespace Vendor\AbandonedCart\Model;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class Mailer
{
    protected $transportBuilder;
    protected $scopeConfig;
    protected $storeManager;

    public function __construct(
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function sendAdminNotification($collection)
    {
        $adminEmail = $this->scopeConfig->getValue('trans_email/ident_general/email');
        $store = $this->storeManager->getStore();

        $transport = $this->transportBuilder
            ->setTemplateIdentifier('abandoned_admin_notification')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store->getId()])
            ->setTemplateVars(['quotes' => $collection, 'store' => $store])
            ->setFromByScope('general')
            ->addTo($adminEmail)
            ->getTransport();

        $transport->sendMessage();
    }
}