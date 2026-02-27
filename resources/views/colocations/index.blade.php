<x-app-layout>
    @section('title', 'Mes Colocations')

    <div class="space-y-6">

    <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Historique & Gestion</h2>
                <p class="text-xs text-slate-500">Retrouvez toutes vos expériences de colocation passées et présentes.</p>
            </div>
            
            {{-- Bouton "Créer" affiché uniquement si l'user n'a pas de coloc active --}}
            @if(!Auth::user()->currentColocation())
                <a href="{{ route('colocations.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    + Créer une colocation
                </a>
            @endif
        </div>

        <!-- Table des colocations -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nom</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rôle</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date d'arrivée</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Statut</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($colocations as $coloc)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-700">{{ $coloc->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($coloc->pivot->role === 'owner')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100 uppercase">
                                        Owner
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase">
                                        Membre
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($coloc->pivot->joined_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($coloc->status === 'active' && is_null($coloc->pivot->left_at))
                                    <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Actuelle
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-slate-400">Terminée</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('colocations.show', $coloc->id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                    Voir détails
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-2">🏘️</span>
                                    <p class="text-sm text-slate-400 italic">Vous n'avez pas encore d'historique de colocation.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>