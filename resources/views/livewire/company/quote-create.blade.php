<div>
    <div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
        <form wire:submit.prevent="showConfirmModal">

            <div class="py-1 px-1 w-full text-gray-800">
                Criar orçamento para  <span class="text-gray-600"><strong>{{ strtoupper($checkup->customer->name) }} -
                {{ $checkup->vehicle->brand }} {{ $checkup->vehicle->model }}</strong></span>
            </div>
            <div class="py-1 px-1 w-full text-gray-800">
                <label for="problemDescription" class="block mb- text-sm font-medium text-gray-800 py-1">Descrição do problema</label>
                <textarea id="problemDescription" wire:model="problemDescription" class="w-full px-2 sm:border-r rounded">
                </textarea>
            </div>
            <div class="py-1 px-1 w-full text-gray-800">
                <label for="report" class="block mb- text-sm font-medium text-gray-800 py-1">Laudo</label>
                <textarea id="report" wire:model="report" class="w-full px-2 sm:border-r rounded">
                </textarea>
            </div>
            <div class="py-1 px-1 w-full text-gray-800">
                <label for="observation" class="block mb- text-sm font-medium text-gray-800 py-1">Observações</label>
                <textarea id="observation" wire:model="observation" class="w-full px-2 sm:border-r rounded">
                </textarea>
            </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <tr>
                        <td colspan="6">
                            Serviços
                        </td>
                    </tr>
                    @foreach($quoteServices as $index => $service)
                        <tr>
                            <td>
                                <label for="quoteServiceCode{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Código do serviço</label>
                                <input type="text" id="quoteServiceCode{{ $index }}" wire:model.defer="quoteServices.{{ $index }}.service_code" placeholder="código do serviço" class="border rounded p-1">
                            </td>
                            <td>
                                <label for="quoteServiceDescription{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Descrição</label>
                                <input type="text" id="quoteServiceDescription{{ $index }}" wire:model.defer="quoteServices.{{ $index }}.description" placeholder="descrição" class="border rounded p-1 w-full">
                            </td>
                            <td>
                                <label for="quoteServiceQuantity{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Quantidade</label>
                                <input type="number" id="quoteServiceQuantity{{ $index }}" wire:model.defer="quoteServices.{{ $index }}.quantity"
                                       wire:change="updateServiceSubtotal({{ $index }})"
                                       placeholder="quantidade" min="1" class="border rounded p-1">
                            </td>
                            <td>
                                <label for="quoteServiceValue{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Valor</label>
                                <input type="number" id="quoteServiceValue{{ $index }}" wire:model.defer="quoteServices.{{ $index }}.value"
                                       wire:change="updateServiceSubtotal({{ $index }})"
                                       placeholder="preço R$" step="0.01" class="border rounded p-1">
                            </td>
                            <td>
                                <label for="quoteServiceDiscount{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Desconto(%)</label>
                                <input type="number" id="quoteServiceDiscount{{ $index }}" wire:model.defer="quoteServices.{{ $index }}.discount"
                                       wire:change="updateServiceSubtotal({{ $index }})"
                                       placeholder="desconto" step="0.01" class="border rounded p-1">
                            </td>
                            <td>
                                <label for="quoteServiceSubtotal{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Subtotal</label>
                                <input type="number" id="quoteServiceSubtotal{{ $index }}" wire:model.defer="quoteServices.{{ $index }}.subtotal" placeholder="Subtotal" readonly class="border rounded p-1 bg-gray-100">
                            </td>
                            <td class="px-1 py-1 v-align-center">
                                <br />
                                <button type="button" wire:click="removeQuoteService({{ $index }})" class="text-red-500" title="Remove linha">
                                    <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-right">
                            <b>Total em serviços:</b>
                        </td>
                        <td>
                            R$ {{ number_format($serviceSubtotal, 2, ',', '.') }}
                        </td>
                        <td class="text-right v-align-center">
                            <button type="button" wire:click="addQuoteService" class="mt-2 p-2 text-white rounded" title="adicionar linha">
                                <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </table>
                <table class="min-w-full divide-y divide-gray-200">
                    <tr>
                        <td colspan="6">
                            Peças
                        </td>
                    </tr>

                    @foreach ($quoteParts as $index => $part)
                    <tr>
                        <td>
                            <label for="quotePartCode{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Código da peça</label>
                            <input type="text" id="quotePartCode{{ $index }}" wire:model.defer="quoteParts.{{ $index }}.part_code" placeholder="código da peça" class="border rounded p-1">
                        </td>
                        <td>
                            <label for="quotePartDescription{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Descrição</label>
                            <input type="text" id="quotePartDescription{{ $index }}" wire:model.defer="quoteParts.{{ $index }}.description" placeholder="descrição" class="border rounded p-1 w-full">
                        </td>
                        <td>
                            <label for="quotePartQuantity{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Quantidade</label>
                            <input type="number" id="quotePartQuantity{{ $index }}" wire:model.defer="quoteParts.{{ $index }}.quantity"
                            wire:change="updatePartSubtotal({{ $index }})"
                            placeholder="quantidade" min="1" class="border rounded p-1">
                        </td>
                        <td>
                            <label for="quotePartValue{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Valor</label>
                            <input type="number" id="quotePartValue{{ $index }}" wire:model.defer="quoteParts.{{ $index }}.value"
                                   wire:change="updatePartSubtotal({{ $index }})"
                                   placeholder="preço R$" step="0.01" class="border rounded p-1">
                        </td>
                        <td>
                            <label for="quotePartDiscount{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Desconto(%)</label>
                            <input type="number" id="quotePartDiscount{{ $index }}" wire:model.defer="quoteParts.{{ $index }}.discount"
                                   wire:change="updatePartSubtotal({{ $index }})"
                                   placeholder="desconto" step="0.01" class="border rounded p-1">
                        </td>
                        <td>
                            <label for="quotePartSubtotal{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Subtotal</label>
                            <input type="number" id="quotePartSubtotal{{ $index }}" wire:model.defer="quoteParts.{{ $index }}.subtotal" placeholder="Subtotal" readonly class="border rounded p-1 bg-gray-100">
                        </td>
                        <td class="px-1 py-1 v-align-center">
                            <br />
                            <button type="button" wire:click="removeQuotePart({{ $index }})" class="text-red-500" title="Remove linha">
                                <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                  @endforeach
                    <tr>
                        <td colspan="5" class="text-right">
                            <b>Total em peças:</b>
                        </td>
                        <td>
                            R$ {{ number_format($partsSubtotal, 2, ',', '.') }}
                        </td>
                        <td class="text-right v-align-center">
                            <button type="button" wire:click="addQuotePart" class="mt-2 p-2 text-white rounded" title="adicionar linha">
                                <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </table>
            <div class="grid grid-cols-3 gap-4 py-1 px-1">
                <div class="col-span-1">
                    <input type="hidden" wire:model="quoteTotal">
                    Total: R$ {{ number_format($quoteTotal, 2, ',', '.') }}
                </div>
                <div class="col-span-1">
                    <input type="hidden" wire:model="quoteDiscount">
                    Descontos: R$ {{ number_format($quoteDiscount, 2, ',','.') }}
                </div>
                <div class="col-span-1">
                    <input type="hidden" wire:model="quoteNetTotal">
                    Total com descontos: R$ {{ number_format($quoteNetTotal, 2, ',', '.')  }}
                </div>
            </div>
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
    <!-- confirm modal -->
    @if($confirmModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmModal"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-h-screen overflow-y-auto relative z-10">
                <!-- Close button -->
                <button wire:click="hideConfirmModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Confira os dados do orçamento</h2>
                </div>
                <div class="py-3 px-3">
                    <form wire:submit.prevent="save">
                    <table class="min-w-full divide-y divide-gray-200 border-2 border-gray-900">
                        <tr>
                            <!-- mostra responsável pelo orçamento -->
                            <td colspan="3 text-sm">
                                Reponsável pelo orçamento: {{ $user->name }}
                                <input type="hidden" wire:modal="user_id">
                            </td>
                        </tr>
                        <!-- mostra dados do customer -->
                        <tr>
                            <td colspan="3" class="py-2"><hr></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2 text-center"><b>Cliente</b></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Nome:</b> {{ $checkup->customer->name }}
                            </td>
                            <td>
                                <b>Celular:</b> {{ $checkup->customer->cellphone }}
                            </td>
                            <td>
                                <b>E-mail:</b> {{ $checkup->customer->email }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2"><hr></td>
                        </tr>
                        <!-- mostra dados do vehicle -->
                        <tr>
                            <td colspan="3" class="py-2 text-center"><b>Veículo</b></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Marca:</b> {{ $checkup->vehicle->brand }}
                            </td>
                            <td>
                                <b>Modelo:</b> {{ $checkup->vehicle->model }}
                            </td>
                            <td>
                                <b>Cor:</b> {{ $checkup->vehicle->color }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Ano:</b> {{ $checkup->vehicle->year }}
                            </td>
                            <td>
                                <b>Placa:</b> {{ $checkup->vehicle->plate }}
                            </td>
                            <td>
                                <b>Renavam:</b> {{ $checkup->vehicle->renavam }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <b>Descrição do problema</b><br />
                                {!! nl2br($problemDescription) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <b>Laudo</b><br />
                                {!! nl2br($report) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-5">
                                <table class="min-w-full divide-y divide-gray-200 rounded">
                                    <tr>
                                        <td colspan="6" class="text-center"><b>Serviços</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>codigo</b> </td>
                                        <td><b>descrição</b></td>
                                        <td><b>quantidade</b></td>
                                        <td><b>valor</b></td>
                                        <td><b>desconto</b></td>
                                        <td><b>subtotal</b></td>
                                    </tr>
                                    @foreach($services as $service)
                                        @if($service)
                                            <tr>
                                                <td>{{ $service['service_code'] }}</td>
                                                <td>{{ $service['description'] }}</td>
                                                <td>{{ $service['quantity'] }}</td>
                                                <td>R$ {{ $service['value'] }}</td>
                                                <td>R$ {{ $service['discount_value'] }}</td>
                                                <td>R$ {{ $service['subtotal'] }}</td>

                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-center"><b>Peças</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>codigo</b> </td>
                                        <td><b>descrição</b></td>
                                        <td><b>quantidade</b></td>
                                        <td><b>valor</b></td>
                                        <td><b>desconto</b></td>
                                        <td><b>subtotal</b></td>
                                    </tr>
                                    @foreach($parts as $part)
                                        @if($part)
                                            <tr>
                                                <td>{{ $part['part_code'] }}</td>
                                                <td>{{ $part['description'] }}</td>
                                                <td>{{ $part['quantity'] }}</td>
                                                <td>R$ {{ $part['value'] }}</td>
                                                <td>R$ {{ $part['discount_value'] }}</td>
                                                <td>R$ {{ $part['subtotal'] }}</td>

                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Total bruto:</b> R$ {{ $total }}</td>
                            <td><b>Descontos:</b> R$ {{ $discount }}</td>
                            <td><b>Total:</b> R$ {{ $netTotal }}</td>
                        </tr>
                    </table>
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
        </div>
    @endif

    <!-- error modal -->
    @if($errorModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideErrorModal"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideErrorModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
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
    @if($successModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50"></div>

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
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ $successMessage }}</h2>
                </div>
                <div class="text-center py-2 px-2">
                    <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                            onclick="window.location.href='{{ route('web.quote.show', $quoteId) }}'">Ver</button>
                </div>
            </div>
        </div>
    @endif
</div>
