<?php

namespace Kopou\SESEngine\Services;

use Aws\Ses\SesClient;
use Kopou\SESEngine\Jobs\SendEmailJob;

use Kopou\SESEngine\Models\SentEmail;
use Kopou\SESEngine\Models\Suppression;

class SesMailer
{
    protected $client;

    public function __construct()
    {
        $this->client = new SesClient([
            'version' => 'latest',
            'region' => config('kopousesengine.ses.region'),
            'credentials' => [
                'key' => config('kopousesengine.ses.key'),
                'secret' => config('kopousesengine.ses.secret'),
            ],
        ]);
    }

    public function send($to, $subject, $html, $from, $configSet = null, $metadata = [])
    {
        $recipients = is_array($to) ? $to : [$to];

        foreach ($recipients as $email) {

            SendEmailJob::dispatch(
                $email,
                $subject,
                $html,
                $from,
                $configSet,
                $metadata
            );
        }

        return [
            'status' => 'queued',
            'recipients' => count($recipients)
        ];
    }
}
