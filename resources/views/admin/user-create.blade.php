<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Cadastrar Usuário') }}
        </h2>
        <div class="py-4">
            <livewire:create-user :company_id="$companyId"/>
        </div>
    </x-slot>
</x-app-layout>
