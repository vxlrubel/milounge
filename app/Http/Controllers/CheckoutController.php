<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Guest;
use App\Services\BranchService;
use App\Services\BusinessScheduleService;
use App\Services\ConsumerService;
use App\Services\FCMNotificationService;
use App\Services\GuestService;
use App\Services\OrderService;
use App\Services\SendSMSNotification;
use App\Services\SocketIoNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function index()
    {
        // remove sessions
        session()->forget([
            'order_id',
            'order',
        ]);

        // Discount products
        $products = cache('products') ?? [];
        $discount_products = collect($products)->where('type', '=', 'DISCOUNT')->values() ?? [];

        $business_schedules = BusinessScheduleService::get();

        return view('checkout', compact('discount_products', 'business_schedules'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'payment_type' => ['required', 'string', Rule::in('CASH', 'CARD')],
            'order_type' => ['required', 'string', Rule::in('DELIVERY', 'COLLECTION')],
            'requested_hour' => ['required'],
            'requested_minute' => ['nullable', 'string'],
            'requested_timestamp' => ['nullable', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            'discount_product' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect('/checkout')->with('error', $validator->errors()->first());
        }

        // dd($request->all());
        $payment_type = $request->payment_type;
        $order_type = $request->order_type;
        $requested_hour = $request->requested_hour;
        $requested_minute = $request->requested_minute ?? "00";
        $requested_timestamp = $request->requested_timestamp ?? null;
        $delivery_charge = $request->delivery_charge ?? null;
        $service_charge = $request->service_charge ?? 0;
        $discount_product = $request->discount_product ?? null;
        $discount_amount = $request->discount_amount ?? null;
        $full_cart_comment = $request->full_cart_comment ?? null;

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;
        $email = $request->email;

        // $requested_delivery_timestamp = self::requestedTimeCalculation($order_type, $requested_hour, $requested_minute);
        $requested_delivery_timestamp = Carbon::parse($requested_timestamp)->format('Y-m-d H:i:s');

        $requested_delivery_timestamp_type = null;
        if ($requested_hour === 'ASAP') {
            $requested_delivery_timestamp_type = 'ASAP';
        }

        // dd($requested_delivery_timestamp);

        $shipping_address = $request->shipping_address ?? null;

        if ($shipping_address === ' NEW') {
            $shipping_address_id = null;
        } else {
            $shipping_address_id = $shipping_address;
        }

        session()->put('shipping_address', $request->all());

        $cart = json_decode($request->cart) ?? [];

        $body_order_item = [];

        foreach ($cart as $key => $detail) {

            //dd($detail);
            $body_order_item[$key]['id'] = $detail->product->id ?? null;;
            $body_order_item[$key]['unit'] = $detail->unit ?? 1;
            $body_order_item[$key]['unit_price'] = $detail->unit_price ?? 0;
            $body_order_item[$key]['comment'] = $detail->comment ?? '';

            $selected_components = $detail->selected_components ?? [];
            $selected_components_N = $detail->selected_components_N ?? [];
            $components = [];
            foreach ($selected_components as $k => $value) {
                $components[$k]['uuid'] = $value->uuid ?? null;
                $components[$k]['unit'] = $value->unit;

                //Sub components
                $sub_components = [];

                $selected_sub_components = $value->selected_sub_components ?? null;
                if ($selected_sub_components) {
                    foreach ($selected_sub_components as $i => $selected_sub_component) {
                        $sub_component_uuid = $selected_sub_component->uuid ?? null;
                        if (!$sub_component_uuid) {
                            break;
                        }
                        $sub_components[$i]['uuid'] = $sub_component_uuid;
                        $sub_components[$i]['unit'] = 1;
                    }

                }

                //Sub components N
                $selected_sub_components_N = $value->selected_sub_components_N ?? null;
                if ($selected_sub_components_N) {
                    $sub_components_N = [];
                    foreach ($selected_sub_components_N as $i => $selected_sub_component) {
                        $sub_component_uuid = $selected_sub_component->product->uuid ?? null;
                        $sub_component_unit = $selected_sub_component->unit ?? 1;
                        if (!$sub_component_uuid) {
                            break;
                        }
                        $sub_components_N[$i]['uuid'] = $sub_component_uuid;
                        $sub_components_N[$i]['unit'] = $sub_component_unit;
                    }
                    array_push($sub_components, ...$sub_components_N); // add N component in one array
                }

                $components[$k]['items'] = $sub_components;
            }

            //For relation_type N
            $components_N = [];
            foreach ($selected_components_N as $i => $value) {
                $component_N_uuid = $value->uuid ?? null;
                if (!$component_N_uuid) {
                    break;
                }

                $selected_sub_components = $value->sub_components ?? [];
                $sub_components = [];
                foreach ($selected_sub_components as $j => $selected_sub_component) {
                    $sub_component_uuid = $selected_sub_component->uuid ?? null;
                    if (!$sub_component_uuid) {
                        break;
                    }
                    $sub_components[$j]['uuid'] = $sub_component_uuid;
                    $sub_components[$j]['unit'] = 1;
                }

                $components_N['uuid'] = $component_N_uuid;
                $components_N['unit'] = $value->unit ?? 1;
                $components_N['items'] = $sub_components;

                array_push($components, $components_N);
            }

            if ($components) {
                $body_order_item[$key]['items'] = $components;
            }
        }

        // for discount product
        if($discount_product){
            $body_order_discount_item = [
                "id" => $discount_product,
                "unit" => 1,
                "comment" => "discounted",
            ];
            array_push($body_order_item, $body_order_discount_item);
        }

        //dd($body_order_item);

        if (session('user')) {
            $requester = session('user');
            $requester_id = $requester->id ?? null;
        } else {
            $guest_response = GuestService::store(new Request([
                'first_name' => $first_name ?? null,
                'last_name' => $last_name ?? null,
                'email' => $email ?? null,
                'phone' => $phone ?? null,
            ]));
            $requester_id = session('guest')->id;
        }

        $order_response = OrderService::store([
            "payment_type" => $payment_type,
            "order_type" => $order_type,
            "requested_delivery_timestamp_type" => $requested_delivery_timestamp_type,
            "requested_delivery_timestamp" => $requested_delivery_timestamp,
            "shipping_address_id" => $shipping_address_id,
            "shipping_address_house" => $request->house ?? null,
            "shipping_address_town" => $request->city ?? null,
            "shipping_address_state" => $request->street ?? null,
            "shipping_address_postcode" => $request->postcode ?? null,
            "shipping_address_address" => $request->address ?? null,
            "items" => $body_order_item ?? [],
            "requester_id" => $requester_id,
            "discount_amount" => $discount_amount,
            "delivery_charge" => $delivery_charge,
            "service_charge" => $service_charge,
            "full_cart_comment" => $full_cart_comment,
        ]);

        $order = $order_response->data ?? null;
        $order_id = $order->id ?? null;
        if(!$order) {
            return back()->with('error', 'The order may include expired or out-of-stock products.')->with('clear_cart', 'true');
        }

        session()->put('order', $order);
        session()->put('order_id', $order_id);

        // if phone is not saved (google login) then we need to store it
        $user = session('user');
        if ($user) {
            $phone = $user->phone ?? null;
            if (!$phone) {
                ConsumerService::update(new Request([
                    'first_name' => $user->property->first_name,
                    'last_name' => $user->property->last_name,
                    'phone' => $request->phone ?? null,
                ]));
            }
        }

        // if payment is CASH or CARD{
        if ($payment_type === 'CASH') {

            $branch = BranchService::current();

            // change the order status
            $updatePaymentReference = OrderService::update([
                'order_id' => $order_id,
                'status' => 'NEW',
                'branch_value' => $branch,
            ]);

            if ($updatePaymentReference) {

                // Send Notification to EPOS
                FCMNotificationService::send([
                    "order_id" => session('order_id'),
                    "topic_key" => 'order-created-'. $branch,
                ]);

                // Send Notification to SocketIo
                $provider = \App\Services\Utils::getProvider();
                $provider_uuid = $provider->uuid ?? null;
                if($provider_uuid) {
                    SocketIoNotificationService::send([
                        "order_id" => session('order_id'),
                        "event_name" => 'notification',
                        "providerId" => $branch.'-'.$provider_uuid,
                    ]);
                }

                // Send Email
                $email_res = OrderService::sendEmail([
                    'order_id' => session('order_id')
                ]);

                //Send sms notification
                $sms_service = \App\Services\GlobalSettingService::key('sms_service') ?? null;
                if ($sms_service === "TRUE") {

                    $phone = $order->requester->phone ?? $order->requester_guest->phone ?? '';

                    if($phone) {
                        $sms_send = new SendSMSNotification();
                        $sms_send->send(new Request([
                            'order_id' => $order_id,
                            "name" => $order->requester->name ?? $order->requester_guest->first_name ?? '',
                            "phone" => $phone,
                            "order_timestamp" => $order->order_date ?? now()->format('Y-m-d H:i:s'),
                        ]));
                    }

                }

                // clear session
                session()->forget([
                    'shipping_address',
                    'order_id',
                    'order',
                    'requests',
                ]);

                return redirect('/order-confirm')->with('message', 'Your order is successful')->with('clear_cart', 'true');

            } else{

                return redirect('/checkout')->with('error', 'Your order is not placed');

            }

        } else {
            if(config('services.stream.payment_type') === 'HOSTED') {
                return redirect('/payment/hosted');
            }else{
                return redirect('/payment');
            }
        }

    }

    private static function requestedTimeCalculation($order_type, $requested_hour, $requested_minute)
    {
        $requested_time = now()->format('H:i:s');

        $start_time = null;
        $duration = 0;

        // check for the starting time of the business for to day;
        $today_name = strtolower(date('l'));
        $business_opening_time_key = 'opening_time_'.$today_name;
        $opening_time = \App\Services\GlobalSettingService::key($business_opening_time_key) ?? null;
        $requested_delivery_time_calculation = \App\Services\GlobalSettingService::key('requested_delivery_time_calculation') ?? null;

        $current_time = Carbon::now()->format('H:i:s');

        if($order_type === 'COLLECTION') {

            $collection_from_key = 'collection_from_'.$today_name;
            $start_time = \App\Services\GlobalSettingService::key($collection_from_key) ?? null;

            if(!$opening_time) {
                $opening_time = $start_time;
            }

            $duration = \App\Services\GlobalSettingService::key('estimated_collection_duration') ?? 0;
            $duration = (int) $duration;

            if ($requested_hour === 'ASAP') {

                // check if starting time and current time
                if($opening_time > Carbon::now()->format('H:i:s')){
                    // if opening time yet to come then make this request to the starting time of the business;
                    $requested_time = $opening_time;
                    $duration = \App\Services\GlobalSettingService::key('est_col_duration_before_opening_time') ?? $duration;

                }else{

                    $duration = \App\Services\GlobalSettingService::key('est_col_duration_after_opening_time') ?? $duration;
                    $requested_time = $current_time;

                }

            }else{

                $requested_time = $requested_hour . ':' . $requested_minute . ':00';

                if($opening_time > $current_time) {

                    // business will open after sometime
                    $duration = \App\Services\GlobalSettingService::key('est_col_duration_before_opening_time') ?? $duration;

                    // requested time >= opening_time + estimated duration then duration will be 0; no time will add
                    if($requested_time >= Carbon::createFromFormat('H:i:s', $opening_time)->addMinutes($duration)->format('H:i:s')){
                        $duration = 0;
                    }

                }else{
                    // business is open
                    $duration = \App\Services\GlobalSettingService::key('est_col_duration_after_opening_time') ?? $duration;

                    // check requested time will current time + estimated duration
                    if($requested_time >= Carbon::createFromFormat('H:i:s', $current_time)->addMinutes($duration)->format('H:i:s')){
                        $duration = 0;
                    }

                }

            }

        }

        if($order_type === 'DELIVERY') {
            $delivery_from_key = 'delivery_from_'.$today_name;
            $start_time = \App\Services\GlobalSettingService::key($delivery_from_key) ?? null;

            if(!$opening_time) {
                $opening_time = $start_time;
            }

            $duration = \App\Services\GlobalSettingService::key('estimated_delivery_duration') ?? 0;
            $duration = (int) $duration;

            if ($requested_hour === 'ASAP') {

                // check if business is open or not
                if($opening_time > Carbon::now()->format('H:i:s')){
                    // if opening time yet to come then make this request to the starting time of the business;
                    if($requested_delivery_time_calculation === 'from_delivery_or_collection_time') {
                        $requested_time = $start_time;
                    }else{
                        $requested_time = $opening_time;
                    }
                    $duration = \App\Services\GlobalSettingService::key('est_del_duration_before_opening_time') ?? $duration;

                }else{

                    // business open
                    $duration = \App\Services\GlobalSettingService::key('est_del_duration_after_opening_time') ?? $duration;

                    // delivery will start after sometime
                    if($start_time > $current_time) {
                        $requested_time = $start_time;
                    }else{
                        $requested_time = $current_time;
                    }

                }

            }else{

                $requested_time = $requested_hour . ':' . $requested_minute . ':00';

                if($opening_time > $current_time) {

                    // business will open after sometime
                    $duration = \App\Services\GlobalSettingService::key('est_del_duration_before_opening_time') ?? $duration;

                    // requested time >= opening_time + estimated duration then duration will be 0; no time will add
                    if($requested_time >= Carbon::createFromFormat('H:i:s', $opening_time)->addMinutes($duration)->format('H:i:s')){
                        $duration = 0;
                    }

                }else{
                    // business is open
                    $duration = \App\Services\GlobalSettingService::key('est_del_duration_after_opening_time') ?? $duration;

                    // check requested time will current time + estimated duration
                    if($requested_time >= Carbon::createFromFormat('H:i:s', $current_time)->addMinutes($duration)->format('H:i:s')){
                        $duration = 0;
                    }

                }

            }

        }


        $timestamp = Carbon::now()->format('Y-m-d') .' '. $requested_time;

        return Carbon::parse($timestamp)->addMinutes($duration)->format('Y-m-d H:i:s');
    }
}
