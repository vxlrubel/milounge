<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthService
{

    public static function social_register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $avatar = $request->avatar;
        $name = $request->name;
        $email = $request->email;
        $provider = $request->provider;
        $provider_id = $request->provider_id;
        $_token = $request->_token;

        $properties = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'avatar' => $avatar,
        ];

        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'name' => $name,
            'email' => $email,
            'phone' => null,
            'username' => null,
            'password' => null,
            'password_confirmation' => null,
            'properties' => $properties,
            'provider_token' => $_token,
            'provider_id' => $provider_id,
            'provider' => $provider,
        ];

        try {
            $response = $client->post($api_url . '/consumer/social-register', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode()) {
                $data = $response->getBody();
                $data = json_decode($data);

                return $data;
            }

        } catch (\Exception $exception) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $exception->getMessage(),
            ]);

            return response()->json(['message' => "Error registration! Check if your credentials already exists", 'error' => $exception->getMessage()], 500);
        }
    }

    public static function social_login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            '_token' => 'required',
            'provider_id' => 'required',
            'provider' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $provider = $request->provider;
        $provider_id = $request->provider_id;
        $email = $request->email;
        $_token = $request->_token;

        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'email' => $email,
            'provider_token' => $_token,
            'provider_id' => $provider_id,
            'provider' => $provider,
        ];

        try {
            $response = $client->post($api_url . '/consumer/social-login', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode() === 200) {
                $data = $response->getBody();
                $data = json_decode($data);
                $_token = $data->_token ?? null;
                $user = $data->user ?? null;
                session()->put('api_token', $_token);
                session()->put('user', $user);
                session()->save();
            }
            return response()->json(['message' => "Login success"], 200);

        } catch (\Exception $exception) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $exception->getMessage(),
            ]);

            return response()->json(['message' => "Error login", 'error' => $exception->getMessage()], 422);
        }
    }

}
