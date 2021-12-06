<?php

namespace App\Http\Controllers\Api;

use App\Classes\Settings;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    use ApiResponse;

    public function receive(Request $request)
    {
        $clientId = $request->input('client_id', null);
        $sum = $request->input('sum', null);
        $commision = $request->input('commision', null);
        $orderNumber = $request->input('orderNumber', null);
        $signature = trim($request->getContent(), null);

        $data = [
            'client_id' => $clientId,
            'sum' => $sum,
            'commision' => $commision,
            'orderNumber' => $orderNumber,
        ];

        $publicKey = Settings::get();
        $isVerify = openssl_verify(json_encode($data), $signature, $publicKey, "sha256WithRSAEncryption");

        if ($isVerify === 0) {
            return $this->sendError('Signature incorrect');
        }

        $result = Transaction::createTransaction($clientId, $sum, $commision, $orderNumber);

        return $this->sendResponse($result);
    }
}
