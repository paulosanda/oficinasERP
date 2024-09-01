<div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="grid grid-cols-2 gap-4  px-3 py-2">
            <div class="col-span-1">
                @if($evaluation == $pending)
                <button type="button" class="text-white border border-blue-700 bg-blue-800
                focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                px-5 py-2.5 text-center me-2 mb-2 ">
                    {{ __('messages.checkup-evaluation.'.$pending) }}
                </button>
                @else
                    <button wire:click="setEvaluation" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800
                focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                px-5 py-2.5 text-center me-2 mb-2 ">
                        {{ __('messages.checkup-evaluation.'.$pending) }}
                    </button>
                @endif
                @if($evaluation == 'aprovado para uso')
                    <button class="bg-green-700 border border-green-700 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                    px-5 py-2.5 text-center me-2 mb-2">
                        {{ __('messages.checkup-evaluation.'.$approved) }}
                    </button>
                @else
                    <button wire:click="setApproved" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800
                    focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">
                        {{ __('messages.checkup-evaluation.'.$approved) }}
                    </button>
                @endif
                @if($evaluation == 'manutenção recomendada')
                    <button type="button" class="text-white border border-red-700 bg-red-800
                    focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">
                        {{ __('messages.checkup-evaluation.'.$maintenance) }}
                    </button>
                @else
                    <button wire:click="setMaintenance" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800
                    focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">
                        {{ __('messages.checkup-evaluation.'.$maintenance) }}
                    </button>
                @endif
            </div>
            <div class="col-span-1">
                <select id="dateInterval" wire:change="setInterval" wire:model="dateInterval" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
        rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecione o período que deseja consultar</option>
                    <option value="7">7 dias</option>
                    <option value="15">15 dias</option>
                    <option value="30">30 dias</option>
                </select>
            </div>

        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Cliente
                </th>
                <th scope="col" class="px-6 py-3">
                    Celular
                </th>
                <th scope="col" class="px-6 py-3">
                    Veículo
                </th>
                <th scope="col" class="px-6 py-3">
                    Placa
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($checkups as $checkup)
                <tr class="bg-white border-b  hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $checkup->customer->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $checkup->customer->cellphone }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $checkup->vehicle->model }} - {{ $checkup->vehicle->brand }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $checkup->vehicle->plate }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <table>
                            <tr>
                                <td>
                                    <a href="{{route('web.checkup.show', $checkup->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="ver">
                                        <svg class="w-6 h-6 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('web.quote.create', $checkup->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="realizar orçamento">
                                    <svg class="w-6 h-6 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 6 2 2 4-4m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                    </svg>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            @endforeach
            <tr class="bg-gray-100 border-b">
                <td colspan="5" class="px-6 py-2">
                    {{ $checkups->links() }}
                </td>
            </tr>

            </tbody>
        </table>
    </div>

</div>
