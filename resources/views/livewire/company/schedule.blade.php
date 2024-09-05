<div>
    <table class="table w-full px-2 py-2 border-gray-900">
        <tr>
            <td colspan="3" class="px-2 py-1">
                <div class="w-full flex justify-end text-gray-600">
                    <a href="{{ route('web.schedule.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class=" h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="py-2 px-2">
                <div class="w-full text-center text-blue-800 font-bold">
                    <h2>{{ $scheduledService->schedulableService->service }}</h2>
                </div>

            </td>
            <td class="font-bold">
                Data: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $scheduledService->scheduled_date)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td class="py-2 px-2">
                Nome: {{ $scheduledService->customer->name }}
            </td>
            <td>
                E-mail: {{ $scheduledService->customer->email }}
            </td>
            <td>
                Celular: {{ $scheduledService->customer->cellphone }}
            </td>
        </tr>
        <tr>
            <td class="px-2 py-2">
                Veículo: {{ $scheduledService->vehicle->brand }} {{ $scheduledService->vehicle->model }} {{ $scheduledService->vehicle->color }}
            </td>
            <td>
                Placa: {{ $scheduledService->vehicle->plate }}
            </td>
        </tr>
    </table>
</div>
