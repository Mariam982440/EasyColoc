<x-app-layout>
    <!-- GRID DE STATS COMPACT -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        
        <!-- Carte Réputation -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Réputation globale</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ Auth::user()->reputation_score }} <span class="text-xs text-slate-400 font-normal">points</span></h3>
        </div>

        <!-- Carte Coloc Active -->
        <div class="md:col-span-2 bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex justify-between items-center">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Colocation Active</p>
                @if($colocation)
                    <h3 class="text-xl font-bold text-indigo-600 mt-1">{{ $colocation->name }}</h3>
                @else
                    <h3 class="text-lg font-medium text-slate-300 mt-1 italic">Aucune colocation active</h3>
                @endif
            </div>
            
            @if(!$colocation)
                <a href="{{ route('colocations.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                    + Créer
                </a>
            @else
                <a href="{{ route('colocations.show', $colocation->id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Gérer →</a>
            @endif
        </div>
    </div>

    <!-- SECTION BAS : DEUX COLONNES -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Liste Dépenses -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-5">
            <div class="flex justify-between items-center mb-4 border-b border-slate-50 pb-3">
                <h4 class="text-sm font-bold uppercase tracking-tight text-slate-700">Dépenses récentes</h4>
                <button class="text-indigo-600 text-[11px] font-bold hover:underline">Voir tout</button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="text-slate-400 font-medium uppercase tracking-wider">
                        <tr>
                            <th class="pb-2">Titre</th>
                            <th class="pb-2">Payeur</th>
                            <th class="pb-2 text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td colspan="3" class="py-6 text-center text-slate-400 italic">Aucune donnée récente.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Widget Membres (Side Widget) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
            <h4 class="text-sm font-bold mb-4 text-slate-700 border-b border-slate-50 pb-3 uppercase tracking-tight">Membres</h4>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-100 text-indigo-700 rounded-lg flex items-center justify-center text-xs font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->is_owner ? 'Propriétaire' : 'Membre' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>