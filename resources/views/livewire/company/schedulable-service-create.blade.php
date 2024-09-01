<div>
    <div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
        <form wire:submit.prevent="confirm">
            <div class="py-1 px-1 text-gray-800">
                Agendar serviço para  <span class="text-gray-600"><strong>{{ strtoupper($customer->name) }}</strong> </span>
            </div>
            @if($customer->vehicle->count() == 0)
                <div class="px-2 py-2">
                    <h2 class="text-red-700">Este cliente ainda não tem veículo cadastrado,
                        <b><a href="{{ route('web.checkup.create', $customer->id).'?op=schedule' }}" class="underline text-blue-800">crie um agora</a> </b>
                        para poder fazer um agendar um serviço.</h2>
                </div>
            @endif
            @if($customer->vehicle->count() == 1)
                <div class="grid grid-cols-4 gap-4 py-1 px-1">
                    <div class="col-span-1 text-gray-800">
                        {{ $customer->vehicle[0]->model }} {{ $customer->vehicle[0]->brand }}
                        <input type="hidden" wirel:model="vehicleId" value="{{ $customer->vehicle[0]->id }}">
                    </div>
                    <div class="col-span-1 text-gray-800">
                        Placa: {{ $customer->vehicle[0]->plate }}
                    </div>
                    <div class="col-span-1 text-gray-800">
                        Ano: {{ $customer->vehicle[0]->year }}
                    </div>
                    <div class="col-span-1 text-gray-800">
                        Cor: {{ $customer->vehicle[0]->color }}
                    </div>
                </div>
            @endif
            @if($customer->vehicle->count() > 1)
                <div class="py-1 px-1">
                    <label for="type" class="block mb- text-sm font-medium text-gray-900 py-1">Este cliente tem veículo(s) cadastrado(s).</label>
                    <select id="vehicle_id"  wire:model="vehicleId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                        rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>Selecione o veículo</option>
                        @foreach($customer->vehicle as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ strtoupper($vehicle->brand)  }} {{ strtoupper($vehicle->model) }} - {{ $vehicle->color }} - placa {{ $vehicle->plate }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="py-1 px-1">
                {{ $schedulableServices }}
            </div>
        </form>
    </div>
</div>
