<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('order_number');
        CRUD::column('user_id')->type('select')
            ->model(User::class)->attribute('name')->entity('customer');
        CRUD::column('status');
        CRUD::column('payment_status');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrderRequest::class);

        CRUD::field('user_id')->type('select2_from_array')
            ->options(User::pluck("name","id")->toArray());


        Crud::addField([
            'name'=>'product_id',
            'type'=>'select2_from_array',
            'options'=> Product::where("status",1)->pluck("name","id")->toArray(),
            'allows_null'=>false,
            'allows_multiple'=>true,
        ]);

        CRUD::field('status')->type("enum");
        CRUD::field('payment_status')->type("enum");
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        $order = $this->crud->getCurrentEntry();

        $products = $order->products()->pluck("product_id")->toArray();

        Crud::addField([
            'name'=>'product_id',
            'type'=>'select2_from_array',
            'options'=> Product::where("status",1)->pluck("name","id")->toArray(),
            'allows_null'=>false,
            'allows_multiple'=>true,
            'default'=> Product::whereIn('id',$products)->pluck("id")->toArray()
        ])->afterField('user_id');
    }

    protected function setupShowOperation()
    {
        CRUD::column('order_number');
        CRUD::column('user_id')
            ->type('select')
            ->model(User::class)
            ->attribute('name')
            ->entity('customer');
        CRUD::column('grand_total');
        CRUD::column('status');
        CRUD::column('payment_status');

        $order = $this->crud->getCurrentEntry();

        $products = $order->products()
            ->get(["product_name","product_sku","product_description","product_price"])
            ->toArray();

        $count = 1;
        foreach($products as $product){
            CRUD::addColumn([
                'name' => "Product " . $count,
                'value' => " ",
                'type' => 'text'
            ]);
            CRUD::addColumn([
                'name' => 'Name',
                'value' => "Name: " . $product['product_name'],
                'type' => 'text'
            ]);
            CRUD::addColumn([
                'name' => 'SKU',
                'value' => "SKU: " . $product['product_sku'],
                'type' => 'text'
            ]);
            CRUD::addColumn([
                'name' => 'Description',
                'value' => "Description : " . $product['product_description'],
                'type' => 'text'
            ]);
            CRUD::addColumn([
                'name' => 'Price',
                'value' => "Price : " . $product['product_price'],
                'type' => 'text'
            ]);
            $count++;
        }

    }


}
