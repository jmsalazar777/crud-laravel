<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::paginate(10);
        $paginator = $products;

        return view('welcome', compact(['products', 'paginator']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crud.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'ProductName' => 'required|unique:products',
            'ProductPrice' => 'required',
            'ProductDescription' => 'nullable|string',
            'ProductQuantity' => 'nullable|numeric',
            // 'ProductImage' => 'nullable|url',
            'ProductSlug' => 'nullable|string',
        ]);

        $create = Products::create($validate);

        if($create) {
            return redirect(route('products'))->width('success', 'Product Created!');
        }else {
            return back()->with('error', 'Product Not Created!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::findOrFail($id);
        return view('crud.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('crud.edit', compact('product'));
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
        $product = Products::findOrFail($id);

        $product->ProductName = $request->ProductName;
        $product->ProductPrice = $request->ProductPrice;
        $product->ProductDescription = $request->ProductDescription;
        $product->ProductQuantity = $request->ProductQuantity;
        $product->ProductSlug = $request->ProductSlug;
        $product->save();
        return redirect(route('welcome'))->with('success', 'Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::findOrFail($id)->delete();
        return back();
    }
}
