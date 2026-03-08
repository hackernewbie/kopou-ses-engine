# Kopou SES Engine

![License](https://img.shields.io/github/license/hackernewbie/kopou-ses-engine)
![PHP](https://img.shields.io/badge/PHP-%3E%3D7.4-blue)
![Laravel](https://img.shields.io/badge/Laravel-8%20%7C%209-red)
![Amazon SES](https://img.shields.io/badge/Amazon%20SES-supported-orange)
![Status](https://img.shields.io/badge/status-active-success)

A lightweight **Amazon SES email infrastructure engine for Laravel**.

Kopou SES Engine provides a reusable infrastructure layer for sending emails through **Amazon SES**, while automatically handling delivery tracking, bounce/complaint suppression, and webhook processing.

It is designed to power applications such as:

- Email campaign systems
- Transactional email services
- Invoicing platforms
- Notification systems
- Internal messaging tools

The package focuses only on **email infrastructure**, leaving business logic (campaigns, lists, templates, contacts, etc.) to the host application.

---

# Quick Start

Install the package:

```bash
composer require kopou/ses-engine:dev-master
