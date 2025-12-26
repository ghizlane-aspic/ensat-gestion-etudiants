@php
    $user = auth()->user();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Informations personnelles</h3>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-input-label value="Nom" />
                        <div class="mt-1 text-gray-900">{{ $user?->name }}</div>
                    </div>
                    <div>
                        <x-input-label value="Email" />
                        <div class="mt-1 text-gray-900">{{ $user?->email }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Changer le mot de passe</h3>

                @if (session('status') === 'password-updated')
                    <p class="mt-2 text-sm text-green-600">Mot de passe mis à jour.</p>
                @endif

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="current_password" value="Mot de passe actuel" />
                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password') ?? $errors->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Nouveau mot de passe" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password') ?? $errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation') ?? $errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Enregistrer</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
