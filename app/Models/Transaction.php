<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

/**
 * @package App\Models
 * @property int $id
 * @property int $client_id
 * @property double $sum
 * @property double $commision
 * @property string $order_number
 * @property int $send
 * @property string $created_at
 * @property string $updated_at
 */
class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $dates = [
        'create_at',
        'updated_at',
    ];

    protected $fillable = [
        'client_id',
        'sum',
        'commision',
        'order_number',
        'send'
    ];

    public const SEND_NO = 0;
    public const SEND_YES = 1;

    public const ORDER_NUMBER_PREFIX = 'TS';
    public const ORDER_NUMBER_START_NUMBER = 1;
    public const ORDER_NUMBER_LENGTH = 5;

    /**
     * @return mixed
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function createTransaction($clientId, $sum, $commision, $orderNumber): bool
    {
        $transaction = new Transaction();

        $transaction->client_id = $clientId;
        $transaction->sum = $sum + ($sum * $commision / 100);
        $transaction->commision = $commision;
        $transaction->order_number = $orderNumber;

        if ($transaction->save() === null) {
            return false;
        }

        $userWallet = UserWallet::where('client_id', $transaction->client_id)
            ->first();

        if ($userWallet === null) {
            $userWallet = new UserWallet();
            $userWallet->client_id = $transaction->client_id;
        }

        $userWallet->balance += $transaction->sum;

        return $userWallet->save();
    }
}
