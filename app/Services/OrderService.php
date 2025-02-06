<?php

namespace App\Services;

class OrderService
{

    public static function store($request)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $order_type = $request['order_type'] ?? 'DELIVERY';
        $payment_type = $request['payment_type'] ?? 'CASH';
        $order_channel = $request['order_channel'] ?? 'ONLINE';
        $order_date = $request['order_date'] ?? now()->format('Y-m-d H:i:s');
        $requested_delivery_timestamp = $request['requested_delivery_timestamp'] ?? now()->format('Y-m-d H:i:s');
        $requester_id = $request['requester_id'];
        $delivery_charge = $request['delivery_charge'] ?? null;
        $discount_amount = $request['discount_amount'] ?? null;
        $service_charge = $request['service_charge'] ?? 0;
        $full_cart_comment = $request['full_cart_comment'] ?? null;
        $requested_delivery_timestamp_type = $request['requested_delivery_timestamp_type'] ?? null;
        $branch = BranchService::current();

        $shipping_address_id = $request['shipping_address_id'] ?? null;
        $shipping_address = [
            "house" => $request['shipping_address_house'] ?? null,
            "town" => $request['shipping_address_town'] ?? null,
            "state" => $request['shipping_address_state'] ?? null,
            "postcode" => $request['shipping_address_postcode'] ?? null,
            "address" => $request['shipping_address_address'] ?? null,
            "first_name" => $request['shipping_address_first_name'] ?? null,
            "last_name" => $request['shipping_address_last_name'] ?? null,
            "email" => $request['shipping_address_email'] ?? null,
            "phone" => $request['shipping_address_phone'] ?? null,
        ];

        $payment_id = $request['payment_id'] ?? null;
        $items = $request['items'] ?? [];

        $order_properties = [];
        $order_properties["comment"] = $request['comment'] ?? null;
        if($requested_delivery_timestamp_type === 'ASAP') {
            $order_properties["requested_delivery_timestamp_type"] = 'ASAP';
        }

        $body = [
            'order_date' => $order_date,
            'order_type' => $order_type,
            'requester_id' => $requester_id,
            'order_status' => null,
            "order_channel" => $order_channel,
            "payment_type" => $payment_type,
            "payment_id" => $payment_id,
            'requested_delivery_timestamp' => $requested_delivery_timestamp,
            "items" => $items,
            "order_properties" => $order_properties,
            "delivery_charge" => $delivery_charge,
            "discount_amount" => $discount_amount,
            "service_charge" => $service_charge,
            "branch" => $branch,
            "order_comment" => $full_cart_comment,
        ];

        if(!session('user')) {
            $requester = [
                "first_name" => $request['shipping_address_first_name'] ?? null,
                "last_name" => $request['shipping_address_last_name'] ?? null,
                "email" => $request['shipping_address_email'] ?? null,
                "phone" => $request['shipping_address_phone'] ?? null,
            ];

            $body['requester'] = $requester;
        }

        if ($shipping_address_id != 'NEW') {
            $body['shipping_address_id'] = $shipping_address_id;
        } else {
            $body['shipping_address'] = $shipping_address;
        }

        try {
            $response = $client->post($api_url . '/order', [
                'body' => json_encode($body)
            ]);

            return json_decode($response->getBody());

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public static function update($request)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $order_id = $request['order_id'] ?? null;
        if (!$order_id) return false;

        $payment_id = $request['payment_id'] ?? null;
        $status = $request['status'] ?? null;
        $branch_value = $request['branch_value'] ?? null;

        $body = [];
        if ($payment_id) {
            $body["payment_id"] = $payment_id;
        }
        if ($status) {
            $body["status"] = $status;
        }
        if ($branch_value) {
            $body["branch_value"] = $branch_value;
        }

        try {
            $response = $client->patch($api_url . '/order/' . $order_id, [
                'body' => json_encode($body)
            ]);
            return json_decode($response->getBody());
        } catch (\Exception $exception) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public static function show($order_id)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        try {
            $response = $client->get($api_url . '/order/' . $order_id);
            return json_decode($response->getBody());
        } catch (\Exception $exception) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public static function sendEmail($request)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $order_id = $request['order_id'] ?? null;
        if (!$order_id) return false;

        $requester_id = session('user')->id ?? session('guest')->id ?? null;

        $body = [];
        $body["order_id"] = $order_id;
        $body["branch"] = BranchService::current();

        try {
            $response = $client->post($api_url . '/order/send-email', [
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
