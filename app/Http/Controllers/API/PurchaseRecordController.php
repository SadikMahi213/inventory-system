<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRecord;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $purchaseRecords = PurchaseRecord::with(['product', 'supplier'])->latest()->paginate(10);
        return response()->json($purchaseRecords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total price
        $totalPrice = $request->quantity * $request->unit_price;

        $purchaseRecord = PurchaseRecord::create([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'model' => $product->model,
            'size' => $product->size,
            'color' => $product->color,
            'quality' => $product->quality,
            'quantity' => $request->quantity,
            'unit' => $product->unit,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice,
            'supplier_id' => $request->supplier_id,
            'payment_status' => $request->payment_status,
        ]);

        return response()->json($purchaseRecord, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseRecord $purchaseRecord): JsonResponse
    {
        return response()->json($purchaseRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseRecord $purchaseRecord): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total price
        $totalPrice = $request->quantity * $request->unit_price;

        $purchaseRecord->update([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'model' => $product->model,
            'size' => $product->size,
            'color' => $product->color,
            'quality' => $product->quality,
            'quantity' => $request->quantity,
            'unit' => $product->unit,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice,
            'supplier_id' => $request->supplier_id,
            'payment_status' => $request->payment_status,
        ]);

        return response()->json($purchaseRecord);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseRecord $purchaseRecord): JsonResponse
    {
        $purchaseRecord->delete();

        return response()->json(null, 204);
    }
}
