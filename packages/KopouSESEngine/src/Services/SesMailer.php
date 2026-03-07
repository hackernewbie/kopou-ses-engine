<?php

namespace Kopou\SESEngine\Services;

use Aws\Ses\SesClient;

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

    public function send($to, $subject, $html, $from, $configSet = null)
    {
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

        return $this->client->sendEmail($params);
    }
}
