# Kopou SES Engine

A lightweight **Amazon SES email infrastructure engine for Laravel**.

Kopou SES Engine provides a simple, reusable layer for sending emails via **Amazon SES**, while automatically handling delivery tracking, bounce/complaint suppression, and webhook processing.

It is designed to be used as a **plug-and-play email engine** for applications such as:

- Email campaign systems
- Transactional email services
- Invoicing platforms
- Notification systems

The package focuses on **lean architecture and reliability**, leaving business logic (campaigns, lists, invoices, etc.) to the host application.

---

# Features

- Send emails through **Amazon SES**
- **Queue-based sending**
- **Multi-recipient support**
- Automatic **bounce and complaint suppression**
- Email **event tracking**
- SES **SNS webhook ingestion**
- Email **open tracking**
- Email **click tracking**
- Email send logging
- Designed to be **reusable across multiple Laravel applications**

---

# Installation

Add the repository to your Laravel project's `composer.json`:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/hackernewbie/kopou-ses-engine"
  }
]
