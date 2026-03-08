<?php

namespace Kopou\SESEngine\Jobs;

use Aws\Ses\SesClient;
use Illuminate\Bus\Queueable;
use Kopou\SESEngine\Models\SentEmail;
use Illuminate\Queue\SerializesModels;
use Kopou\SESEngine\Models\Suppression;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $subject;
    protected $html;
    protected $from;
    protected $configSet;
    protected $metadata;

    public function __construct($to, $subject, $html, $from, $configSet = null, $metadata = [])
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->html = $html;
        $this->from = $from;
        $this->configSet = $configSet;
        $this->metadata = $metadata;
    }

    public function handle()
    {
        $key = 'kopou-ses-send';

        if (RateLimiter::tooManyAttempts($key, 14)) {
            $this->release(1);
            return;
        }
        RateLimiter::hit($key, 1);

        /// Supressed email check. Whether in suppressed list. NEVER send.
        if (Suppression::isSuppressed($this->to)) {
            return;
        }

        $tags = [];
        foreach ($this->metadata as $key => $value) {
            $tags[] = [
                'Name' => $key,
                'Value' => (string) $value
            ];
        }

        $client = new SesClient([
            'version' => 'latest',
            'region' => config('kopousesengine.ses.region'),
            'credentials' => [
                'key' => config('kopousesengine.ses.key'),
                'secret' => config('kopousesengine.ses.secret'),
            ],
        ]);

        $params = [
            'Destination' => [
                'ToAddresses' => [$this->to],
            ],
            'Message' => [
                'Subject' => [
                    'Data' => $this->subject,
                ],
                'Body' => [
                    'Html' => [
                        'Data' => $this->html,
                    ],
                ],
            ],
            'Source' => $this->from,
            'Tags' => $tags,
        ];

        if ($this->configSet) {
            $params['ConfigurationSetName'] = $this->configSet;
        }

        $result = $client->sendEmail($params);

        $messageId = $result['MessageId'] ?? null;

        SentEmail::create([
            'email' => $this->to,
            'subject' => $this->subject,
            'message_id' => $messageId,
            'configuration_set' => $this->configSet,
            'metadata' => json_encode($this->metadata),
            'sent_at' => now(),
        ]);
    }
}
