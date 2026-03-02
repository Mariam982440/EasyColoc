<x-app-layout>
    @section('title', 'Détails Colocation')

    <div class="space-y-6">
        
        <!-- MESSAGES DE NOTIFICATION (Succès / Erreur) -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-bold">
                {{ session('error') }}
            </div>
        @endif

        <!-- HEADER DE LA COLOC -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-6">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $colocation->name }}</h1>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase">
                        {{ $colocation->status }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Gérez vos dépenses et invitez de nouveaux membres.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    + Ajouter une dépense
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- COLONNE GAUCHE : LISTE DES DÉPENSES (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Résumé financier rapide -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white border border-slate-200 p-4 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total dépensé</p>
                        <p class="text-xl font-bold text-slate-800 mt-1">1 240,50 €</p>
                    </div>
                    <div class="bg-white border border-slate-200 p-4 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ma part à payer</p>
                        <p class="text-xl font-bold text-indigo-600 mt-1">413,50 €</p>
                    </div>
                </div>

                <!-- Tableau des dépenses -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Historique des achats</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-tighter">
                                    <th class="px-5 py-3">Description / Catégorie</th>
                                    <th class="px-5 py-3">Payeur</th>
                                    <th class="px-5 py-3 text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($colocation->expenses as $expense)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-5 py-4">
                                        <p class="font-bold text-slate-700">{{ $expense->description }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase">{{ $expense->category->name }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">{{ $expense->payer->name }}</td>
                                    <td class="px-5 py-4 text-right font-bold text-slate-800">{{ number_format($expense->amount, 2) }} €</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-12 text-center text-slate-400 italic">Aucune dépense enregistrée.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : MEMBRES & INVITATIONS -->
            <div class="space-y-6">
                
                <!-- Liste des membres -->
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Membres de la coloc</h3>
                    <div class="space-y-4">
                        @foreach($colocation->activeMembers as $member)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 bg-slate-100 text-slate-600 rounded flex items-center justify-center text-[10px] font-bold border border-slate-200">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $member->name }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase font-medium">{{ $member->pivot->role }}</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                                {{ $member->reputation_score }} pts
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <!-- FORMULAIRE D'INVITATION (Appel de store) -->
                    @if(Auth::user()->is_owner)
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Inviter un ami</h4>
                            <form action="{{ route('invitations.store') }}" method="POST" class="space-y-2">
                                @csrf
                                <input type="email" name="email" required
                                    class="w-full text-xs bg-slate-50 border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                                    placeholder="adresse@email.com">
                                <button type="submit" class="w-full py-2 bg-slate-800 text-white rounded-lg text-[10px] font-bold uppercase hover:bg-slate-700 transition">
                                    Envoyer le lien
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Résumé des dettes -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest mb-4">Résumé des dettes</h3>
                    <div class="space-y-3">
                        <div class="text-[11px] leading-relaxed text-slate-600 italic">
                            Les comptes seront mis à jour après l'ajout des premières dépenses.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>