<x-app-layout>
    @section('title', 'Nouvelle Colocation')

    <div class="max-w-xl mx-auto py-8">
        <!-- En-tête de page -->
        <div class="mb-6 text-center">
            <h2 class="text-xl font-bold text-slate-800">Commencer une nouvelle aventure</h2>
            <p class="text-xs text-slate-500 mt-1">Donnez un nom à votre groupe pour commencer à partager vos frais.</p>
        </div>

        <!-- Carte Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('colocations.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-4">
                    <!-- Champ Nom -->
                    <div>
                        <label for="name" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                            Nom de la colocation
                        </label>
                        <input type="text" name="name" id="name" required
                            class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400"
                            placeholder="Ex: Villa du Bonheur, Appart 4B...">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Note informative -->
                    <div class="bg-indigo-50 p-3 rounded-lg flex gap-3">
                        <span class="text-lg">💡</span>
                        <p class="text-[11px] text-indigo-700 leading-relaxed">
                            En créant cette colocation, vous en deviendrez le <strong>Propriétaire (Owner)</strong>. 
                            Vous pourrez ensuite inviter vos amis par email.
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-between border-t border-slate-50 pt-6">
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition">
                        Annuler
                    </a>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">
                        Créer la colocation
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>