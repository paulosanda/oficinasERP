<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-blue-500 p-4 flex items-center justify-between text-white">
            <!-- Seta para Esquerda -->
            <button wire:click="previousMonth" class="focus:outline-none">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Mês Atual -->
            <span class="text-lg font-semibold">
                {{ strtoupper($currentMonthName)}}
            </span>

            <!-- Seta para Direita -->
            <button wire:click="nextMonth" class="focus:outline-none">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    <b>Dia</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Serviço</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Cliente</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Veículo</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <b>Placa</b>
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach($scheduledServices->sortBy('scheduled_date') as $service)
                    <tr>
                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d',$service->scheduled_date)->format('d') }}
                        </td>
                        <td>
                            {{ $service->schedulableService->service }}
                        </td>
                        <td>
                            {{ $service->customer->name }}
                        </td>
                        <td>
                            {{ $service->vehicle->brand }} {{ $service->vehicle->model }}
                        </td>
                        <td>
                            {{ $service->vehicle->plate }}
                        </td>
                        <td>
                            <a href="{{route('web.schedule.show', $service->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="ver">
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
