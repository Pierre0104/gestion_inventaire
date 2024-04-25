<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index()
    {
        // Get orders with pagination
        $suppliers = Supplier::paginate(5); // Change 10 to however many items you want per page
    
        return response()->json($suppliers);
    }
    // Create a new Supplier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'contact_name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string'
        ]);

        $supplier = Supplier::create($validated);
        return response()->json($supplier);
    }

    // Retrieve a specific supplier
    public function show($id)
    {
        $supplier = Supplier::with('products')->findOrFail($id);
        return response()->json($supplier);
    }

    // Update an existing supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
            'contact_name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'address' => 'string'
        ]);

        $supplier->update($validated);
        return response()->json($supplier);
    }

    // Delete a supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return response()->json(['message' => 'Supplier deleted successfully.']);
    }
}
