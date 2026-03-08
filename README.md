# Kopou SES Engine

![License](https://img.shields.io/github/license/hackernewbie/kopou-ses-engine)
![PHP](https://img.shields.io/badge/PHP-%3E%3D7.4-blue)
![Laravel](https://img.shields.io/badge/Laravel-8%20%7C%209-red)
![Amazon
SES](https://img.shields.io/badge/Amazon%20SES-supported-orange)
![Status](https://img.shields.io/badge/status-active-success)

A lightweight **Amazon SES email infrastructure engine for Laravel**.

Kopou SES Engine provides a reusable layer for sending emails through
**Amazon SES**, while automatically handling delivery tracking,
bounce/complaint suppression, and webhook processing.

It is designed to act as a **lean email infrastructure engine** that can
power multiple applications such as:

-   Email campaign systems
-   Transactional email services
-   Invoicing platforms
-   Notification systems
-   Internal messaging tools

The package focuses only on **email infrastructure**, leaving business
logic such as campaigns, lists, templates, and contacts to the host
application.

------------------------------------------------------------------------

## Features

-   Send emails through **Amazon SES**
-   **Queue-based email delivery**
-   **Multi-recipient sending**
-   Automatic **bounce suppression**
-   Automatic **complaint suppression**
-   Email **delivery event tracking**
-   **SES SNS webhook ingestion**
-   Email **open tracking**
-   Email **click tracking**
-   Email **send logging**
-   Designed for **reuse across multiple Laravel applications**

------------------------------------------------------------------------

## Architecture Overview

Laravel Application │ ▼ Kopou SES Engine │ ▼ Amazon SES │ ▼ Amazon SNS │
▼ Webhook Endpoint │ ▼ Database Tables

kopou_sent_emails\
kopou_email_events\
kopou_suppression_list

------------------------------------------------------------------------

## Requirements

PHP \>= 7.4\
Laravel 8 or 9\
Amazon SES account

------------------------------------------------------------------------

## Installation

Add the repository to your Laravel project's `composer.json`:

``` json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/hackernewbie/kopou-ses-engine"
  }
]
```

Then install the package:

``` bash
composer require kopou/ses-engine:dev-master
```

Laravel will automatically discover the package service provider.

------------------------------------------------------------------------

## Configuration

Publish the configuration file:

``` bash
php artisan vendor:publish --tag=kopou-config
```

This will create:

config/kopousesengine.php

------------------------------------------------------------------------

## Database Setup

Run migrations to create required tables:

``` bash
php artisan migrate
```

The following tables will be created:

kopou_sent_emails\
kopou_email_events\
kopou_suppression_list

These tables store email logs, delivery events, and suppressed
addresses.

------------------------------------------------------------------------

## Queue Setup

Emails are sent using Laravel queues.

Start a queue worker:

``` bash
php artisan queue:work
```

This ensures email sending does not block application requests.

------------------------------------------------------------------------

## Amazon SES Setup

Ensure Amazon SES is configured and your sending domain or email is
verified.

Add credentials to `.env`:

    AWS_ACCESS_KEY_ID=your_key
    AWS_SECRET_ACCESS_KEY=your_secret
    AWS_DEFAULT_REGION=us-east-1

------------------------------------------------------------------------

## SES Webhook Setup

To receive delivery events from SES, configure **Amazon SNS
notifications**.

Create an SNS topic and enable notifications for:

-   Bounce
-   Complaint
-   Delivery

Subscribe the webhook endpoint:

https://yourdomain.com/kopou/ses/webhook

The engine will automatically:

-   record email events
-   suppress bounced addresses
-   suppress complaint addresses

------------------------------------------------------------------------

## Sending Your First Email

Example usage:

``` php
use Kopou\SESEngine\Facades\KopouSESEngine;

KopouSESEngine::send(
    'user@example.com',
    'Welcome',
    '<h1>Hello</h1>',
    'hello@yourdomain.com'
);
```

------------------------------------------------------------------------

## Sending to Multiple Recipients

You can send to multiple recipients in one call:

``` php
KopouSESEngine::send(
    [
        'user1@example.com',
        'user2@example.com',
        'user3@example.com'
    ],
    'Hello',
    '<h1>Greetings</h1>',
    'hello@yourdomain.com'
);
```

Each email is queued and sent individually.

------------------------------------------------------------------------

## Example Use Cases

Kopou SES Engine can power:

-   Email campaign managers
-   Newsletter platforms
-   SaaS notification systems
-   Transactional invoicing systems
-   Internal communication tools

------------------------------------------------------------------------

## License

MIT License
