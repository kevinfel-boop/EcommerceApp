<footer class="bg-gray-800 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- À propos -->
            <div>
                <h3 class="text-lg font-bold mb-4">Ma Boutique</h3>
                <p class="text-gray-300 text-sm">
                    Votre boutique en ligne préférée. Nous nous engageons à vous offrir les meilleurs produits avec un service client exceptionnel.
                </p>
            </div>

            <!-- Liens rapides -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition">Accueil</a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white transition">Boutique</a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-white transition">Panier</a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition">Mon compte</a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-300">
                    <li>Email : contact@maboutique.com</li>
                    <li>Téléphone : 01 23 45 67 89</li>
                    <li>Adresse : 123 Rue de Paris, 75000 Paris</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Ma Boutique. Tous droits réservés.</p>
        </div>
    </div>
</footer>