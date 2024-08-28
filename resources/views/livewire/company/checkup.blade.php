<div>
    <table class="table w-full px-2 py-2 border-gray-900">
        <tr>
            <td class="px-2 py-2">
                @if($checkup->evaluation)
                    {{ $checkup->evaluation }}
                @else
                    Em aberto
                @endif
            </td>
            <td colspan="2" class="text-right px-4 py-2">{{ $checkup->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="px-2"><b>Cliente:</b> {{ $checkup->customer->name }}</td>
            <td class="px-2"><b>Celular:</b> {{ $checkup->customer->cellphone }}</td>
            <td class="px-2"><b>Email: </b>{{ $checkup->customer->email }}</td>
        </tr>
        <tr>
            <td class="px-2"><b>Veículo: </b>{{ $checkup->vehicle->model }} - {{ $checkup->vehicle->brand }} - {{ $checkup->vehicle->color }}</td>
            <td class="px-2"><b>Placa: </b>{{ $checkup->vehicle->plate }}</td>
            <td class="px-2"><b>Renavam: </b>{{ $checkup->vehicle->renavam }}</td>
        </tr>
        <tr>
            <td colspan="3" class="py-2"><hr></td>
        </tr>
        <tr>
            <td colspan="3" class="py-2">
                <table class="table h-min-[50px] w-full px-2 border-gray-900">
                    <tr>
                        <td colspan="2" class="py-2 text-center"><b>Avaliação das condições de entrada</b></td>
                    </tr>
                    <tr>
                        <td class="px-2 w-1/2 h-5">
                            <b>Danos na dianteira:</b>
                            <p>{{ $checkup->front_damage }}</p>
                        </td>
                        <td class="px-2 w-1/2 h-5">
                            <b>Danos na traseira:</b>
                            <p>{{ $checkup->back_damage }}</p></td>
                    </tr>
                    <tr>
                        <td class="px-2 w-1/2 h-5">
                            <b>Danos na lateral esquerda:</b>
                            <p>{{ $checkup->left_side_damage }}</p>
                        </td>
                        <td class="px-2 w-1/2 h-5">
                            <b>Danos na lateral direita:</b>
                            <p>{{ $checkup->right_side_damage }}</p></td>
                    </tr>
                    <tr>
                        <td class="px-2 w-1/2 h-5">
                            <b>Danos no teto e/ou capô:</b>
                            <p>{{ $checkup->roof_damage }}</p>
                        </td>
                        <td class="px-2 w-1/2 h-5">
                            <b>Quantidade de combustível:</b>
                            <p>{{ $checkup->fuel_gauge }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2"><hr></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2 text-center">
                            <b>Informações do cliente</b>
                        </td>
                    </tr>
                    @foreach($checkup->checkupObservation->chunk(2) as $chunk)
                        <tr>
                            @foreach($chunk as $observation)
                                <td class="px-2">
                                    @if($observation)
                                        <b>{{ $observation->checkupObservationType->type }}:</b>
                                        <p class="px-10">{{ $observation->observation }}</p>
                                    @endif
                                </td>
                            @endforeach

                            @if($chunk->count() < 2)
                                <!-- Adiciona uma célula vazia para garantir que haja sempre 2 células por linha -->
                                <td class="px-2"></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center">
                @if($evaluation != '')
                    <button wire:click="setEvaluation" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800
                    focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                    px-5 py-2.5 text-center me-2 mb-2 ">
                        Em aberto
                    </button>
                @endif
                @if($evaluation != 'aprovado para uso')
                <button wire:click="setApproved" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800
                    focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Aprovado para uso</button>
                @endif
                @if($evaluation != 'manutenção recomendada')
                <button wire:click="setMaintenance" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800
                    focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Manutenção recomentada</button>
                @endif
            </td>
        </tr>
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
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Voce está alterando o checkup para:</h2>
                        <b>{{ $evaluationMessage }}</b>
                </div>
                <div class="text-center py-2">
                    <button wire:click="save" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium
                        rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">Confirmar</button>

                </div>
            </div>
        </div>
    @endif

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
