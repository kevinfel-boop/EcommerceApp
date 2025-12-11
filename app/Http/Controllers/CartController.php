<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Affiche le panier
     */


    // ...

    public function index()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();

        // Récupérer les catégories (par exemple, toutes les catégories actives)
        $categories = Category::where('is_active', true)->get();

        // Calcul des totaux
        $subtotal = 0;
        $totalItems = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
            $totalItems += $item->quantity;
        }

        return view('cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
            'cart' => $cart,
            'categories' => $categories // Ajout des catégories
        ]);
    }

    /**
     * AJOUTE un produit au panier
     * C'EST LA MÉTHODE MANQUANTE !
     */
    public function add(Request $request, $productId)
    {
        // Valider que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour ajouter des articles au panier.');
        }

        $product = Product::findOrFail($productId);

        // Vérifier le stock
        if ($product->stock_quantity < 1) {
            return redirect()->back()->with('error', 'Ce produit est en rupture de stock.');
        }

        $user = Auth::user();

        // Récupérer ou créer le panier
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['user_id' => $user->id]
        );

        // Vérifier si le produit est déjà dans le panier
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Incrémenter la quantité
            $cartItem->increment('quantity');
            $message = 'Quantité mise à jour dans votre panier.';
        } else {
            // Ajouter un nouvel item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->sale_price ?? $product->price,
            ]);
            $message = 'Produit ajouté à votre panier.';
        }

        // Décrémenter le stock
        if ($product->stock_quantity > 0) {
            $product->decrement('stock_quantity');
        }

        return redirect()->route('cart.index')
            ->with('success', $message);
    }

    /**
     * Met à jour la quantité d'un produit
     */
    public function update(Request $request, $cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $quantity = $request->input('quantity', 1);

        // Valider la quantité
        if ($quantity < 1) {
            return redirect()->back()->with('error', 'La quantité doit être au moins de 1.');
        }

        // Vérifier le stock disponible
        $stockAvailable = $cartItem->product->stock_quantity + $cartItem->quantity;
        if ($quantity > $stockAvailable) {
            return redirect()->back()->with('error', 'Stock insuffisant. Maximum disponible : ' . $stockAvailable);
        }

        // Ajuster le stock
        $stockDifference = $quantity - $cartItem->quantity;
        if ($stockDifference != 0) {
            $cartItem->product->decrement('stock_quantity', $stockDifference);
        }

        // Mettre à jour la quantité
        $cartItem->update(['quantity' => $quantity]);

        return redirect()->back()->with('success', 'Quantité mise à jour.');
    }

    /**
     * Supprime un article du panier
     */
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        // Remettre le stock
        $cartItem->product->increment('stock_quantity', $cartItem->quantity);

        // Supprimer l'item
        $cartItem->delete();

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vide complètement le panier
     */
    public function clear()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            // Remettre tous les produits en stock
            $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();

            foreach ($cartItems as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            // Supprimer tous les items
            CartItem::where('cart_id', $cart->id)->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }
}
