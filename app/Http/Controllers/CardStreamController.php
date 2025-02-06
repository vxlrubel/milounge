<?php

namespace App\Http\Controllers;

use App\SDK\CardStream;
use App\Services\BranchService;
use App\Services\CardPaymentResponseService;
use App\Services\ExceptionService;
use App\Services\FCMNotificationService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\SocketIoNotificationService;
use App\Services\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class CardStreamController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function direct(Request $request)
    {
        //dd(session('requests'));

        echo Stream::show_processing_screen();

        // Signature key entered on MMS. The demo account is fixed to this value,
        CardStream::$merchantSecret = config('services.stream.key');
        // Gateway URL
        CardStream::$directUrl = config('services.stream.directUrl');

        $merchantID = config('services.stream.merchant_id');

        // Setup PHP session as use it to store data between 3DS steps
        if (isset($_GET['sid'])) {
            session_id($_GET['sid']);
        }
        session_start();

        // Compose current page URL (removing any sid and acs parameters)
        $pageUrl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://')
            . $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '')
            . preg_replace('/(sid=[^&]+&?)|(acs=1&?)/', '', $_SERVER['REQUEST_URI']);

        // Add back the correct sid parameter (used as session cookie may not be passed when the page is redirected from an IFRAME)
        $pageUrl .= (strpos($pageUrl, '?') === false ? '?' : '&') . 'sid=' . urlencode(session_id());

        // If ACS response into the IFRAME then redirect back to parent window
        if (!empty($_GET['acs'])) {
            echo Stream::silentPost($pageUrl, array('threeDSResponse' => $_POST), '_parent');
            exit();
        }

        $amount = \session('requests')['amount'] ?? $request->amount ?? 0;
        $amount = (float)$amount * 100; //to cents

        if (!isset($_POST['threeDSResponse'])) {

            if (isset($_POST['payment'])) {

                $cardNumber = str_replace(' ', '', $request->input('cardNumber'));
                $request->merge(['cardNumber' => $cardNumber]);

                // Validation
                $validator = Validator::make($request->all(), [
                    'customerName' => ['required', 'string' , 'regex:/^[a-zA-Z\s]+$/'],
                    'cardNumber' => ['required', 'numeric'],
                    'cardExpiryMonth' => ['required', 'numeric', 'max:12'],
                    'cardExpiryYear' => ['required', 'numeric'],
                    'cardCVV' => ['required', 'numeric'],
                    'amount' => ['required', 'numeric'],
                ], [
                    'customerName.regex' => 'The name field must contain only letters.',
                ]);
                if ($validator->fails()) {
                    return redirect('/payment')->with('error', $validator->errors()->first());
                }

                session()->put('requests', $request->all());
                session()->save();
            }

            $cardNumber = \session('requests')['cardNumber'] ?? '';
            $cardNumber = str_replace(' ', '', $cardNumber);

            $cardExpiryMonth = \session('requests')['cardExpiryMonth'] ?? '';
            $cardExpiryYear = \session('requests')['cardExpiryYear'] ?? '';
            $cardCVV = \session('requests')['cardCVV'] ?? '';
            $customerName = \session('requests')['customerName'] ?? '';
            $customerEmail = \session('requests')['customerEmail'] ?? '';
            $customerPhone = \session('requests')['customerPhone'] ?? '';
            $address = \session('requests')['address'] ?? '';
            $postcode = \session('requests')['postcode'] ?? '';

            //dd($request->all(), session('requests'));
            $req = array(
                'merchantID' => $merchantID,
                'action' => 'SALE',
                'type' => 1,
                'currencyCode' => 826,
                'countryCode' => 826,
                'amount' => $amount,
                'cardNumber' => $cardNumber,
                'cardExpiryMonth' => $cardExpiryMonth,
                'cardExpiryYear' => $cardExpiryYear,
                'cardCVV' => $cardCVV,
                'customerName' => $customerName,
                'customerEmail' => $customerEmail,
                'customerPhone' => $customerPhone,
                'customerAddress' => $address,
                'customerPostCode' => $postcode,
                'orderRef' => config('app.name'),
                'duplicateDelay' => 5,

                'remoteAddress' => $_SERVER['REMOTE_ADDR'],
                'threeDSRedirectURL' => $pageUrl . '&acs=1',

                // The following field allows options to be passed for 3DS v2
                // and the values here are for demonstration purposes only
                'threeDSOptions' => array(
                    'paymentAccountAge' => '20190601',
                    'paymentAccountAgeIndicator' => '05',
                ),
            );

            if (!isset($_POST['browserInfo'])) {
                echo CardStream::collectBrowserInfo();
                exit();
            }

            $req += $_POST['browserInfo'] ?? [];

        } else {
            // 3DS continuation request
            $req = array(
                // The following field are only required for tbe benefit of the SDK
                'merchantID' => $merchantID,
                'action' => 'SALE',

                // The following field must be passed to continue the 3DS request
                'threeDSRef' => $_SESSION['threeDSRef'],
                'threeDSResponse' => $_POST['threeDSResponse'],
            );

        }

        try {
            $res = CardStream::directRequest($req);
        } catch (\Exception $e) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $e->getMessage(),
            ]);

            return redirect('/checkout')->with('error', $e->getMessage());
        }

        # store card payment response

        // remove all customer and card info
        $res_data = array_filter($res, function ($key) {
            return !(str_starts_with($key, 'card') || str_starts_with($key, 'customer'));
        }, ARRAY_FILTER_USE_KEY);

        // then store response
        $card_payment_response = CardPaymentResponseService::send([
            'order_id' =>session('order_id'),
            'body' => json_encode($res_data),
        ]);

        // Check the response code
        if ($res['responseCode'] === CardStream::RC_3DS_AUTHENTICATION_REQUIRED) {

            // Render an IFRAME to show the ACS challenge (hidden for fingerprint method)
            // $style = (isset($res['threeDSRequest']['threeDSMethodData']) ? 'display: none;' : '');
            // echo "<iframe name=\"threeds_acs\" style=\"height:420px; width:420px; {$style}\"></iframe>\n";

            // Silently POST the 3DS request to the ACS in the IFRAME
            echo Stream::silentPost($res['threeDSURL'], $res['threeDSRequest'], '_self');

            // Remember the threeDSRef as need it when the ACS responds
            $_SESSION['threeDSRef'] = $res['threeDSRef'];

        } elseif ($res['responseCode'] === CardStream::RC_SUCCESS) {

            $reference = $res['xref'] ?? '';
            $cardType = $res['cardTypeCode'] ?? '';

            if ($amount > 0) {
                // save payment
                $user_id = session('user')->id ?? null;
                $guest_id = session('guest')->id ?? null;
                if (session('user')) {
                    $requester_id = $user_id;
                } else {
                    $requester_id = $guest_id;
                }
                $payment_response = PaymentService::store([
                    'requester_type' => session('user') ? 'CONSUMER' : 'GUEST',
                    'requester_id' => $requester_id,
                    'payment_date' => now()->format('Y-m-d H:i:s'),
                    'amount' => $amount,
                    'reference' => $reference,
                    'source' => 'STREAM',
                    'status' => 'APPROVED',
                    'card_type' => $cardType
                ]);
                if (!$payment_response) {
                    return redirect('/order-confirm')->with('message', 'Your order and payment is successful. However we are unable to process your payment. Please contact admin')->with('clear_cart', true);
                }

                $payment_id = $payment_response->data->id ?? null;

                // update order with the payment id
                $updatePaymentReference = OrderService::update([
                    'order_id' => session('order_id'),
                    'payment_id' => $payment_id,
                    'status' => "NEW",
                ]);
                if (!$updatePaymentReference) {
                    return redirect('/order-confirm')->with('message', 'Your order and payment is successful. However we are unable to process Order status. Please contact admin')->with('clear_cart', true);
                }

                // Send FCM Notification to EPOS
                $branch = BranchService::current();
                FCMNotificationService::send([
                    "order_id" => session('order_id'),
                    "topic_key" => 'order-created-' . $branch,
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
                OrderService::sendEmail([
                    'order_id' => session('order_id')
                ]);

                // clear session
                session()->forget([
                    'shipping_address',
                    'order_id',
                    'order',
                    'requests',
                ]);

                return redirect('/order-confirm')->with('message', 'Your order and payment is successful.')->with('clear_cart', true);

            }

            return redirect('/order-confirm')->with('message', 'Your order and payment is successful. However we are unable to see the payment amount. Please contact admin')->with('clear_cart', true);

        } else {

            $msg = json_encode($res);

            Log::info($msg);

            $res_msg = $res['responseMessage'] ?? '';
            $code = $res['responseCode'] ?? '';

            if ($code === 65554) {
                $msg = 'Duplicate Request';
                $code = '';
            } elseif ($code === 65803) {
                $msg = 'Your card is declined';
                $code = '';
            } elseif ($code === 66320) {
                $msg = 'Your card CVV is invalid';
                $code = '';
            } elseif ($code === 66321) {
                $msg = 'Customer name is invalid';
                $code = '';
            } elseif ($code === 66323) {
                $msg = 'Customer postcode is invalid';
                $code = '';
            } elseif ($code === 66314) {
                $msg = 'Your card is invalid, Please try again';
                $code = '';
            } elseif ($code === 66312) {
                $msg = 'Invalid amount, Please try again';
                $code = '';
            } elseif ($code === 66315) {
                $msg = 'Invalid Card expiry month, Please try again';
                $code = '';
            } elseif ($code === 66316) {
                $msg = 'Invalid Card expiry year, Please try again';
                $code = '';
            } elseif ($code === 66347) {
                $msg = 'Invalid authentication, Please try again';
                $code = '';
            } elseif ($code === 66848) {
                $msg = 'Invalid 3DS Reference, Please try again';
                $code = '';
            } else {
                $msg = $res_msg;
                $code = '';
            }

            $ex_res = ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $res_msg,
                'info' => json_encode([
                    'order_id' => session('order_id') ?? '',
                    'order_time' => session('order')->order_date ?? '',
                    'customer_name' => \session('requests')['customerName'] ?? '',
                    'customer_email' => \session('requests')['customerEmail'] ?? '',
                    'shipping_address' => \session('order')->shipping_address->prop ?? null,
                ]),
            ]);

            // clear session
            session()->forget([
                'requests',
            ]);

            return redirect('/payment')->with('error', $msg . ' ' . $code);
        }
    }

    public function hostedGateway(Request $request)
    {
        CardStream::$merchantSecret = config('services.stream.key');
        // Gateway URL
        CardStream::$hostedUrl = config('services.stream.hostedUrl');

        $merchantID = config('services.stream.merchant_id');

        $amount = $request->amount ?? 0;
        $amount = (float)$amount * 100; //to cents

        if (!isset($_POST['responseCode'])) {
            // Send request to gateway
            $req = array(
                'merchantID' => $merchantID,
                'action' => 'SALE',
                'type' => 1,
                'currencyCode' => 826,
                'countryCode' => 826,
                'amount' => $amount,
                'orderRef' => 'Test purchase',
                'redirectURL' => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            );

            try {
                echo CardStream::hostedRequest($req);
            } catch (\Exception $e) {
                // You should exit gracefully
                die('Sorry, the request could not be sent: ' . $e);
            }

        } else {
            // Received response from gateway
            try {
                CardStream::verifyResponse($_POST);
            } catch (\Exception $e) {
                // You should exit gracefully
                die('Sorry, the request could not be sent: ' . $e);
            }

            // Check the response code
            if ($_POST['responseCode'] === 0) {
                echo "<p>Thank you for your payment.</p>";
            } else {
                echo "<p>Failed to take payment: " . htmlentities($_POST['responseMessage']) . "</p>";
            }
        }
    }

    public function hosted(Request $request)
    {
        //dd($request->all());

        $orderId = $request->orderRef;
        $orderUserRole = $request->orderUserRole;
        $requester_id = $request->orderUserId;

        $responseCode = $request->responseCode;
        $reference = $request->xref;
        $cardType = $request->cardType;

        // Successful
        if($responseCode === '0') {

            $amount = $request->amount;

            // save payment

            $payment_response = PaymentService::store([
                'requester_type' => $orderUserRole,
                'requester_id' => $requester_id,
                'payment_date' => now()->format('Y-m-d H:i:s'),
                'amount' => $amount,
                'reference' => $reference,
                'source' => 'STREAM',
                'status' => 'APPROVED',
                'card_type' => $cardType
            ]);
            if (!$payment_response) {
                return redirect('/order-confirm')->with('message', 'Your order and payment is successful. However we are unable to process your payment. Please contact admin')->with('clear_cart', true);
            }

            $payment_id = $payment_response->data->id ?? null;

            // update order with the payment id
            $updatePaymentReference = OrderService::update([
                'order_id' => $orderId,
                'payment_id' => $payment_id,
                'status' => "NEW",
            ]);
            if (!$updatePaymentReference) {
                return redirect('/order-confirm')->with('message', 'Your order and payment is successful. However we are unable to process Order status. Please contact admin')->with('clear_cart', true);
            }

            // Send Notification to EPOS
            $branch = BranchService::current();

            FCMNotificationService::send([
                "order_id" => $orderId,
                "topic_key" => 'order-created-' . $branch,
            ]);

            // Send Email
            OrderService::sendEmail([
                'order_id' => $orderId
            ]);

            // clear session
            session()->forget([
                'shipping_address',
                'order_id',
                'order',
                'requests',
            ]);

            //return response()->json(['message' => 'Order placed successfully'], 200);
            //return response('Callback processed', 200);

            return redirect('/order-confirm')->with('message', 'Your order and payment is successful.')->with('clear_cart', true);

        }else{

            $res_msg =  $request->responseMessage ?? '';
            $code =  $responseCode;

            if ($code === 65554) {
                $msg = 'Duplicate Request';
                $code = '';
            } elseif ($code === 65803) {
                $msg = 'Your card is declined';
                $code = '';
            } elseif ($code === 66320) {
                $msg = 'Your card CVV is invalid';
                $code = '';
            } elseif ($code === 66321) {
                $msg = 'Customer name is invalid';
                $code = '';
            } elseif ($code === 66323) {
                $msg = 'Customer postcode is invalid';
                $code = '';
            } elseif ($code === 66314) {
                $msg = 'Your card is invalid, Please try again';
                $code = '';
            } elseif ($code === 66312) {
                $msg = 'Invalid amount, Please try again';
                $code = '';
            } elseif ($code === 66315) {
                $msg = 'Invalid Card expiry month, Please try again';
                $code = '';
            } elseif ($code === 66316) {
                $msg = 'Invalid Card expiry year, Please try again';
                $code = '';
            } elseif ($code === 66347) {
                $msg = 'Invalid authentication, Please try again';
                $code = '';
            } elseif ($code === 66848) {
                $msg = 'Invalid 3DS Reference, Please try again';
                $code = '';
            } else {
                $msg = $res_msg;
                $code = '';
            }

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $res_msg,
            ]);

            return redirect('/payment/hosted')->with('error', $msg . ' ' . $code);

        }

    }

}
