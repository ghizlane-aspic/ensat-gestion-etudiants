<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des Étudiants
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Message de succès -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- En-tête avec bouton Ajouter -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Liste des étudiants</h3>
                        <a href="{{ route('etudiants.create') }}" class="bg-600 hover:bg-700 text-black font-bold py-4 px-6 rounded transition" >
                          +
                        </a>
                    </div>

                    <!-- Table des étudiants -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($etudiants as $etudiant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $etudiant->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $etudiant->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $etudiant->prenom ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $etudiant->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $etudiant->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('etudiants.edit', $etudiant) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Éditer</a>
                                            <form action="{{ route('etudiants.destroy', $etudiant) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Supprimer cet étudiant ?')" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun étudiant trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $etudiants->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>