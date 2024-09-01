<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="grid grid-cols-2 gap-4  px-3 py-2">
            <div class="col-span-1">
            @if($status == $pending)
                <button type="button" class="text-white border border-blue-700 bg-blue-800
                focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                px-5 py-2.5 text-center me-2 mb-2 ">Pendente</button>
            @else
                <button wire:click="setStatus" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800
                focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                px-5 py-2.5 text-center me-2 mb-2 ">
                    Pendente
                </button>
            @endif
            @if($status== $accepted)
                <button class="bg-green-700 border border-green-700 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm
                    px-5 py-2.5 text-center me-2 mb-2">
                    Aprovados
                </button>
            @else
                <button wire:click="setApproved" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800
                    focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Aprovados</button>
            @endif
            @if($status == $rejected)
                <button type="button" class="text-white border border-red-700 bg-red-800
                    focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Rejeitadas</button>
            @else
                <button wire:click="setRejected" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800
                    focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5
                    py-2.5 text-center me-2 mb-2">Rejeitados</button>
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
                    <b>Data</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Número</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Cliente</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Veículo</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Status</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach($quotes as $quote)
                    <tr class="bg-white border-b  hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $quote->created_at->format('d/m/Y') }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $quote->company_numbering }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $quote->customer->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $quote->vehicle->brand }} - {{ $quote->vehicle->model }}
                        </td>
                        <td class="px-6 py-4">
                            {{ __('messages.quote-status.'.$quote->status) }}
                        </td>
                        <td>
                            <a href="{{route('web.quote.show', $quote->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="ver">
                                <svg class="w-6 h-6 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
