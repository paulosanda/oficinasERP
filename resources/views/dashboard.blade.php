<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if(auth()->user()->company_id == 1)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Olá {{ auth()->user()->name }}, use o menu acima para operar seus sistema.

                </div>
            </div>
        </div>
    </div>
    @endif
    @if(auth()->user()->company_id > 1)
        <!-- dashboard de company o 1 está reservado para administradora do sistema -->
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:company.dashboard-cards />

                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
