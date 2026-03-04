<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex items-center font-bold text-indigo-600 text-3xl tracking-tighter">
                <span class="bg-indigo-600 text-white px-2 py-0.5 rounded-lg mr-2 text-base">EC</span>
                EasyColoc
            </div>
        </x-slot>

        <h2 class="text-2xl font-black text-slate-800 mb-2">Bon retour !</h2>
        <p class="text-xs text-slate-400 font-medium mb-8 uppercase tracking-widest">Identifiez-vous pour continuer</p>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <x-label for="email" value="Adresse Email" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" />
                    <x-input id="email" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-xl" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div>
                    <x-label for="password" value="Mot de passe" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" />
                    <x-input id="password" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-xl" type="password" name="password" required autocomplete="current-password" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-xs text-slate-500 font-medium">Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 font-bold hover:underline" href="{{ route('password.request') }}">
                        Oublié ?
                    </a>
                @endif
            </div>

            <div class="mt-8">
                <button class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-indigo-600 transition shadow-lg">
                    Se connecter
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs text-slate-500">Pas encore de compte ? <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">S'inscrire</a></p>
        </div>
    </x-authentication-card>
</x-guest-layout>