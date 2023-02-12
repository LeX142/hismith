<?php

namespace App\Listeners;

use App\Models\RequestLog;
use Illuminate\Http\Client\Events\ResponseReceived;

class LogResponseReceived
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event for Http::Client request and create record in DB with stats.
     *
     * @param  ResponseReceived  $event
     * @return void
     */
    public function handle(ResponseReceived $event)
    {
        $responseStats = $event->response->handlerStats();

        RequestLog::create([
            'request_method' => $event->request->method(),
            'request_url'    => $event->request->url(),
            'response_code'  => $event->response->status(),
            'response_body'  => $event->response->body(),
            'response_time'  => round($responseStats['total_time_us'] / 1000),
        ]);
    }
}
