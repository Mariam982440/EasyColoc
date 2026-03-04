<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc - Gérez vos comptes entre colocs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-900">
    
    <!-- Navigation -->
    <nav class="flex items-center justify-between px-10 py-6">
        <div class="flex items-center font-bold text-indigo-600 text-2xl tracking-tighter">
            <span class="bg-indigo-600 text-white px-2 py-0.5 rounded-lg mr-2 text-sm">EC</span>
            EasyColoc
        </div>
        <div class="space-x-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Créer un compte</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="max-w-4xl mx-auto text-center mt-20 px-6">
        <h1 class="text-5xl md:text-6xl font-black text-slate-900 leading-tight tracking-tighter">
            La fin des tensions sur <br> <span class="text-indigo-600 italic">les dépenses communes.</span>
        </h1>
        <p class="mt-6 text-lg text-slate-500 leading-relaxed max-w-2xl mx-auto">
            Gérez vos factures, suivez les remboursements et maintenez une réputation exemplaire au sein de votre colocation.
        </p>
        <div class="mt-10">
            <a href="{{ route('register') }}" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-indigo-600 transition-all shadow-2xl shadow-slate-200">
                Créer ma première coloc →
            </a>
        </div>
    </header>

    <!-- Features simples -->
    <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-10 mt-32 mb-20">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="text-2xl mb-4">💰</div>
            <h3 class="font-bold text-slate-800">Dépenses partagées</h3>
            <p class="text-sm text-slate-500 mt-2">Ajoutez vos tickets de caisse, EasyColoc divise automatiquement la note entre les membres.</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="text-2xl mb-4">🛡️</div>
            <h3 class="font-bold text-slate-800">Système de réputation</h3>
            <p class="text-sm text-slate-500 mt-2">Soyez récompensé pour votre ponctualité ou pénalisé en cas de départ avec des dettes.</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="text-2xl mb-4">✉️</div>
            <h3 class="font-bold text-slate-800">Invitations privées</h3>
            <p class="text-sm text-slate-500 mt-2">Invitez vos amis via un lien sécurisé et gérez les rôles de chacun en un clic.</p>
        </div>
    </section>

</body>
</html>