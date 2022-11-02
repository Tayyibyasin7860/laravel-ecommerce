<?php

namespace App\Models;

use App\Notifications\TransactionStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            do{
                $transaction_no = rand(1,999999);
                $exists = self::query()
                    ->where('transaction_no',$transaction_no)->exists();
            }
            while($exists);

            $transaction->transaction_no = $transaction_no;
        });

        static::saved(function ($transaction){
            $transaction->order->customer->notify(new TransactionStatusUpdated());
        });
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
