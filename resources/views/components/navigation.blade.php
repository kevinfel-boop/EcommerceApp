<nav class="bg-white shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
          <div class="flex">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                  <a href="{{ route('home') }}">
                      <img class="h-8 w-auto" src="{{ asset('img/logo.png') }}" alt="Logo">
                  </a>
              </div>

              <!-- Navigation Links -->
              <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                  <a href="{{ route('home') }}" 
                     class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                      Accueil
                  </a>
                  <a href="{{ route('products.index') }}" 
                     class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                      Produit
                  </a>
                  <a href="{{ route('categories.index') }}" 
                     class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                      Catégories
                  </a>
                  <a href="{{ route('about') }}" 
                     class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                      À propos
                  </a>
              </div>
          </div>

          <!-- Right side of navbar -->
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
              <!-- Cart -->
              <a href="{{ route('cart.index') }}" class="p-2 rounded-full text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Panier</span>
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  @auth
                      @if($cartItemCount ?? 0 > 0)
                          <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                              {{ $cartItemCount }}
                          </span>
                      @endif
                  @endauth
              </a>

              <!-- User menu -->
              @auth
                  <div class="ml-3 relative">
                      <div>
                          <button type="button" 
                                  class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                                  id="user-menu-button">
                              <span class="sr-only">Open user menu</span>
                              <img class="h-8 w-8 rounded-full" 
                                   src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                   alt="">
                          </button>
                      </div>
                      <!-- Dropdown menu -->
                      <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" 
                           role="menu" id="user-menu">
                          <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                              Mon profil
                          </a>
                          <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                              Mes commandes
                          </a>
                          <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                              @csrf
                              <button type="submit">Déconnexion</button>
                          </form>
                      </div>
                  </div>
              @else
                  <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                      Connexion
                  </a>
                  <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                      Inscription
                  </a>
              @endauth
          </div>
      </div>
  </div>
</nav>

<script>
  // Gestion du menu utilisateur
  document.getElementById('user-menu-button').addEventListener('click', function() {
      const menu = document.getElementById('user-menu');
      menu.classList.toggle('hidden');
  });

  // Fermer le menu en cliquant à l'extérieur
  window.addEventListener('click', function(e) {
      const menu = document.getElementById('user-menu');
      const button = document.getElementById('user-menu-button');
      if (!button.contains(e.target) && !menu.contains(e.target)) {
          menu.classList.add('hidden');
      }
  });
</script>