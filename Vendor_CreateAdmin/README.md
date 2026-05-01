# Vendor_CreateAdmin

Magento 2 custom admin authentication module.

## Overview

This module provides custom admin login functionality with enhanced security features.

## Features

- Custom admin authentication model
- Custom admin login template
- Console command for creating admin users

## Installation

```bash

php bin/magento module:enable Vendor_CreateAdmin
php bin/magento setup:upgrade
```

## Module Structure

```
Vendor_CreateAdmin/
├── Block/
│   └── View.php
├── Console/
│   └── Command/
│       └── CreateAdminUser.php
├── etc/
│   ├── di.xml
│   └── module.xml
├── Helper/
│   ├── AdminHelper.php
│   └── Logger.php
├── Model/
│   └── Auth.php
├── view/
│   └── frontend/
│       ├── layout/
│       │   └── default.xml
│       └── templates/
│           └── admin/
│               └── login.phtml
├── composer.json
├── registration.php
└── README.md
```

## Configuration

The module is configured via `etc/di.xml` which includes:
- Custom console command registration
- Preference for `Magento\Backend\Model\Auth`

## Usage

### Create Admin User via CLI

```bash
php bin/magento vendor:admin:create --username="admin" --email="admin@example.com" --password="password"
```

## Requirements

- Magento 2.4.x
- PHP 7.4+ or 8.1+

## License

Open Software License (OSL-3.0)