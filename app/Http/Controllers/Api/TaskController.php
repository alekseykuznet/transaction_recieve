<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    use ApiResponse;

    public function recieve(Request $request)
    {
        if (Storage::disk('local')->exists(env('PRIVATE_FILENAME')) === false
            || Storage::disk('local')->exists(env('PUBLIC_FILENAME')) === false) {
            return $this->sendError('Key not found');
        }

        $clientId = $request->input('client_id') ?? null;
        $sum = $request->input('sum') ?? null;
        $commision = $request->input('commision') ?? null;
        $orderNumber = $request->input('orderNumber') ?? null;
        $signature = trim($request->getContent()) ?? null;

        $data = [
            'client_id' => $clientId,
            'sum' => $sum,
            'commision' => $commision,
            'orderNumber' => $orderNumber,
        ];

        $publicKey = Storage::disk('local')->get(env('PUBLIC_FILENAME'));
        $isVerify = openssl_verify(json_encode($data), $signature, $publicKey, "sha256WithRSAEncryption");

        if ($isVerify === 0) {
            return $this->sendError('Signature incorrect');
        }

        $result = Transaction::createTransaction($clientId, $sum, $commision, $orderNumber);

        return $this->sendResponse($result);
    }
}
