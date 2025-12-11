@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
    <!-- Hero Section -->
    <div class="flex flex-col md:flex-row items-center mb-16">
        <!-- Texte principal et bouton -->
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold heading-font text-third mb-6">
                Discover Your Next Favorite Book
            </h1>
            <p class="text-xl text-third mb-8 opacity-90">
                Kodama brings you a carefully curated collection of books for every reader. Find your next adventure in our
                forest of stories.
            </p>
            <div class="flex space-x-4">
                <a href="{{ route('products.index') }}">
                    <button class="btn-primary px-6 py-3 rounded-md font-medium transition-colors">
                        Browse Collection
                    </button>
                </a>
            </div>
        </div>

        <!-- Visuel Hero -->
        <div class="md:w-1/2 flex justify-center">
            <div class="relative">
                <div class="w-64 h-80 third-color rounded-lg shadow-xl transform rotate-3"></div>
                <div class="w-64 h-80 bg-white border-2 border-primary rounded-lg shadow-xl absolute top-4 left-4 transform -rotate-2 flex items-center justify-center">
                    <div class="text-center p-6">
                        <img class="w-20 justify-self-center" src="{{ asset('img/logo.png') }}" alt="logo">
                        <p class="text-primary mt-2">Where stories grow</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panier -->
    <div class="mb-16">
        <h1 class="text-3xl font-bold mb-8">🛒 Mon Panier</h1>

        @if($cartItems->isEmpty())
            <!-- Panier vide -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-gray-500 text-lg mb-6">Votre panier est vide</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Continuer mes achats
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Liste des articles -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex gap-6">
                                <!-- Image du produit -->
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($item->product->image) }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-24 h-24 object-cover rounded-lg">
                                </div>

                                <!-- Détails du produit -->
                                <div class="flex-grow">
                                    <!-- Nom et catégorie -->
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <a href="{{ route('products.show', $item->product->slug) }}" 
                                               class="text-lg font-semibold hover:text-blue-600 transition">
                                                {{ $item->product->name }}
                                            </a>
                                            <p class="text-sm text-gray-500">
                                                SKU: {{ $item->product->sku }}
                                            </p>
                                        </div>
                                        
                                        <!-- Bouton supprimer -->
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition"
                                                    onclick="return confirm('Supprimer cet article ?')">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Prix et quantité -->
                                    <div class="flex justify-between items-center mt-4">
                                        <!-- Prix unitaire -->
                                        <div>
                                            <span class="text-lg font-bold text-gray-900">
                                                {{ number_format($item->price, 2) }} €
                                            </span>
                                        </div>

                                        <!-- Contrôles de quantité -->
                                        <div class="flex items-center gap-3">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <label class="text-sm font-semibold text-gray-700">Quantité :</label>
                                                
                                                <select name="quantity" 
                                                        onchange="this.form.submit()"
                                                        class="border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                    @for($i = 1; $i <= min(99, $item->product->stock_quantity); $i++)
                                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </form>

                                            <!-- Sous-total de l'item -->
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Sous-total</p>
                                                <p class="text-lg font-bold text-gray-900">
                                                    {{ number_format($item->price * $item->quantity, 2) }} €
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Bouton vider le panier -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('products.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold">
                            ← Continuer mes achats
                        </a>

                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800 font-semibold"
                                    onclick="return confirm('Vider complètement le panier ?')">
                                Vider le panier
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Récapitulatif de la commande -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                        <h2 class="text-xl font-bold mb-6">Récapitulatif</h2>

                        <!-- Lignes de détail -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-700">
                                <span>Sous-total ({{ $totalItems }} articles)</span>
                                <span class="font-semibold">{{ number_format($subtotal, 2) }} €</span>
                            </div>

                            @php
                                $tva = $subtotal * 0.085; // 8.5% TVA
                                $shipping = $subtotal > 50 ? 0 : 5.99;
                                $total = $subtotal + $tva + $shipping;
                            @endphp

                            <div class="flex justify-between text-gray-700">
                                <span>TVA (8.5%)</span>
                                <span class="font-semibold">{{ number_format($tva, 2) }} €</span>
                            </div>

                            <div class="flex justify-between text-gray-700">
                                <span>Livraison</span>
                                <span class="font-semibold">
                                    @if($shipping === 0)
                                        Gratuite
                                    @else
                                        {{ number_format($shipping, 2) }} €
                                    @endif
                                </span>
                            </div>

                            @if($shipping === 0)
                                <p class="text-sm text-green-600">
                                    ✅ Livraison gratuite !
                                </p>
                            @else
                                <p class="text-sm text-gray-500">
                                    💡 Plus que {{ number_format(50 - $subtotal, 2) }} € pour la livraison gratuite
                                </p>
                            @endif
                        </div>

                        <!-- Total -->
                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold">Total</span>
                                <span class="text-2xl font-bold text-blue-600">{{ number_format($total, 2) }} €</span>
                            </div>
                        </div>

                        <!-- Bouton commander -->
                        <a href="{{ route('checkout.index') }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg text-center transition shadow-lg hover:shadow-xl">
                            Passer la commande
                        </a>

                        <!-- Paiements acceptés -->
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-xs text-gray-500 text-center mb-2">Paiements sécurisés</p>
                            <div class="flex justify-center gap-2">
                                <span class="text-2xl">💳</span>
                                <span class="text-2xl">🏦</span>
                                <span class="text-2xl">📱</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Categories Section -->
    @if(isset($categories) && $categories->count() > 0)
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold heading-font text-third text-center mb-4">Categories</h2>
                <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto">
                    Explore our diverse collection organized by genre
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}">
                            <div class="bg-gray-100 p-6 rounded-lg text-center hover:bg-blue-50 transition-colors cursor-pointer">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 mx-auto mb-3">
                                @else
                                    <div class="text-3xl mb-3">📚</div>
                                @endif
                                <h3 class="font-bold">{{ $category->name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection