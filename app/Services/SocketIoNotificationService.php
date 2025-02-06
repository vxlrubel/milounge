<?php

namespace App\Services;

use Illuminate\Http\Request;
use ElephantIO\Client;
use Mockery\Exception;

class SocketIoNotificationService
{
    public static function send($request)
    {

        try {

            $url = 'http://188.166.170.229:3000';

            // if client option is omitted then it will use latest client available,
            // aka. version 4.x
            $options = ['client' => Client::CLIENT_4X];

            $client = Client::create($url, $options);
            $client->connect();
            $client->of('/'); // can be omitted if connecting to default namespace

            $order_id = $request['order_id'];
            $event_name = $request['event_name'];
            $emit_name = $request['providerId'];

            // emit an event to the server
            $data = ['providerId' => $emit_name, 'order_id' => $order_id];
            $client->emit($event_name, $data);

            // end session
            $client->disconnect();

            return true;

        }catch (\Exception $exception){
            return $exception->getMessage();
        }


    }
}
