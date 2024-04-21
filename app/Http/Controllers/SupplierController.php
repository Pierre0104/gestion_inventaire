<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function index()
    {
        try {
            $suppliers = Supplier::all();
            return response()->json($suppliers);
        } catch (\Exception $e) {
            Log::error('Error fetching suppliers: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to retrieve suppliers'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'contact_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:suppliers',
                'phone' => 'nullable|string',
                'address' => 'nullable|string'
            ]);

            $supplier = Supplier::create($validated);
            return response()->json($supplier, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating supplier: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create supplier'], 500);
        }
    }

    public function show(Supplier $supplier)
    {
        try {
            return response()->json($supplier);
        } catch (ModelNotFoundException $e) {
            Log::error('Error finding supplier: ' . $e->getMessage());
            return response()->json(['message' => 'Supplier not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error displaying supplier: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to display supplier'], 500);
        }
    }

    public function update(Request $request, Supplier $supplier)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'contact_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
                'phone' => 'nullable|string',
                'address' => 'nullable|string'
            ]);

            $supplier->update($validated);
            return response()->json($supplier);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating supplier: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update supplier'], 500);
        }
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return response()->json(['message' => 'Supplier deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting supplier: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete supplier'], 500);
        }
    }
}
