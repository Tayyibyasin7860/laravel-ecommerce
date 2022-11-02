<?php

namespace App\Models;

use App\Notifications\InvoicePaid;
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

        static::created(function ($transaction){
            $transaction->order->customer->notify(new TransactionStatusUpdated($transaction));
        });
        Transaction::updated(function($transaction)
        {
            if ($transaction->status != $transaction->getRawOriginal('status')) {
                $transaction->order->customer->notify(new TransactionStatusUpdated($transaction));
            }
        });

    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
