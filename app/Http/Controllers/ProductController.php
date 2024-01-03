<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $categoryId = request('categoryId');

        // $result = Category::where('id', request('categoryId'))->value('name');
        // dd($result);
        return view(
            './product/list/index',
            [
                'products' => Product::with('category')->filter(request(['search', 'categoryId']))->get(),
                'categories' => Category::all(),
                'categoryName' => Category::where('id', request('categoryId'))->value('name'),
                'active' => 'product'
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);
        // return $request->file('image');
        $validatedData = $request->validate(Product::$rules);

        // Calculate sell price based on buy price
        $validatedData['sellPrice'] = floatval(str_replace(',', '', $validatedData['sellPrice']));
        $validatedData['buyPrice'] = floatval(str_replace(',', '', $validatedData['buyPrice']));

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }

        // return $validatedData;
        Product::create($validatedData);

        return redirect('/product');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $result = Product::where('id', request('productId'))->value('id');
        // dd($result);
        Product::destroy($result);

        return redirect('/product')->with('success', 'Sukses menghapus produk');
    }
}
