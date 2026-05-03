<?php
/**
 * FinalPricePlugin
 * 
 * @category  Vendor
 * @package   Vendor_ProductPrice
 */
declare(strict_types=1);

namespace Vendor\ProductPrice\Plugin\Catalog\Pricing\Price;

use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class FinalPricePlugin
{
    private const XML_PATH_ENABLED = 'price_modifier/general/enabled';
    private const XML_PATH_SURCHARGE = 'price_modifier/general/surcharge_amount';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param FinalPrice $subject
     * @param float $result
     * @return float
     */
    public function afterGetValue(FinalPrice $subject, $result): float
    {
        // 1. Check if the module is enabled in Admin
        $isEnabled = $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED, 
            ScopeInterface::SCOPE_STORE
        );

        if (!$isEnabled || $result <= 0) {
            return (float) $result;
        }

        // 2. Fetch the percentage amount
        $percentage = (float) $this->scopeConfig->getValue(
            self::XML_PATH_SURCHARGE, 
            ScopeInterface::SCOPE_STORE
        );

        if ($percentage > 0) {
            $multiplier = 1 + ($percentage / 100);
            return (float) ($result * $multiplier);
        }

        return (float) $result;
    }
}