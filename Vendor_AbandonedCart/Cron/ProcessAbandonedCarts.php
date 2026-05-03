<?php
/** Process abandoned carts */
declare(strict_types=1);

namespace Vendor\AbandonedCart\Cron;

use Magento\Quote\Model\ResourceModel\Quote\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Vendor\AbandonedCart\Model\Mailer;
use Psr\Log\LoggerInterface;
/**
 * Cron class to process abandoned carts: notify admin of recent ones and clean up old quotes.  
 */
class ProcessAbandonedCarts
{
    protected $collectionFactory;
    protected $mailer;
    protected $scopeConfig;
    protected $logger;
    
    /**
     * @param CollectionFactory $collectionFactory
     * @param Mailer $mailer
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Mailer $mailer,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->mailer = $mailer;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * Execute the cron job.
     */
    public function execute(): void
    {
        $this->notifyAdminOfRecentAbandonedCarts();
        $this->cleanupOldQuotes();
    }

    /**
     * Notify Admin of carts abandoned in the last 24 hours.
     */
    private function notifyAdminOfRecentAbandonedCarts()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', 1);
        
        // Carts updated between 24 and 48 hours ago
        $from = date('Y-m-d H:i:s', strtotime('-48 hours'));
        $to = date('Y-m-d H:i:s', strtotime('-24 hours'));
        
        $collection->addFieldToFilter('updated_at', ['from' => $from, 'to' => $to]);

        if ($collection->getSize() > 0) {
            $this->mailer->sendAdminNotification($collection);
        }
    }

    /**
     * Clean up quotes older than 30 days.
     */
    private function cleanupOldQuotes()
    {
        $days = (int) $this->scopeConfig->getValue('abandoned_cart/general/cleanup_days') ?: 30;
        $thresholdDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', 1);
        $collection->addFieldToFilter('updated_at', ['lt' => $thresholdDate]);

        foreach ($collection as $quote) {
            try {
                $quote->delete();
            } catch (\Exception $e) {
                $this->logger->error("Failed to delete quote ID {$quote->getId()}: " . $e->getMessage());
            }
        }
    }
}