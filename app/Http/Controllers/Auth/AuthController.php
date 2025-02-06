<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ConsumerService;
use App\Services\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginIndex(Request $request)
    {
        $rp = $request->rp ?? null;

        if($rp) {
            session()->put('rp', $rp);
        }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $username = $request->username;
        $password = $request->password;

        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'username' => $username,
            'password' => $password
        ];

        try {
            $response = $client->post($api_url . '/consumer/login', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode() === 200) {
                $data = $response->getBody();
                $data = json_decode($data);
                $_token = $data->_token ?? null;
                session()->put('api_token', $_token);
                session()->save();

                $user = ConsumerService::get();
                session()->put('user', $user);
                session()->save();
            }
            return $data;
        } catch (\Exception $exception) {
            return response()->json(['message' => "Error login", 'error' => $exception->getMessage()], 422);
        }
    }

    public function register(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'sex' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $name = $first_name . ' ' . $last_name;
        $email = $request->email;
        $phone = $request->phone;
        $sex = $request->sex;
        $dob = $request->dob;
        $username = $request->username;
        $password = $request->password;

        $properties = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $sex,
            'dob' => $dob,
        ];

        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $password,
            'properties' => $properties,
        ];

        try {
            $response = $client->post($api_url . '/consumer/register', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode()) {
                $data = $response->getBody();
                $data = json_decode($data);
                $_token = $data->_token ?? null;
                $user = $data->user ?? null;
                // session()->put('api_token', $_token);
                // session()->put('user', $user);
                // session()->save();
                return $data;
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => "Error registration", 'error' => $exception->getMessage()], 422);
        }
    }

    public function logout(Request $request)
    {
        // we need to keep the shop/branch session active
        $branch = session('branch');

        // invalidate all session
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // restore branch session
        session()->put('branch', $branch);

        return redirect('/home');
    }
}
