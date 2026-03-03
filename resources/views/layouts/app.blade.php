<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- SIDEBAR (LIGHT MODE - COMPACT) -->
            <aside class="hidden md:flex flex-col w-60 bg-white border-r border-slate-200">
                <!-- Logo -->
                <div class="flex items-center font-bold text-indigo-600 text-xl m-8">
                    <span class="bg-indigo-600 text-white p-1 rounded-md mr-2">EC</span>
                    <span>EasyColoc</span>
                </div>

                <!-- Navigation -->
                <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto ml-4">
                <!-- Lien Dashboard -->
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" 
                    class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span></span> Dashboard
                </x-nav-link>

                <!-- Lien Colocations -->
                <x-nav-link href="{{ route('colocations.index') }}" :active="request()->routeIs('colocations.*')"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('colocations.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span></span> Colocations
                </x-nav-link>

                {{-- SECTION ADMIN : S'affiche uniquement pour l'admin global --}}
                @if(Auth::user()->role_type === 'admin')
                    <div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">Plateforme</div>
                    
                    <x-nav-link href="{{ route('admin.index') }}" :active="request()->routeIs('admin.*')"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span></span> Administration
                    </x-nav-link>
                @endif

                <div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">Compte</div>
                
                <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all">
                    <span></span> Mon Profil
                </a>
            </nav>

                <!-- Widget Réputation Compact -->
                <div class="p-3 m-3 bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Réputation</p>
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-bold text-slate-800">{{ Auth::user()->reputation_score }}</p>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 rounded">+ Points</span>
                    </div>
                </div>
            </aside>

            <!-- CONTENU -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                
                <!-- HEADER UNIQUE (JETSTREAM INTEGRATION) -->
                @livewire('navigation-menu')

                <!-- MAIN CONTENT AREA -->
                <main class="flex-1 overflow-y-auto p-5">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>