<div>
    <div class="mb-4 px-6 py-3">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <input
                    type="text"
                    wire:model.live="searchName"
                    placeholder="Procure por nome"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
            <div>
                <input
                    type="text"
                    wire:model.live="searchEmail"
                    placeholder="Procure por e-mail"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
            <div>
                <input
                    type="text"
                    wire:model.live="searchCellphone"
                    placeholder="Procure por celular"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
        </div>
    </div>


    <table class="bg-gray-300 w-full text-sm text-left rtl:text-right text-gray-900 sm:border-r rounded">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
            <th scope="col" class="px-6 py-3">
                Nome
            </th>
            <th scope="col" class="px-6 py-3">
                E-mail
            </th>
            <th scope="col" class="px-6 py-3">
                Celular
            </th>
            <th scope="col" class="px-6 py-3"></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr class="bg-gray-100 border-b">
                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                    {{ $customer->name }}
                    </th>
                    <td class="px-6 py-2">
                        {{ $customer->email }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $customer->cellphone }}
                    </td>
                    <td class="px-6 py-2">
                        <button wire:click="editCustomer({{ $customer->id }})" title="editar cliente">
                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z"/>
                        </svg>
                        </button>
                    </td>
                    <td class="px-6 py-2">
                        <a href="{{ route('web.checkup.create', $customer->id) }}" title="criar checkup">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9"/>
                            </svg>
                        </a>
                    </td>
                    <td class="px-6 py-2">
                        <a href="{{ route('web.schedule.create', $customer->id) }}" title="criar agendamento de serviço">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 9.05H3v2h1v-2Zm16 2h1v-2h-1v2ZM10 14a1 1 0 1 0 0 2v-2Zm4 2a1 1 0 1 0 0-2v2Zm-3 1a1 1 0 1 0 2 0h-2Zm2-4a1 1 0 1 0-2 0h2Zm-2-5.95a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-7 3a1 1 0 0 0 2 0H6Zm2-3a1 1 0 1 0-2 0h2Zm8 3a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-13 3h14v-2H5v2Zm14 0v12h2v-12h-2Zm0 12H5v2h14v-2Zm-14 0v-12H3v12h2Zm0 0H3a2 2 0 0 0 2 2v-2Zm14 0v2a2 2 0 0 0 2-2h-2Zm0-12h2a2 2 0 0 0-2-2v2Zm-14-2a2 2 0 0 0-2 2h2v-2Zm-1 6h16v-2H4v2ZM10 16h4v-2h-4v2Zm3 1v-4h-2v4h2Zm0-9.95v-3h-2v3h2Zm-5 0v-3H6v3h2Zm10 0v-3h-2v3h2Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr class="bg-gray-100 border-b">
                <td colspan="6" class="px-6 py-2">
                    {{ $customers->links() }}
                </td>
            </tr>
        </tbody>
    </table>

    @if($editModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideEditModal"></div>

            <!-- Modal -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/5 h-4/5 max-h-full overflow-y-auto relative z-10">
                <!-- Botão de fechar -->
                <button wire:click="hideEditModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <form wire:submit.prevent="updateCustomer">
                    <input type="hidden" wire:model="customer_id">
                    <input type="hidden" wire:model="type">
                    <div class="px-1 py-1">
                        <label for="name" class="block mb- text-sm font-medium text-gray-900 py-1">Nome</label>
                        <input type="text" id="name" wire:model="name" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="px-1 py-1">
                        <label for="email" class="block mb- text-sm font-medium text-gray-900 py-1">E-mail</label>
                        <input type="text" id="email" wire:model="email" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="px-1 py-1">
                        <label for="cellphone" class="block mb- text-sm font-medium text-gray-900 py-1">Celular</label>
                        <input type="text" id="cellphone" wire:model="cellphone" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" x-mask="(99) 99999-9999" required>
                    </div>
                    @if($type === 'pf')
                        <div class="px-1 py-1">
                            <label for="cpf" class="block mb- text-sm font-medium text-gray-900 py-1">CPF</label>
                            <input type="text" id="cpf" wire:model="cpf" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" x-mask="999.999.999-99">
                        </div>
                    @elseif($type === 'pj')
                        <div class="px-1 py-1">
                            <label for="cnpj" class="block mb- text-sm font-medium text-gray-900 py-1">CNPJ</label>
                            <input type="text" id="cnpj" wire:model="cnpj" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" x-mask="99.999.999/9999-99">
                        </div>
                        <div class="px-1 py-1">
                            <label for="inscricao_estadual" class="block mb- text-sm font-medium text-gray-900 py-1">Inscrição estadual</label>
                            <input type="text" id="inscricao_estadual" wire:model="inscricao_estadual" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="px-1 py-1">
                            <label for="inscricao_municipal" class="block mb- text-sm font-medium text-gray-900 py-1">Inscrição estadual</label>
                            <input type="text" id="inscricao_municipal" wire:model="inscricao_municipal" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    @endif
                    <div class="px-1 py-1">
                        <label for="birthday" class="block mb- text-sm font-medium text-gray-900 py-1">Data de nascimento</label>
                        <input type="date" id="birthday" wire:model="birthday" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="col-span-1">
                        <label for="postal_code" class="block mb- text-sm font-medium text-gray-900 py-1">CEP</label>
                        <input type="text" x-mask="99999-999" id="postal_code" wire:model="postal_code" wire:blur="requestAddress" class="block w-full p-2 text-gray-900 border border-gray-300
                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="postal_code" >
                        @if (session()->has('error'))
                            <span class="text-red-800">{{ session('error') }}</span>
                        @endif
                    </div>
                    <div class="col-span-1">@error('postal_code')<span class="error">{{ $message }}</span> @enderror</div>
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
                    <div class="py-1 px-1">
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
            font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                            <span class="sr-only">Icon description</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <!-- success moldal -->
    @if($modalSuccess)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalSuccess"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideModalSuccess" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Cliente atualizado com sucesso</h2>
                </div>
            </div>
        </div>
    @endif
    <!-- error modal -->
    @if($modalError)
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
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Erro ao alterar cliente</h2>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $error_message }}</h3>
                </div>
            </div>
        </div>
    @endif
</div>

