# Vendor_AbandonedCart

## Overview
This module automates the management of abandoned quotes in Magento 2. It provides two core functions via a daily cron job running at midnight:
1. **Admin Reporting:** Scans for carts abandoned within the last 24-48 hours and emails a summary to the general store contact.
2. **Database Cleanup:** Deletes active quotes older than 30 days to maintain database performance.

## Installation
1. Upload the files to `app/code/Vendor/AbandonedCart`.
2. Run:
   ```bash
   bin/magento setup:upgrade
   bin/magento setup:di:compile