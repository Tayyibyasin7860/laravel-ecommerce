<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Api\BaseController as BaseController;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    public function index()
    {
        $user = auth('sanctum')->user();

        $orders = Order::where('user_id',$user->id)->get();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully.');
    }

    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);

        }
        catch (Exception $exception){
            if ($exception instanceof ModelNotFoundException){

                return $this->sendError('Order not found.');
            }
        }
        $user = auth('sanctum')->user();

        if (!($order->user_id == $user->id)){
            return $this->sendError('You dont have permission to view this order.');
        }

        return $this->sendResponse(new OrderResource($order), 'Order retrieved successfully.');
    }

    public function destroy($order)
    {
        try {
            $order = Order::findOrFail($order);
        }
        catch (Exception $exception){
            if ($exception instanceof ModelNotFoundException){

                return $this->sendError('Order not found.');
            }
        }
        $user = auth('sanctum')->user();

        if ($order->user_id == $user->id){
            $order->delete();
            return $this->sendResponse([], 'Order deleted successfully.');

        }
        else{
            return $this->sendError('You dont have permission to delete this order.');
        }

    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'product_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = auth('sanctum')->user();

        $order = Order::create([
            'user_id' => $user->id,
            'status' => $input['status'],
            'payment_status' => $input['payment_status'],
        ]);

        return $this->sendResponse(new OrderResource($order), 'Order created successfully.');
    }
}
