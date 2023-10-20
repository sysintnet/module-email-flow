# Magento 2 Email to Webhook Module (Email Flow)
Easily integrate your Magento 2 store with workflow automation platforms like **n8n, Zapier**, and many more using just one module.
Send Magento 2 emails as JSON to webhooks and bridge your store to countless services such as MailChimp, Sendgrid, HubSpot, ActiveCampaign, CRM systems, and others without needing any additional backend plugins.

It's not another SMTP provider, it's a way to send e-commerce data to an automation tool to easily connect any app without extra coding and installing additional plugins to your Magento store.
This module is not a replacement for your current email provider and does not change your SMTP settings.
Although you can only use workflow n8n or Zapier to send emails and SMS, by default emails will be sent through your current email provider and workflow, but you can always change this.

**N8N Example workflow**
![image](https://github.com/sysintnet/module-email-flow/assets/8642724/c714d6eb-b9a3-4c52-b366-e4bef0dda4a1)


## Table of Contents
1. [Features](#features)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Compatibility](#compatibility)
6. [Support](#support)
7. [License](#license)

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
![image](https://github.com/sysintnet/module-email-flow/assets/8642724/16a1a808-fecd-409b-a849-242435112bcb)




1. Enable plugin 
2. Input your webhook URL.
3. Sending mode. By default, mixed means that emails will be sent by SMTP + FLOW. You'll be able to set up your workflow and keep sending emails.
4. Select authentication type: NONE, Base, API (`NONE by default`)
5. Debug: Yes/No (`No - by default`). Log file `var/log/debug.log`
6. Data Optimization Yes/No (`Yes - by default`)
7. Save the configuration.

## Usage
Once configured, the module will automatically send emails as JSON payloads to the specified webhook URL in real-time.
This data can then be used in your preferred workflow automation platform to trigger workflows, save data, and integrate with other services like Mailchimp, Sendgrid, HubSpot & etc.

When debugging is enabled, messages can be found in the log file `var/log/debug.log`
Example of the message:
`[2023-10-20T07:51:34.110881+00:00] .DEBUG: {"message":"Workflow was started"} [] []`

### Tested across platforms
- N8N
- Zapier

## Compatibility
- Magento 2.3, 2.4, 2.5, 2.6
- PHP 7.3, 7.4, 8.1, 8.2

## Support
For any issues, questions, or feedback, please open an issue on our GitHub repository

## License
This module is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
