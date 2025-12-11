@extends('layouts.app')

@section('title', 'Paiement')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">💳 Paiement</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Formulaire de paiement -->
        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-6">Informations de paiement</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST" id="payment-form">
                    @csrf
                    
                    <!-- Informations de contact -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-4">Informations de contact</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" 
                                       class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="tel" name="phone" 
                                       class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Adresse de livraison -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-4">Adresse de livraison</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                    <input type="text" name="address[first_name]" 
                                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" name="address[last_name]" 
                                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                <input type="text" name="address[street]" 
                                       class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                    <input type="text" name="address[zip]" 
                                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                                    <input type="text" name="address[city]" 
                                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                                <select name="address[country]" 
                                        class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                    <option value="FR">France</option>
                                    <option value="BE">Belgique</option>
                                    <option value="CH">Suisse</option>
                                    <option value="LU">Luxembourg</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Méthode de paiement -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-4">Méthode de paiement</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="card" checked class="mr-2">
                                <span>Carte bancaire</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="paypal" class="mr-2">
                                <span>PayPal</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="transfer" class="mr-2">
                                <span>Virement bancaire</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Bouton de paiement -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition">
                        Payer {{ number_format($total, 2) }} €
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Récapitulatif de la commande -->
        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-6">Récapitulatif de la commande</h2>
                
                <!-- Articles -->
                <div class="mb-6">
                    <h3 class="font-semibold mb-4">Articles ({{ $cart->items->sum('quantity') }})</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3 pb-3 border-b">
                            <img src="{{ asset($item->product->image) }}" 
                                 alt="{{ $item->product->name }}"
                                 class="w-16 h-16 object-cover rounded">
                            <div class="flex-grow">
                                <p class="font-medium">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $item->quantity }} × {{ number_format($item->price, 2) }} €
                                </p>
                            </div>
                            <span class="font-bold">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Totaux -->
                <div class="space-y-3 border-t pt-4">
                    <div class="flex justify-between">
                        <span>Sous-total</span>
                        <span>{{ number_format($subtotal, 2) }} €</span>
                    </div>
                    <div class="flex justify-between">
                        <span>TVA (8.5%)</span>
                        <span>{{ number_format($tva, 2) }} €</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Livraison</span>
                        <span>
                            @if($shipping === 0)
                                Gratuite
                            @else
                                {{ number_format($shipping, 2) }} €
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-3">
                        <span>Total</span>
                        <span class="text-blue-600">{{ number_format($total, 2) }} €</span>
                    </div>
                </div>
                
                <!-- Retour au panier -->
                <div class="mt-6">
                    <a href="{{ route('cart.index') }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        ← Modifier mon panier
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection