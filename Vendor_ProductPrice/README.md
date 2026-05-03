# Vendor_ProductPrice

Dynamic product pricing surcharge module with Admin control.

## Features
- **Admin Toggle:** Enable or disable the surcharge from the backend.
- **Dynamic Percentage:** Set any percentage (e.g., 5, 10, 15) in the Admin panel.
- **Frontend Only:** Prices are modified on the frontend display; Admin prices remain original for reporting.

## Configuration
1. Go to **Stores > Configuration**.
2. Look for the **Vendor Settings** tab on the left.
3. Open **Product Price Settings**.
4. Set **Enable Surcharge** to "Yes" and enter your desired percentage.

## Developer Docs
- **Plugin Path:** `Plugin/Catalog/Pricing/Price/FinalPricePlugin.php`
- **Config Path:** `price_modifier/general/surcharge_amount`
- **Performance:** Uses `ScopeConfigInterface` for optimized database reads. Since configuration is cached in Magento's config cache, this has negligible impact on TTFB (Time to First Byte).

## Installation
```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:clean