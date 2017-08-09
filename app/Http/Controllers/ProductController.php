<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Excel;
use Redirect;
use Yajra\Datatables\Datatables;
use PDF;

class ProductController extends Controller
{
    protected $message = [
        'product.required' => 'Nama Product Tidak Boleh Kosong',
        'category.required' => 'Kategory Harus Pilih',
        'price.required' => 'Isi Harga Product'
    ];

    protected $rule = [
        'product' => 'required',
        'category_id' => 'required',
        'price' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $base_url = url('/product');
        $category = Category::select('category', 'id')->get();
        return view('product.index', compact('base_url', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $category = Category::select('category', 'id')->get();
//        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rule, $this->message);

        Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $product = Product::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rule, $this->message);
        $product = Product::findOrFail($id);
        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Product::destroy($id)) return redirect()->back();
    }

    /**
     * @return api data for datatables
     */
    public function getProductData(){
        $products = Product::all();

        return Datatables::of($products)
            ->addColumn('category', function ($products) {
                return $products->category->category;
            })
            ->addColumn('action', function ($products) {

                return view('layouts.partials._action', [
                    'id' => $products->id,
                    'show' => 1,
                    'edit' => 1,
                    'delete' => 1,
                ]);
            })
            ->make(true);
    }

    /**
     * Generate PDF or Product List
     */
    public function makePDF(){
        $product = Product::join('categories', 'categories.id', '=', 'products.category_id')
            ->orderBy('products.id', 'desc')->get();

        $no = 0;
        $pdf = PDF::loadView('product.pdf', compact('product', 'no'));
        $pdf->setPaper('a4', 'Potrait');

        return $pdf->stream();
    }

    /**
     * Generate pdf for Product Barcode
     */
    public function makeBarcode(){
        $product = Product::limit(12)->get();
        $no = 1;
        $pdf = PDF::loadView('product.barcode', compact('product', 'no'));
        $pdf->setPaper('a4', 'Potrait');
        return $pdf->stream();
    }

    /**
     * Call Import Export Page Product
     */
    public function imexport(){
        return view('product.imexport');
    }

    public function importProduct(Request $request) {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){})->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $val) {
                    $product = new Product();
                    $product->category_id = $val->category_id;
                    $product->barcode = $val->barcode;
                    $product->product = $val->product;
                    $product->price = $val->price;
                    $product->save();
                }
            }
        }
        return back();
    }

    public function exportProduct(){
        $product = Product::select('category_id', 'barcode', 'product', 'price')->get();

        return Excel::create('listproduct', function($excel) use ($product){
           $excel->sheet('mysheet', function($sheet) use ($product){
              $sheet->fromArray($product);
           });
        })->download('xls');
    }

}
