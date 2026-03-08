<?php

namespace Kopou\SESEngine\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class SesWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        if (!$payload) {
            return Response::json(['status' => 'invalid payload'], 400);
        }

        // Handle SNS subscription confirmation
        if (($payload['Type'] ?? null) === 'SubscriptionConfirmation') {

            file_get_contents($payload['SubscribeURL']);

            return Response::json(['status' => 'subscription confirmed']);
        }

        if (($payload['Type'] ?? null) !== 'Notification') {
            return Response::json(['status' => 'ignored']);
        }

        $message = json_decode($payload['Message'], true);

        if (!$message) {
            return Response::json(['status' => 'no message']);
        }

        $notificationType = $message['notificationType'] ?? null;

        $mail = $message['mail'] ?? [];
        $messageId = $mail['messageId'] ?? null;

        $timestamp = isset($mail['timestamp'])
            ? Carbon::parse($mail['timestamp'])->toDateTimeString()
            : Carbon::now();

        $recipients = $mail['destination'] ?? [];

        foreach ($recipients as $email) {

            DB::table('kopou_email_events')->insert([
                'email' => $email,
                'event_type' => strtolower($notificationType),
                'message_id' => $messageId,
                'payload' => json_encode($message),
                'event_time' => $timestamp,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($notificationType === 'Bounce' || $notificationType === 'Complaint') {

                DB::table('kopou_suppression_list')->updateOrInsert(
                    ['email' => $email],
                    [
                        'reason' => strtolower($notificationType),
                        'source' => 'ses',
                        'suppressed_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'created_at' => Carbon::now(),
                    ]
                );
            }
        }

        return Response::json(['status' => 'processed']);
    }
}
