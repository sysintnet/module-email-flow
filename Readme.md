# Magento 2 Email to Webhook Module (Email Flow)
Easily integrate your Magento 2 store with workflow automation platforms like **n8n, Zapier**, and many more. Send Magento 2 emails as JSON to webhooks and bridge your store to countless services such as MailChimp, Sendgrid, HubSpot, ActiveCampaign, CRM systems, and others without needing any additional backend plugins.

## Table of Contents
1. Features
2. Installation 
3. Configuration 
4. Usage 
5. Compatibility 
6. Support 
7. License 

## Features
- **Real-time Email Dispatching:** Send your Magento store emails as JSON payloads in real-time.
- **Universal Webhook Integration:** Easily connect to platforms like n8n, Zapier, and many others.
- **Plug & Play:** No need for additional backend plugins or integrations.
- **Secure:** Ensures that data is sent securely over HTTPS to the designated webhook. Supports Base Auth and API Auth.

## Installation
### Composer install

```bash
composer require sysint/module-email-flow
```

### Download the module
Extract the files to your Magento installation's app/code directory.
Run the following commands:

```bash
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

The module will now be installed and ready for configuration.

## Configuration
Navigate to `Stores > Configuration > Advanced > System > Email Flow Sending Settings`

1. Enable plugin 
2. Input your webhook URL.
3. Select authentication type: NONE, Base, API (`NONE by default`)
4. Debug: Yes/No (`No - by default`)
5. Data Optimization Yes/No (`Yes - by default`)
6. Save the configuration.

## Usage
Once configured, the module will automatically send emails as JSON payloads to the specified webhook URL in real-time.
This data can then be used in your preferred workflow automation platform to trigger workflows, save data, and integrate with other services like Mailchimp, Sendgrid, HubSpot & etc.

### Tested across platforms
- N8N
- Zapier

## Compatibility
Magento 2.3, 2.4, 2.5, 2.6

## Support
For any issues, questions, or feedback, please open an issue on our GitHub repository

## License
This module is licensed under the GNU General Public License (GPL) license.

