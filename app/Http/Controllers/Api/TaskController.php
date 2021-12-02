<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class TaskController extends Controller
{
    use ApiResponse;

    public function recieve(Request $request)
    {
        $clientId = $request->input('client_id') ?? null;
        $sum = $request->input('sum') ?? null;
        $commision = $request->input('commision') ?? null;
        $orderNumber = $request->input('order_number') ?? null;

        $result = Transaction::createTransaction($clientId, $sum, $commision, $orderNumber);

        return $this->sendResponse($result);
    }
}
