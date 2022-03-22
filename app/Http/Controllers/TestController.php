<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Rules\Luna;

class TestController extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pan' => ['required', 'numeric', 'digits_between:16,16', new Luna],
            'cvc' => 'required|numeric|digits_between:3,3',
            'cardholder' => 'required|string',
            'expire' => 'required|date_format:m/y',
        ]);

        if ($validator->fails()) {
            Log::channel('validateAPI')->info($validator->getMessageBag());
            $json = [
                'code' => 422,
                'error' => $validator->getMessageBag(),
            ];
            return response()->json($json, 422);
        }

        $apiData = $validator->validated();

        $publicKey  = $this->getPublicKey();

        $apiData['tokenExpire'] = $this->setTtl();

        $base64Token = $this->customEncode($apiData, $publicKey);

        $response = [
            'pan' => $this->cutNumCard($apiData['pan']),
            'token' => $this->cutToken($base64Token),
        ];
        Log::channel('tokenAPI')->info($base64Token);
        return response()->json($response, 201);
    }

    public function cutNumCard($num)
    {
        $first4 = substr($num, 0, 4);
        $last4 = substr($num, -4);
        return "{$first4}*****{$last4}";
    }

    public function cutToken($str)
    {
        $first4 = substr($str, 0, 10);
        $last4 = substr($str, -10);
        return "{$first4}*****{$last4}";
    }

    public function getPublicKey()
    {
        $contentsPublicKey = file_get_contents(__DIR__ .'/../../../docker/ssh/public.crt');
        return openssl_get_publickey($contentsPublicKey);
    }

    public function setTtl()
    {
        $ttl = env('TTL_TOKEN');
        $now = Carbon::now()->timestamp;
        return $now + $ttl;
    }

    public function customEncode($apiData, $publicKey)
    {
        $codeString = json_encode($apiData);
        openssl_public_encrypt($codeString, $encrypted, $publicKey);
        return base64_encode($encrypted);
    }
}
