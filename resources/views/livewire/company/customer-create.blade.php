<div>
    <div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
        <form wire:submit="confirm">
            <div class="py-1 px-1 text-gray-800">
                Empresa <span class="text-gray-600"><strong>{{ strtoupper($company->company_name) }}</strong> </span>
                <input type="hidden" id="company_id" wire:model="company_id" value="{{ $company->id }}">
            </div>
            <div class="px-1 py-1">
                <label for="type" class="block mb- text-sm font-medium text-gray-900 py-1">Tipo</label>
                <select id="type"  wire:model.live="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option selected>Selecione o tipo de pessoa para o cadastro</option>
                    <option value="pf">PESSOA FÍSICA</option>
                    <OPTION value="pj">PESSOA JURÍCA</OPTION>
                </select>
            </div>
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

    @if($modalConfirm)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalConfirm"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideModalConfirm" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <div>
                    <div class="text-center">Confira os dados do cliente</div>
                    <form wire:submit.prevent="save">
                        <input type="hidden" wire:model="company_id">
                        <table class="bg-gray-300 w-full text-sm text-left rtl:text-right text-gray-900 sm:border-r rounded">
                            <tr>
                                <td class="px-6 py-2">Tipo</td>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="$type">
                                    @if($type == 'pf') PESSOA FÍSICA @else PESSOA JURÍDICA @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    Nome
                                </td>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="name">
                                    {{ $name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    Email
                                </td>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="email">
                                    @if($email)
                                        {{ $email }}
                                    @else
                                        <span class="text-red-700">tem certeza que não quer cadastrar o email?</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="cellphone">
                                    Celular
                                </td>
                                <td class="px-6 py-2">
                                    @if($cellphone)
                                        {{ $cellphone }}
                                    @endif
                                </td>
                            </tr>
                            @if($type === 'pf')
                                <tr>
                                    <td class="px-6 py-2">
                                        <input type="hidden" wire:model="cpf">
                                        CPF
                                    </td>
                                    <td class="px-6 py-2">
                                        @if($cpf)
                                            {{ $cpf }}
                                        @endif
                                    </td>
                                </tr>
                            @elseif($type === 'pj')
                                <tr>
                                    <td class="px-6 py-2">
                                        <input type="hidden" wire:model="cnpj">
                                        CNPJ
                                    </td>
                                    <td class="px-6 py-2">
                                        @if($cnpj)
                                            {{ $cnpj }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2">
                                        <input type="hidden" wire:model="cnpj">
                                        Incrição estadual
                                    </td>
                                    <td class="px-6 py-2">
                                        @if($inscricao_estadual)
                                            {{ $inscricao_estadual }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2">
                                        <input type="hidden" wire:model="cnpj">
                                        Inscrição municipal
                                    </td>
                                    <td class="px-6 py-2">
                                        @if($inscricao_municipal)
                                            {{ $inscricao_municipal }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="birthday">
                                    Data de nascimento
                                </td>
                                <td class="px-6 py-2">
                                    @if($birthday)
                                    {{ \Carbon\Carbon::parse($birthday)->format('d/m/Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="postal_code">
                                    CEP
                                </td>
                                <td class="px-6 py-2">
                                    @if($postal_code)
                                        {{ $postal_code }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="address">
                                    <input type="hidden" wire:model="number">
                                    Endereço
                                </td>
                                <td class="px-6 py-2">
                                    @if($address)
                                        {{ $address }}
                                    @endif
                                    @if($number)
                                       , {{ $number }}
                                        @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="neighborhood">
                                    Bairro
                                </td>
                                <td class="px-6 py-2">
                                    @if($neighborhood)
                                        {{ $neighborhood }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="city">
                                    Cidade
                                </td>
                                <td class="px-6 py-2">
                                    @if($city)
                                        {{ $city }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-2">
                                    <input type="hidden" wire:model="state">
                                    Estado
                                </td>
                                <td class="px-6 py-2">
                                    @if($state)
                                        {{ $state }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
            font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                        </svg>
                                        <span class="sr-only">Icon description</span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
    @endif

    <!-- Modal Error --->
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
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ $errorMessage }}</h2>
                </div>
            </div>
        </div>
    @endif
            <!-- modal success -->
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
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Cliente cadastrado com sucesso</h2>

                        </div>
                        <div class="text-center">
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4
                        focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" onclick="window.location.href='{{ route('web.checkup.create', $customer_id) }}'">Abrir checkup veicular</button>
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" onclick="window.location.href='{{ route('dashboard') }}'">Encerrar</button>
                        </div>
                    </div>
                </div>
            @endif
</div>
