<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 10)->create();

       $product = App\Product::all();
       foreach ($product as $data){
           $update = App\Product::find($data->id);
           $update->barcode = rand(10000000, 99999999);
           $update->update();
       }
    }
}
