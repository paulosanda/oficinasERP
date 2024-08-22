<div>
<div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
    <form wire:submit="save">
        <div class="py-1 px-1 text-gray-800">
            Empresa <span class="text-gray-600"><strong>{{ strtoupper($company->company_name) }}</strong> </span> cadastrada com sucesso, insira agora um usuário com o status de MASTER
            <input type="hidden" id="company_id" wire:model="company_id" value="{{ $company->id }}">
        </div>
        <div class="px-1 py-1">
            <label for="name" class="block mb- text-sm font-medium text-gray-900 py-1">Nome</label>
            <input type="text" id="name" wire:model="name" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="px-1 py-1">
            <label for="email" class="block mb- text-sm font-medium text-gray-900 py-1">E-mail</label>
            <input type="email" id="email" wire:model="email" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="px-1 py-1">
            <label for="role_id" class="block mb- text-sm font-medium text-gray-900 py-1">Status</label>
            <select id="role_id"  wire:model="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="null">Escolha um status</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                @endforeach
            </select>
        </div>
        <div class="px-1 py-1">
            <label for="password" class="block mb- text-sm font-medium text-gray-900 py-1">Senha</label>
            <input type="password" id="password" wire:model="password" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="py-1 px-1">
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
            font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
                <span class="sr-only">Icon description</span>
            </button>
            <button wire:click="showModalError" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button></div>
    </form>
</div>

<!-- modal de confirmação de cadastro da empresa e aviso para cadastro do usuário master -->
@if($userCreateError)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalError"></div>

        <!-- Modal content -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
            <!-- Close button -->
            <button wire:click="hideModalError" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Confirmation message -->
            <div class="text-center">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Erro ao criar usuário</h2>
            </div>
        </div>
    </div>
@endif

    @if($userCreateSuccess)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalError"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideModalError" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Usuário criado com sucesso</h2>
                </div>
                <div class="text-center">
                    <button wire:click="createAnotherUser" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4
                        focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Default</button>
                    <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" onclick="window.location.href='{{ route('dashboard') }}'">Encerrar</button>
                </div>
            </div>
        </div>
    @endif

</div>
