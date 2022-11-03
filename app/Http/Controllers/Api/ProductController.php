<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\ProductResource;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    public function show($id)
    {
        try {
        $product = Product::findOrFail($id);
        }
        catch (Exception $exception){
            if ($exception instanceof ModelNotFoundException){
                return $this->sendError('Product not found.');
            }
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

}
