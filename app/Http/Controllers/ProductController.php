<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // In your ProductController
public function index()
{
     // Fetch products with their supplier information
     $products = Product::with('supplier')->paginate(10); // Assuming pagination
     return response()->json($products);
}



    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'supplier_id' => 'required|exists:suppliers,id'
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
   // }

    /**
     * Display the specified resource.
     */
  public function show($id) // Enlever le typage "string" car les IDs sont généralement numériques
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($product);
}
    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
{
    // Dans une API, vous retourneriez simplement les données du produit à éditer, semblable à `show`.
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($product);
}
    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $this->validate($request, [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'supplier_id' => 'required|exists:suppliers,id'
    ]);

    $product->update($request->all());

    return response()->json($product);
}
    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $product->delete();

    return response()->json(['message' => 'Product deleted successfully']);
}

}
