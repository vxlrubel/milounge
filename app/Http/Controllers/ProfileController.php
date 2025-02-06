<?php

namespace App\Http\Controllers;

use App\Services\ConsumerService;
use App\Services\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string'
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;

        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone
        ];

        try {
            $response = $client->post($api_url . '/user/update', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode()) {
                $data = $response->getBody();
                $data = json_decode($data);
                $user = $data->user ?? null;
                session()->put('user', $user);
                session()->save();
                return back()->with('success', 'Profile updated successfully!');
            }

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $exception) {
            return back()->with('error', 'Profile is not updated!');
        }

    }

    public function updateProfilePicture(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:png,jpg,jpeg,gif,webp,svg',
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $file = $request->file('file');

        $api_url = config('api.apiUrl');
        $client = Utils::clientFile();

        try {
            $response = $client->post($api_url . '/user/update/profile-image', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($file),
                        'filename' => $file->getClientOriginalName()
                    ]
                ],
            ]);

            if ($response->getStatusCode()) {

                $user = ConsumerService::get();
                session()->put('user', $user);
                session()->save();

                return back()->with('success', 'Profile updated successfully!');
            }

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $exception) {
            return back()->with('error', 'Profile is not updated!');
        }

    }
}
