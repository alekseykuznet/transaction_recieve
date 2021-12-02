<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @package App\Models
 * @property int $id
 * @property int client_id
 * @property double $balance
 * @property string $created_at
 * @property string $updated_at
 */
class UserWallet extends Model
{
    use HasFactory;

    protected $table = 'user_wallet';

    protected $dates = [
        'create_at',
        'updated_at',
    ];

    protected $fillable = [
        'client_id',
        'balance',
    ];

    /**
     * @return mixed
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
