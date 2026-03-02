<x-app-layout>
    @section('title', 'Détails Colocation')

    <div class="space-y-6">
        
        <!-- MESSAGES DE NOTIFICATION -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-xs font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs font-bold shadow-sm">
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
                <p class="text-xs text-slate-500 mt-1">Gérez les comptes de la maison en temps réel.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('expenses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    + Ajouter une dépense
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- COLONNE GAUCHE : DÉPENSES (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- RÉSUMÉ FINANCIER DYNAMIQUE -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white border border-slate-200 p-5 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total de la coloc</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">
                            {{ number_format($colocation->expenses->sum('amount'), 2) }} €
                        </p>
                    </div>
                    <div class="bg-white border border-slate-200 p-5 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mon solde actuel</p>
                        @php
                            $ceQueJeDois = \App\Models\Payment::where('colocation_id', $colocation->id)->where('debtor_id', Auth::id())->where('is_paid', false)->sum('amount');
                            $ceQuOnMeDois = \App\Models\Payment::where('colocation_id', $colocation->id)->where('creditor_id', Auth::id())->where('is_paid', false)->sum('amount');
                            $monSolde = $ceQuOnMeDois - $ceQueJeDois;
                        @endphp
                        <p class="text-2xl font-black mt-1 {{ $monSolde >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $monSolde >= 0 ? '+' : '' }}{{ number_format($monSolde, 2) }} €
                        </p>
                    </div>
                </div>

                <!-- TABLEAU DES DÉPENSES -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Historique des achats</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-tighter">
                                    <th class="px-5 py-3">Description</th>
                                    <th class="px-5 py-3">Payeur</th>
                                    <th class="px-5 py-3 text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($colocation->expenses->sortByDesc('date') as $expense)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4">
                                        <p class="font-bold text-slate-700">{{ $expense->description }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-medium">{{ $expense->category->name }} • {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600 font-medium">{{ $expense->payer->name }}</td>
                                    <td class="px-5 py-4 text-right font-black text-slate-800">{{ number_format($expense->amount, 2) }} €</td>
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

            <!-- COLONNE DROITE : MEMBRES & DETTES -->
            <div class="space-y-6">
                <!-- LISTE DES MEMBRES -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Membres</h3>
                    <div class="space-y-4">
                        @foreach($colocation->activeMembers as $member)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center text-xs font-bold border border-slate-200">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $member->name }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase font-black tracking-tighter">{{ $member->pivot->role }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                                    {{ $member->reputation_score }} pts
                                </span>

                                <!-- ACTIONS DE MEMBRES (RETIRER / QUITTER) -->
                                @if(Auth::user()->is_owner && $member->id !== Auth::id())
                                    {{-- L'Owner retire un membre --}}
                                    <form action="{{ route('membership.remove', $member->id) }}" method="POST" onsubmit="return confirm('Retirer ce membre ? Ses dettes vous seront transférées.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] font-bold text-rose-500 uppercase hover:underline">Retirer</button>
                                    </form>
                                @elseif($member->id === Auth::id() && !Auth::user()->is_owner)
                                    {{-- Le membre quitte de lui-même --}}
                                    <form action="{{ route('membership.leave') }}" method="POST" onsubmit="return confirm('Quitter la colocation ? Vos dettes seront transférées au propriétaire.')">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-bold text-rose-500 uppercase hover:underline">Quitter</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- INVITER UN MEMBRE -->
                    @if(Auth::user()->is_owner)
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <form action="{{ route('invitations.store') }}" method="POST" class="space-y-2">
                                @csrf
                                <input type="email" name="email" required class="w-full text-xs bg-slate-50 border-slate-200 rounded-lg" placeholder="Email de l'ami...">
                                <button type="submit" class="w-full py-2 bg-slate-900 text-white rounded-lg text-[10px] font-bold uppercase hover:bg-slate-800 transition">
                                    Envoyer une invitation
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- RÉSUMÉ DES DETTES -->
                <div class="bg-slate-900 rounded-xl p-5 shadow-xl text-white">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Règlements en attente</h3>
                    <div class="space-y-4">
                        @php
                            $pendingPayments = \App\Models\Payment::where('colocation_id', $colocation->id)->where('is_paid', false)->get();
                        @endphp

                        @forelse($pendingPayments as $payment)
                            <div class="flex flex-col gap-2 p-3 bg-white/5 rounded-lg border border-white/10">
                                <div class="text-[11px] leading-tight">
                                    <span class="font-bold {{ $payment->debtor_id == Auth::id() ? 'text-rose-400' : '' }}">
                                        {{ $payment->debtor_id == Auth::id() ? 'Toi' : $payment->debtor->name }}
                                    </span> 
                                    doit 
                                    <span class="font-bold text-white">{{ number_format($payment->amount, 2) }} €</span> 
                                    à 
                                    <span class="font-bold {{ $payment->creditor_id == Auth::id() ? 'text-emerald-400' : '' }}">
                                        {{ $payment->creditor_id == Auth::id() ? 'Toi' : $payment->creditor->name }}
                                    </span>
                                </div>

                                @if($payment->debtor_id == Auth::id())
                                    <form action="{{ route('payments.markAsPaid', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded text-[9px] font-bold uppercase transition">
                                            Confirmer le paiement
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-500 italic">Tout est à jour, aucune dette en cours !</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>