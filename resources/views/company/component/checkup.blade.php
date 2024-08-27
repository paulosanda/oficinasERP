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
                                    <b>{{ $observation->checkupObservationType->type }}</b>
                                    <p>{{ $observation->observation }}</p>
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
    </tr>
</table>
