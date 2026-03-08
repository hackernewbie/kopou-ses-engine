<?php

namespace Kopou\SESEngine\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class SesWebhookController extends Controller
{
    public function handle(\Illuminate\Support\Facades\Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        if (!$payload) {
            return response()->json(['status' => 'invalid payload'], 400);
        }

        // Handle SNS subscription confirmation
        if (($payload['Type'] ?? null) === 'SubscriptionConfirmation') {

            file_get_contents($payload['SubscribeURL']);

            return response()->json(['status' => 'subscription confirmed']);
        }

        if (($payload['Type'] ?? null) !== 'Notification') {
            return response()->json(['status' => 'ignored']);
        }

        $message = json_decode($payload['Message'], true);
        ///return $message;            ///Raw response from SES via SNS
        if (!$message) {
            return response()->json(['status' => 'no message']);
        }

        $notificationType = $message['notificationType'] ?? null;

        $mail = $message['mail'] ?? [];
        $messageId = $mail['messageId'] ?? null;
        //$timestamp = $mail['timestamp'] ?? now();
        $timestamp = isset($mail['timestamp'])
            ? Carbon::parse($mail['timestamp'])->toDateTimeString()
            : now();

        $recipients = $mail['destination'] ?? [];

        foreach ($recipients as $email) {

            DB::table('kopou_email_events')->insert([
                'email' => $email,
                'event_type' => strtolower($notificationType),
                'message_id' => $messageId,
                'payload' => json_encode($message),
                'event_time' => $timestamp,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($notificationType === 'Bounce' || $notificationType === 'Complaint') {

                DB::table('kopou_suppression_list')->updateOrInsert(
                    ['email' => $email],
                    [
                        'reason' => strtolower($notificationType),
                        'source' => 'ses',
                        'suppressed_at' => now(),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        return response()->json(['status' => 'processed']);
    }
}
