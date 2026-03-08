<?php

namespace Kopou\SESEngine\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    public function open($messageId)
    {
        DB::table('kopou_email_events')->insert([
            'email' => null,
            'event_type' => 'open',
            'message_id' => $messageId,
            'payload' => null,
            'event_time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response(base64_decode(
            'R0lGODlhAQABAPAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='
        ), 200)->header('Content-Type', 'image/gif');
    }

    public function click(Request $request, $messageId)
    {
        $url = $request->get('url');

        DB::table('kopou_email_events')->insert([
            'email' => null,
            'event_type' => 'click',
            'message_id' => $messageId,
            'payload' => json_encode(['url' => $url]),
            'event_time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->away($url);
    }
}
