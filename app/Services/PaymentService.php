<?php

namespace App\Services;

class PaymentService
{

    public static function store($request)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $reference = $request['reference'] ?? null;
        $requester_type = $request['requester_type'] ?? null;
        $requester_id = $request['requester_id'] ?? null;
        $payment_date = $request['payment_date'] ?? null;
        $amount = $request['amount'] ?? null;
        $comment = $request['comment'] ?? null;
        $source = $request['source'] ?? null;
        $card_type = $request['card_type'] ?? null;
        $status = $request['status'] ?? null;

        $body = [
            'reference' => $reference,
            'requester_type' => $requester_type,
            'requester_id' => $requester_id,
            'payment_date' => $payment_date,
            "amount" => $amount,
            "comment" => $comment,
            "source" => $source,
            'card_type' => $card_type,
            "status" => $status,
        ];

        try {
            $response = $client->post($api_url . '/payment', [
                'body' => json_encode($body)
            ]);
            return json_decode($response->getBody());
        } catch (\Exception $exception) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $exception->getMessage(),
            ]);

            return $exception->getMessage();
        }
    }

}
