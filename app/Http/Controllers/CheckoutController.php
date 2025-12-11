<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Affiche la page de checkout
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Calcul des totaux
        $subtotal = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $tva = $subtotal * 0.085;
        $shipping = $subtotal > 50 ? 0 : 5.99;
        $total = $subtotal + $tva + $shipping;

        return view('checkout.index', compact('cart', 'subtotal', 'tva', 'shipping', 'total'));
    }

    /**
     * Traite le paiement
     */
    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Ici, vous intégrerez votre passerelle de paiement (Stripe, PayPal, etc.)
        // Pour l'instant, on simule un paiement réussi

        // Créer la commande
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'status' => 'pending',
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'shipping' => $request->shipping,
            'total' => $request->total,
            'payment_method' => $request->payment_method ?? 'card',
            'shipping_address' => json_encode($request->address),
        ]);

        // Copier les items du panier vers la commande
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'name' => $item->product->name,
            ]);
        }

        // Vider le panier
        $cart->items()->delete();

        return redirect()->route('checkout.success', $order);
    }

    /**
     * Page de succès
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Page d'annulation
     */
    public function cancel()
    {
        return view('checkout.cancel')->with('error', 'Le paiement a été annulé.');
    }
}
