<div>
    <div class="container mx-auto rounded">
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <table class="table w-full px-2 py-2 border-gray-900">
                    <tr>
                        <td colspan="3" class="text-center"><h3><b>Agendados</b></h3></td>
                    </tr>
                    <tr>
                        <td><b>data</b></td>
                        <td><b>Cliente</b></td>
                        <td><b>Serviço</b></td>
                    </tr>
                    @foreach($scheduledServices as $schedule)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('d/m') }}</td>
                            <td>{{ $schedule->customer->name }}</td>
                            <td>{{ $schedule->schedulableService->service }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <table class="table w-full px-2 py-2 border-gray-900">
                    <tr>
                        <td colspan="3" class="text-center"><h3><b>Checkups em aberto</b></h3></td>
                    </tr>
                    <tr>
                        <td><b>Cliente</b></td>
                        <td><b>Veículo</b></td>
                        <td><b>Placa</b></td>
                    </tr>
                    @foreach($checkups as $checkup)
                    <tr>
                        <td>vehicle_id
                            {{ $checkup->customer->name }}
                        </td>
                        <td>
                            {{ $checkup->vehicle->brand }} {{ $checkup->vehicle->model }}
                        </td>
                        <td>
                            {{ $checkup->vehicle->plate }}
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
    <div class="container mx-auto rounded">
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                Orçamentos em aberto
            </div>
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                Serviços em execução
            </div>
        </div>
    </div>
</div>
