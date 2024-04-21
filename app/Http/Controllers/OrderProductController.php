<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function index()
    {
        $orderProducts = OrderProduct::all();
        return response()->json($orderProducts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $orderProduct = OrderProduct::create($validatedData);

        return response()->json($orderProduct, 201);
    }

  public function show($order_id, $product_id)
{
    // Trouver l'entrée dans la table pivot avec les deux IDs fournis
    $orderProduct = OrderProduct::where('order_id', $order_id)
                                ->where('product_id', $product_id)
                                ->first();

    if ($orderProduct) {
        return response()->json($orderProduct);
    } else {
        return response()->json(['message' => 'OrderProduct not found'], 404);
    }
}


   public function update(Request $request, $orderId, $productId)
{
    // Valider les données
    $validatedData = $request->validate([
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric',
    ]);

    // Trouver l'entrée dans la table pivot avec les deux IDs fournis
    $orderProduct = OrderProduct::where('order_id', $orderId)
                                ->where('product_id', $productId)
                                ->first();

    if (!$orderProduct) {
        return response()->json(['message' => 'OrderProduct not found'], 404);
    }

    // Mettre à jour l'entrée trouvée
    $orderProduct->fill($validatedData)->save();

    return response()->json($orderProduct);
}


    public function destroy($id)
    {
        $orderProduct = OrderProduct::find($id);
        if ($orderProduct) {
            $orderProduct->delete();
            return response()->json(['message' => 'OrderProduct deleted successfully']);
        } else {
            return response()->json(['message' => 'OrderProduct not found'], 404);
        }
    }
}
