<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDelivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Show deliveries list
     */
    public function index()
    {
        $deliveries = Delivery::all();
        return view('admin.deliveries.index', compact('deliveries'));
    }

    /**
     * Show form to create delivery
     */
    public function create()
    {
        return view('admin.deliveries.create');
    }

    /**
     * Store delivery
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:deliveries',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'vehicle_type' => 'nullable|in:bike,car,truck',
            'vehicle_number' => 'nullable|string|max:50',
        ]);

        Delivery::create($validated);

        return redirect()->route('admin.deliveries.index')
                       ->with('success', 'Livreur ajouté avec succès');
    }

    /**
     * Show form to edit delivery
     */
    public function edit(Delivery $delivery)
    {
        return view('admin.deliveries.edit', compact('delivery'));
    }

    /**
     * Update delivery
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:deliveries,email,' . $delivery->idDelivery . ',idDelivery',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'vehicle_type' => 'nullable|in:bike,car,truck',
            'vehicle_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,on_delivery',
        ]);

        $delivery->update($validated);

        return redirect()->route('admin.deliveries.index')
                       ->with('success', 'Livreur mis à jour avec succès');
    }

    /**
     * Delete delivery
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return redirect()->route('admin.deliveries.index')
                       ->with('success', 'Livreur supprimé avec succès');
    }

    /**
     * Assign order to delivery
     */
    public function assignOrder(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,idOrder',
            'delivery_id' => 'required|exists:deliveries,idDelivery',
        ]);

        try {
            // Check if order is already assigned
            $existing = OrderDelivery::where('order_id', $validated['order_id'])->first();
            if ($existing) {
                return back()->with('error', 'Cette commande est déjà assignée à un livreur');
            }

            OrderDelivery::create([
                'order_id' => $validated['order_id'],
                'delivery_id' => $validated['delivery_id'],
                'assigned_at' => now(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Prevent 500 if the table isn't created yet.
            if (str_contains($e->getMessage(), 'order_deliveries')) {
                return back()->with('error', 'Impossible d’assigner : la table order_deliveries est manquante. Veuillez exécuter: php artisan migrate');
            }

            throw $e;
        }

        // Update order status to processing
        Order::find($validated['order_id'])->update(['status' => 'processing']);

        return back()->with('success', 'Commande assignée au livreur');
    }

    /**
     * Update delivery status for an order
     */
    public function updateDeliveryStatus(Request $request, OrderDelivery $orderDelivery)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,picked_up,in_transit,delivered,failed',
        ]);

        $orderDelivery->update([
            'status' => $validated['status'],
        ]);

        // Update corresponding timestamp
        switch ($validated['status']) {
            case 'picked_up':
                $orderDelivery->update(['picked_up_at' => now()]);
                break;
            case 'delivered':
                $orderDelivery->update(['delivered_at' => now()]);
                // Update order status to delivered
                Order::find($orderDelivery->order_id)->update(['status' => 'delivered']);
                // Increment delivery person's completed orders
                Delivery::find($orderDelivery->delivery_id)->increment('orders_completed');
                break;
            case 'failed':
                // Revert order status to processing for reassignment
                Order::find($orderDelivery->order_id)->update(['status' => 'processing']);
                break;
        }

        return back()->with('success', 'Statut de livraison mis à jour');
    }
}
