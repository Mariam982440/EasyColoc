<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des Utilisateurs</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b text-gray-400 text-xs uppercase">
                            <th class="p-3">Nom</th>
                            <th class="p-3">Rôle</th>
                            <th class="p-3">Statut</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-sm font-bold">{{ $user->name }}</td>
                            <td class="p-3 text-sm">{{ $user->role_type }}</td>
                            <td class="p-3 text-sm">
                                {{ $user->banned_at ? '🚫 Banni' : '✅ Actif' }}
                            </td>
                            <td class="p-3 text-right">
                                @if($user->role_type !== 'admin')
                                <form action="{{ route('admin.toggle-ban', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold uppercase {{ $user->banned_at ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $user->banned_at ? 'Débannir' : 'Bannir' }}
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>