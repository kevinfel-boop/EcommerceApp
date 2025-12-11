@if(!empty($links))
<nav aria-label="breadcrumb" class="mb-6">
    <ol class="flex flex-wrap items-center text-sm text-gray-500">
        <!-- Lien Accueil -->
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Accueil
            </a>
            <svg class="w-4 h-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </li>

        <!-- Liens dynamiques -->
        @foreach($links as $index => $link)
        @if($loop->last)
        <!-- Dernier lien (actif) -->
        <li class="inline-flex items-center">
            <span class="text-gray-900 font-semibold">{{ $link['label'] }}</span>
        </li>
        @else
        <!-- Lien normal -->
        <li class="inline-flex items-center">
            <a href="{{ $link['url'] }}" class="hover:text-blue-600 transition">
                {{ $link['label'] }}
            </a>
            <svg class="w-4 h-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </li>
        @endif
        @endforeach
    </ol>
</nav>
@endif