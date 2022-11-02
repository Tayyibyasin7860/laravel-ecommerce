<?php

namespace App\Models;

use App\Notifications\OrderPlaced;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    public function products(){
        return $this->hasMany(OrderProduct::class);
    }

    public function customer(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    protected static function booted()
    {
        static::creating(function ($order) {
            do{
                $order_number = rand(1,999999);
                $exists = self::query()
                    ->where('order_number',$order_number)->exists();
            }
            while($exists);

            $order->order_number = $order_number;
        });
        static::created(function ($order){
            $order->customer->notify(new OrderPlaced());
        });
        static::saved(function ($order){
            $order->products()->delete();
            $order->grand_total = self::addOrderDetails($order);

            $order->saveQuietly();
        });
    }

    private static function addOrderDetails($order){

        $products = Product::find(request()->product_id);

        $order_amount = 0;

        foreach ($products as $product){

            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'product_description' => $product->description,
                'product_price' => $product->price,
            ]);

            $order_amount += $product->price;

        }

        return $order_amount;
    }
}
