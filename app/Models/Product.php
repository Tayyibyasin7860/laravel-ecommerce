<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];


    protected static function booted()
    {
        static::creating(function ($product) {
            do{
                $sku = rand(1,999999);
                $exists = self::query()
                    ->where('sku',$sku)->exists();
            }
            while($exists);

            $product->sku = $sku;
        });
    }
}
