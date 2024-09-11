<div>
@if(!isset($selectedCompany))
<table class="bg-gray-300 w-full text-sm text-left rtl:text-right text-gray-900 sm:border-r rounded">
    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
    <tr>
        <th scope="col" class="px-6 py-3">
            Razão Social
        </th>
        <th scope="col" class="px-6 py-3">
            CNPJ
        </th>
        <th scope="col" class="px-6 py-3">
            Celular
        </th>
        <th scope="col" class="px-6 py-3">
            E-mail
        </th>
        <th>

        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($companies as $company)
        <tr class="bg-gray-100 border-b">
            <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                @if($company->logo)
                    <img src="/storage/public/logos/{{ $company->logo }}" width="50" alt="logo"/>
                @endif
                {{ $company->company_name }}
            </th>
            <td class="px-6 py-2">
                {{ $company->cnpj }}
            </td>
            <td class="px-6 py-2">
                {{ $company->cellphone }}
            </td>
            <td class="px-6 py-2">
                {{ $company->email }}
            </td>
            <td>
                <form wire:submit.prevent="selectCompanyMethod({{ $company->id }})">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Ver Detalhes
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    <tr class="bg-gray-100 border-b">
        <td colspan="5" class="px-6 py-2">
            {{ $companies->links() }}
        </td>
    </tr>
    </tbody>
</table>
</div>
@endif
@if(isset($selectedCompany))
<div>
    <table class="bg-gray-300 w-full text-sm text-left rtl:text-right text-gray-900 sm:border-r rounded py-6 px-2">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3 flex items-center">
                    <span class="text-center text-2xl">
                    @if($selectedCompany->logo)
                    <img src="/storage/public/logos/{{ $selectedCompany->logo }}" width="100" alt="logo"/>{{ $selectedCompany->company_name }}
                    @endif
                    {{ $selectedCompany->company_name }}
                    </span>
                </th>
                <th></th>
                <th class="px-6 py-3">
                    @if($selectedCompany->active)
                        <button wire:click="alterActiveState" class="bg-red-500 text-white px-4 py-2 rounded">Bloquear</button></th>
                    @else
                    <button wire:click="alterActiveState" class="bg-green-500 text-white px-4 py-2 rounded">Desbloquear</button></th>
                    @endif

                <th scope="col" class="px-6 py-3 flex justify-end">

                    <button wire:click="showCompanyToEdit" class="bg-blue-500 text-white px-4 py-2 rounded">Editar</button>

                </th>
            </tr>
        </thead>
        <tbody>
        <tr class="bg-gray-100 border-b">
            <th scope="row"  class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                Celular: {{ $selectedCompany->cellphone }}
            </th>
            <td colspan="2">
                E-mail: {{ $selectedCompany->email }}
            </td>
            <td>
                Situação:
                @if($selectedCompany->active)
                    ATIVA
                @else
                <span class="text-red-900">BLOQUEADA</span>
                @endif
            </td>
        </tr>
            <tr class="bg-gray-100 border-b">
                <th scope="row"  class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                    CNPJ: {{ $selectedCompany->cnpj }}
                </th>
                <td>
                    Inscrição Estadual: {{ $selectedCompany->inscricao_estadual }}
                </td>
                <td colspan="2">
                    Inscrição Municipal: {{ $selectedCompany->inscricao_municipal }}
                </td>
            </tr>
            <tr class="bg-gray-100 border-b">
                <th scope="row"  class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                    Endereço: {{ $selectedCompany->address }} , {{ $selectedCompany->number }}
                </th>
                <td colspan="3">
                    Bairro: {{ $selectedCompany->neighborhood }}
                </td>
            </tr>
            <tr class="bg-gray-100 border-b">
                <th scope="row"  class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                    Cidade:{{ $selectedCompany->city }}
                </th>
                <td>Estado: {{ $selectedCompany->state }}</td>
                <td colspan="2">
                    CEP: {{ $selectedCompany->postal_code }}
                </td>
            </tr>
            <tr class="bg-gray-100 border-b">
                <th scope="row"  colspan="4" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap items-center">
                    Usuários
                </th>
            </tr>
            @foreach($selectedCompany->users as $user)
                <tr class="bg-gray-100 border-b">
                    <th scope="row"  class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                        {{ $user->name }}
                    </th>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                            {{ $role->role }}
                        @endforeach
                    </td>

                    <td class="px-6 flex justify-end">
                        <button wire:click="showModalEditUser({{ $user->id }})" class="bg-blue-500 text-white px-4 py-2 rounded">Editar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para aleração de company --->
@if($showModalEditCompany)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" wire:click="hideCompanyToEdit"></div>

        <!-- Modal -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-3/5 h-4/5 max-h-full overflow-y-auto relative z-10">
            <!-- Botão de fechar -->
            <button wire:click="hideCompanyToEdit" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <form wire:submit.prevent="updateCompany" enctype="multipart/form-data">
                <!---
                <div class="px-1 py-1">
                    <label for="logo" class="block text-sm font-medium text-gray-900 py-1">Logo</label>
                    <input id="logo" wire:model="logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file">
                </div>
                --->
                <div>@error('logo')<span class="error">{{ $message }}</span> @enderror</div>
                <div class="px-1 py-1">
                    <input type="hidden" id="company_id" wire:model="company_id" value="{{ $selectedCompany->id }}">
                    <label for="company_name" class="block text-sm font-medium text-gray-900 py-1">Empresa</label>
                    <input type="text" id="company_name" wire:model="company_name" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required >
                </div>
                <div>@error('company_name')<span class="error">{{ $message }}</span> @enderror</div>
                <div class="py-1 px-1">
                    <label for="cnpj" class="block text-sm font-medium text-gray-900 py-1">CNPJ</label>
                    <input type="text" id="cnpj" wire:model="cnpj" x-mask="99.999.999/9999-99" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>@error('cnpj')<span class="error">{{ $message }}</span> @enderror</div>
                <div class="py-1 px-1">
                    <label for="inscricao_estadual" class="block text-sm font-medium text-gray-900 py-1">Inscrição Estadual</label>
                    <input type="text" id="inscricao_estadual" wire:model="inscricao_estadual" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>@error('inscricao_estadual')<span class="error">{{ $message }}</span> @enderror</div>
                <div class="py-1 px-1">
                    <label for="inscricao_municipal" class="block text-sm font-medium text-gray-900 py-1">Inscrição Municipal</label>
                    <input type="text" id="inscricao_municipal" wire:model="inscricao_municipal" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>@error('inscricao_estadual')<span class="error">{{ $message }}</span> @enderror</div>
                <div class="grid grid-cols-3 gap-3 py-1 px-1">
                    <div class="col-span-1">
                        <label for="postal_code" class="block text-sm font-medium text-gray-900 py-1">CEP</label>
                        <input type="text" x-mask="99999-999" id="postal_code" wire:model="postal_code" wire:blur="requestAddress" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="postal_code">
                        @if (session()->has('error'))
                            <span class="text-red-800">{{ session('error') }}</span>
                        @endif
                    </div>
                    <div class="col-span-1">@error('postal_code')<span class="error">{{ $message }}</span> @enderror</div>
                </div>
                <div class="grid grid-cols-4 gap-4 py-1 px-1">
                    <div class="col-span-3">
                        <label for="address" class="block text-sm font-medium text-gray-900 py-1">Endereço</label>
                        <input type="text" id="address" wire:model="address" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="address">
                    </div>
                    <div class="col-span-1">
                        <label for="number" class="block text-sm font-medium text-gray-900 py-1">Número</label>
                        <input type="text" id="number" wire:model="number" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                <div class="py-1 px-1">
                    <label for="neighborhood" class="block text-sm font-medium text-gray-900 py-1">Bairro</label>
                    <input type="text" id="neighborhood" wire:model="neighborhood" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="neighborhood">
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
    </div>
@endif
@endif

<!-- Modal de Confirmação -->
@if($showModelEditCompanySuccess)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmationModal"></div>

        <!-- Modal content -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
            <!-- Close button -->
            <button wire:click="hideConfirmationModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Confirmation message -->
            <div class="text-center">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Dados da empresa alterados com sucesso</h2>
            </div>
        </div>
    </div>
@endif

@if($modalEditUser)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalEditUser"></div>

        <!-- Modal -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-3/5 h-4/5 max-h-full overflow-y-auto relative z-10">
            <!-- Botão de fechar -->
            <button wire:click="hideModalEditUser" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <form wire:submit.prevent="updateUser">
                <div class="px-1 py-1">
                    <input type="hidden" wire:model="user_id">
                    <label for="name" class="block mb- text-sm font-medium text-gray-900 py-1">Nome</label>
                    <input type="text" id="name" wire:model="name" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" >
                </div>
                <div class="px-1 py-1">
                    <label for="email" class="block mb- text-sm font-medium text-gray-900 py-1">E-mail</label>
                    <input type="email" id="email" wire:model="email" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="px-1 py-1">
                    <span class="block mb- text-sm font-medium text-gray-900 py-1">Roles</span>
                    @foreach($roles as $role)
                        <div class="flex items-center mb-2">
                            <input id="role-{{ $role['id'] }}" type="checkbox" wire:model="selectedRoles" value="{{ $role['id'] }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   @if(collect($userToEdit->roles)->contains('id', $role['id']))
                                      @checked(TRUE)
                                @endif
                             />
                            <label for="role-{{ $role['id'] }}" class="ml-2 text-sm text-gray-900">{{ $role['role_description'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="px-1 py-1">
                    <label for="password" class="block mb- text-sm font-medium text-gray-900 py-1">Senha</label>
                    <input type="password" id="password" wire:model="password" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
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
    </div>
@endif

@if($modalEditUserSuccess)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalEditUserSuccess"></div>

        <!-- Modal content -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
            <!-- Close button -->
            <button wire:click="hideModalEditUserSuccess" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Confirmation message -->
            <div class="text-center">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Dados do usuário alterados com sucesso</h2>
            </div>
        </div>
    </div>
@endif
