<x-app-layout>
    @section('title', 'Nouvelle dépense')

    <div class="max-w-2xl mx-auto py-8">
        <!-- En-tête de section -->
        <div class="mb-6 text-center">
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Enregistrer un achat</h2>
            <p class="text-xs text-slate-500 mt-1">Le montant sera automatiquement divisé entre tous les membres actifs.</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('expenses.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <!-- Champ Description -->
                <div>
                    <label for="description" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                        Description de l'achat
                    </label>
                    <input type="text" name="description" id="description" required autofocus
                        class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400"
                        placeholder="Ex: Courses hebdomadaires, Facture électricité...">
                    @error('description') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Ligne : Montant et Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="amount" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                            Montant (€)
                        </label>
                        <input type="number" step="0.01" name="amount" id="amount" required
                            class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="0.00">
                        @error('amount') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                            Date de l'achat
                        </label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required
                            class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('date') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Champ Catégorie -->
                <div>
                    <label for="category_id" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                        Catégorie
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-600">
                        <option value="" disabled selected>Choisir une catégorie...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Note de rappel (UX) -->
                <div class="bg-indigo-50 p-3 rounded-lg flex gap-3">
                    <span class="text-lg">💡</span>
                    <p class="text-[11px] text-indigo-700 leading-relaxed">
                        Chaque membre actif recevra une dette correspondant à sa part égale du montant total.
                    </p>
                </div>

                <!-- Actions du formulaire -->
                <div class="mt-8 flex items-center justify-between border-t border-slate-50 pt-6">
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition">
                        Annuler
                    </a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-xs font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase">
                        Enregistrer et répartir
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>