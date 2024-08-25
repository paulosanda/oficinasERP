<div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
    <form wire:submit="save" enctype="multipart/form-data">
        <div class="px-1 py-1">
            <label for="company_name" class="block mb- text-sm font-medium text-gray-900 py-1">Empresa</label>
            <input type="text" id="company_name" wire:model="company_name" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="px-1 py-1">
            <label for="logo" class="block mb- text-sm font-medium text-gray-900 py-1">Logo</label>
            <input id="logo" wire:model="logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg
                cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none " type="file">
        </div>
        <div>@error('logo')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="py-1 px-1">
            <label for="cnpj" class="block mb- text-sm font-medium text-gray-900 py-1">CNPJ</label>
            <input type="text" id="cnpj" wire:model="cnpj" x-mask="99.999.999/9999-99" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>@error('cnpj')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="py-1 px-1">
            <label for="inscricao_estadual" class="block mb- text-sm font-medium text-gray-900 py-1">Inscrição Estadual</label>
            <input type="text" id="inscricao_estadual" wire:model="inscricao_estadual" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>@error('inscricao_estadual')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="py-1 px-1">
            <label for="inscricao_municipal" class="block mb- text-sm font-medium text-gray-900 py-1">Inscrição Municipal</label>
            <input type="text" id="inscricao_municipal" wire:model="inscricao_municipal" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>@error('inscricao_municipal')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="grid grid-cols-3 gap-3 py-1 px-1">
            <div class="col-span-1">
                <label for="postal_code" class="block mb- text-sm font-medium text-gray-900 py-1">CEP</label>
                <input type="text" x-mask="99999-999" id="postal_code" wire:model="postal_code" wire:blur="requestAddress" class="block w-full p-2 text-gray-900 border border-gray-300
                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="postal_code" >
                @if (session()->has('error'))
                    <span class="text-red-800">{{ session('error') }}</span>
                @endif
            </div>
            <div class="col-span-1">@error('postal_code')<span class="error">{{ $message }}</span> @enderror</div>
        </div>
        <div class="grid grid-cols-4 gap-4 py-1 px-1">
            <div class="col-span-3">
                <label for="address" class="block mb- text-sm font-medium text-gray-900 py-1">Endereço</label>
                <input type="text" id="address" wire:model="address" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="address">
            </div>
            <div class="col-span-1">
                <label for="number" class="block mb- text-sm font-medium text-gray-900 py-1">Número</label>
                <input type="text" id="number" wire:model="number" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
        </div>
        <div class="py-1 px-1">
            <label for="neighborhood" class="block mb- text-sm font-medium text-gray-900 py-1">Bairro</label>
            <input type="text" id="neighborhood" wire:model="neighborhood" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>@error('neighborhood')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="grid grid-cols-4 gap-4 py-1 px-1">
            <div class="col-span-3">
                <label for="city" class="block mb- text-sm font-medium text-gray-900 py-1">Cidade</label>
                <input type="text" id="city" wire:model="city" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="col-span-1">
                <label for="state" class="block mb- text-sm font-medium text-gray-900 py-1">Estado</label>
                <input type="text" id="state" wire:model="state" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
        </div>
        <div>@error('city')<span class="error">{{ $message }}</span> @enderror</div>
        <div>@error('state')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="grid grid-cols-4 gap-4 py-1 px-1">
            <div class="col-span-2">
                <label for="email" class="block mb- text-sm font-medium text-gray-900 py-1">E-mail</label>
                <input type="email" id="email" wire:model="email" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="email" required>
            </div>
            <div class="col-span-2">
                <label for="cellphone" class="block mb- text-sm font-medium text-gray-900 py-1">Celular</label>
                <input type="text" id="cellphone" wire:model="cellphone" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" x-mask="(99) 99999-9999" required>
            </div>
        </div>
        <div>@error('email')<span class="error">{{ $message }}</span> @enderror</div>
        <div>@error('cellphone')<span class="error">{{ $message }}</span> @enderror</div>
        <div class="py-1 px-1">
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
            font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
                <span class="sr-only">Icon description</span>
            </button></div>
    </form>
</div>

<!-- cadastrar usuário para empresa recem cadastrada -->

