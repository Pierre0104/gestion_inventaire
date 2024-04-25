<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function index()
{
    $orders = Order::with(['customer', 'products'])->paginate(10);
    return view('order', compact('orders')); // Assurez-vous que 'order' correspond au nom de votre vue Blade
}

    public function store(Request $request)
    {
        // Valide et crée une nouvelle commande
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'total_price' => 'required|numeric',
        ]);

        $order = Order::create($validatedData);

        return response()->json($order, 201);
    }

    public function show($id)
    {
        // Affiche une commande spécifique
        $order = Order::find($id);

        if ($order) {
            return response()->json($order);
        } else {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Met à jour une commande spécifique
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'total_price' => 'required|numeric',
        ]);

        $order->update($validatedData);

        return response()->json($order);
    }

    public function destroy($id)
    {
        // Supprime une commande spécifique
        $order = Order::find($id);

        if ($order) {
            $order->delete();
            return response()->json(['message' => 'Order deleted successfully']);
        } else {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }
}
