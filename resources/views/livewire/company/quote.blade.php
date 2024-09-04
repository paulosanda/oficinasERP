<div>
    <table class="table w-full px-2 py-2 border-gray-900">
        <tr>
            <td colspan="3" class="px-2 py-1">
                <div class="w-full flex justify-end text-gray-600">
                    <a href="{{ route('web.quote.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class=" h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="py-2 px-2">
                <div class="flex items-start gap-4 px-3 py-2">
                    @if($quote->company->logo)
                    <div class="align-text-top">
                        <img src="/storage/public/logos/{{ $quote->company->logo }}" width="50" alt="logo"/>
                    </div>
                    @endif
                    <div class="text-left">
                        <h2 class="font-semibold">{{ $quote->company->company_name }}</h2>
                        CNPJ: {{ $quote->company->cnpj }}<br />
                        Telefone: {{ $quote->company->cellphone }}<br />
                        E-mail: {{ $quote->company->email }}
                    </div>
                </div>
            </td>
            <td class="text-right px-3 py-2 align-baseline">
                Orçamento número</br>
                {{ $quote->company_numbering }}
                <p>{{ __('messages.quote-status.'.$quote->status) }}</p>
            </td>
        </tr>
        <tbody>
            <tr>
                <td colspan="2">
                    <table class="table w-full px-2 py-2 border-gray-900">
                        <tr>
                            <td class="px-2">
                                Data de entrada:
                                @if($quote->entry_date)
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $quote->entry_date)->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>
                                Responsável: {{ $user->name }}
                            </td>
                            <td>
                                Data de saída:
                                @if($quote->exit_date)
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $quote->exit_date)->format('d/m/Y') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2">
                                Cliente: {{ $quote->customer->name }}
                            </td>
                            <td class="px-2">
                                @if($quote->customer->type == $typePf)
                                    CPF: {{ $quote->customer->cpf }}
                                @else
                                    CNPJ: {{ $quote->customer->cnpj }}
                                @endif
                            </td>
                            <td>
                                Telefone: {{ $quote->customer->cellphone }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2">
                                Endereço: {{ $quote->customer->address }}, {{ $quote->customer->number }}
                            </td>
                            <td>
                                Bairro: {{ $quote->customer->neighborhood }}
                            </td>
                            <td>
                                {{ $quote->customer->city }} / {{ $quote->customer->state }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center"><h2><b>VEÍCULO</b></h2></td>
                        </tr>
                        <tr>
                            <td class="px-2">
                                {{ $quote->vehicle->brand }} {{ $quote->vehicle->model }} {{ $quote->vehicle->color }}
                            </td>
                            <td>
                                Placa {{ $quote->vehicle->plate }}
                            </td>
                            <td>
                                Km {{ number_format(intval($quote->mileage), 0, '', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="bg-gray-500 text-white px-3 py-2">
                                Descrição do problema
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-2">
                                {!! nl2br($quote->problem_description ) !!}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="bg-gray-500 text-white px-3 py-2">
                                Laudo
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-2">
                                {!! nl2br($quote->report) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="bg-gray-500 text-white px-3 py-2">
                                Observações
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-2">
                                {!! nl2br($quote->observation) !!}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="px-2">
                    <table class="table w-full px-2 py-2 border-gray-900">
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <b>SERVIÇOS</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2">
                                Cód. serviço
                            </td>
                            <td>
                                Descrição
                            </td>
                            <td>
                                Qtd.
                            </td>
                            <td>
                                Valor
                            </td>
                            <td>
                                Desc.
                            </td>
                            <td>
                                Subtotal
                            </td>
                        </tr>
                        @foreach($quote->quoteService as $service)
                            <tr>
                                <td class="px-2">
                                    {{ $service->service_code }}
                                </td>
                                <td class="px-2">
                                    {{ $service->description }}
                                </td>
                                <td class="px-2">
                                    {{ $service->quantity }}
                                </td>
                                <td class="px-2">
                                    R$ {{ $service->value }}
                                </td>
                                <td class="px-2">
                                    R$ {{ $service->discount }}
                                </td>
                                <td class="px-2">
                                    R$ {{ $service->subtotal }}
                                </td>
                            </tr>
                        @endforeach

                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <b>PEÇAS</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2">
                            Cód. peça
                        </td>
                        <td>
                            Descrição
                        </td>
                        <td>
                            Qtd.
                        </td>
                        <td>
                            Valor
                        </td>
                        <td>
                            Desc.
                        </td>
                        <td>
                            Subtotal
                        </td>
                    </tr>
                    @foreach($quote->quoteParts as $part)
                        <tr>
                            <td class="px-2">
                                {{ $part->part_code }}
                            </td>
                            <td class="px-2">
                                {{ $part->description }}
                            </td>
                            <td class="px-2">
                                {{ $part->quantity }}
                            </td>
                            <td class="px-2">
                                R$ {{ $part->value }}
                            </td>
                            <td class="px-2">
                                R$ {{ $part->discount }}
                            </td>
                            <td class="px-2">
                                R$ {{ $part->subtotal }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="px-2">
                <div class="grid grid-cols-3 gap-3 py-1 px-1">
                    <div class="col-span-1">
                        <b>Total: </b>R$ {{ $quote->gross_total }}
                    </div>
                    <div class="col-span-1">
                        <b>Descontos: </b>R$ {{ $quote->discount }}
                    </div>
                    <div class="col-span-1">
                        <b>Total líquido: </b>R$ {{ $quote->net_total }}
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="flex gap-4">
                    <!-- Primeira div com assinatura e nome -->
                    <div class="flex-1 flex flex-col justify-end items-center h-20">
                        <!-- Linha de assinatura -->
                        <hr class="w-3/4 border-t-2 border-gray-800 mb-1">
                        <!-- Nome abaixo da linha -->
                        <span class="text-center">{{ $quote->customer->name }}</span>
                    </div>

                    <!-- Segunda div com assinatura e nome -->
                    <div class="flex-1 flex flex-col justify-end items-center h-20">
                        <!-- Linha de assinatura -->
                        <hr class="w-3/4 border-t-2 border-gray-800 mb-1">
                        <!-- Nome abaixo da linha -->
                        <span class="text-center">{{ $user->name }}</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                @if($quote->status == $pending)
                    <button wire:click="setAccepted" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800
                    focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Aceitar</button>
                @endif
                @if($quote->status != $rejected)
                    <button wire:click="setRejected" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800
                    focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Rejeitar</button>
                @endif
                    @if($quote->status == $accepted && $quote->entry_date && !$quote->exit_date)
                        <button wire:click="setFinalized" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800
                    focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Finalizar</button>
                    @endif
            </td>
        </tr>

        </tbody>
    </table>

    <!-- confirm modal -->
    @if($confirmModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmModal"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideConfirmModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Voce está alterando o orçamento para:</h2>
                    <b>{{ __('messages.quote-status.'.$statusMessage) }}</b>
                </div>
                <div class="text-center py-2">
                    <button wire:click="save" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium
                        rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">Confirmar</button>

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
</div>
