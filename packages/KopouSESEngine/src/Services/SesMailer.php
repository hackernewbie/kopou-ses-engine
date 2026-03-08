<?php

namespace Kopou\SESEngine\Services;

use Aws\Ses\SesClient;
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
        if (Suppression::isSuppressed($to)) {
            return [
                'status' => 'blocked',
                'reason' => 'email is suppressed'
            ];
        }

        $params = [
            'Destination' => [
                'ToAddresses' => [$to],
            ],
            'Message' => [
                'Subject' => [
                    'Data' => $subject,
                ],
                'Body' => [
                    'Html' => [
                        'Data' => $html,
                    ],
                ],
            ],
            'Source' => $from,
        ];

        if ($configSet) {
            $params['ConfigurationSetName'] = $configSet;
        }

        $result = $this->client->sendEmail($params);

        $messageId = $result['MessageId'] ?? null;

        SentEmail::create([
            'email' => $to,
            'subject' => $subject,
            'message_id' => $messageId,
            'configuration_set' => $configSet,
            'metadata' => json_encode($metadata),
            'sent_at' => now(),
        ]);

        return [
            'status' => 'sent',
            'message_id' => $messageId
        ];
    }
}
