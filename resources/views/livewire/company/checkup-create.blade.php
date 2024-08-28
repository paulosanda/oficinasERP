<div>
    <div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
        <div class="py-1 px-1 text-gray-800">
            Checkup Veicular para  <span class="text-gray-600"><strong>{{ strtoupper($customer->name) }}</strong> </span>
        </div>
        @if(!$vehicleSelected)
        <!-- se customer tiver veículos cadastrados -->
            @if($vehicles->count() > 0)
                <div class="px-1 py-1">
                    <form wire:submit.prevent="setVehicle">
                        <input type="hidden" wire.model="customer_id" value="{{ $customer_id }}">
                        <label for="type" class="block mb- text-sm font-medium text-gray-900 py-1">Este cliente tem veículo(s) cadastrado(s), se a avaliação for para um testes pode escolher abaixo.</label>
                        <select id="vehicle_id"  wire:model="vehicle_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                        rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Selecione o veículo</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ strtoupper($vehicle->brand)  }} {{ strtoupper($vehicle->model) }} - {{ $vehicle->color }} - placa {{ $vehicle->plate }}</option>
                            @endforeach
                        </select>
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
           @endif
        @if(!$newVehicle)
            <div class="px-1 py-1 text-gray-800 text-center"><h3>Cadastrar novo veículo</h3></div>
            <form wire:submit.prevent="confirmVehicle">
            <div class="grid grid-cols-4 gap-4 py-1 px-1">
                <div class="col-span-1">
                    <label for="brand" class="block mb- text-sm font-medium text-gray-900 py-1">Marca</label>
                    <input type="text" id="brand" wire:model="brand" class="block w-full p-2 text-gray-900 border border-gray-300
                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="col-span-3">
                    <label for="model" class="block mb- text-sm font-medium text-gray-900 py-1">Modelo</label>
                    <input type="text" id="model" wire:model="model" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 py-1 px-1">
                <div class="col-span-1">
                    <label for="color" class="block mb- text-sm font-medium text-gray-900 py-1">Cor</label>
                    <input type="text" id="color" wire:model="color" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="col-span-1">
                    <label for="year" class="block mb- text-sm font-medium text-gray-900 py-1">Ano</label>
                    <input type="text" id="year" wire:model="year" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="col-span-1">
                    <label for="plate" class="block mb- text-sm font-medium text-gray-900 py-1">Placa</label>
                    <input type="text" id="plate" wire:model="plate" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="col-span-1">
                    <label for="renavam" class="block mb- text-sm font-medium text-gray-900 py-1">Renavam</label>
                    <input type="text" id="renavam" wire:model="renavam" class="block w-full p-2 text-gray-900 border border-gray-300
            rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="py-1 px-1">
                <label for="observation" class="block mb- text-sm font-medium text-gray-900 py-1">Observação</label>
                <textarea id="observation" wire:model="observation" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
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
           @endif
        @endif

        @if($vehicleSelected)
        <form wire:submit="confirm">
            <div class="text-center">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Verifique os dados do veículo que está cadastrando para {{ $customer->name }}</h2>
            </div>
            <div class="grid grid-cols-4 gap-1 py-1 px-1">
                <div class="col-span-1">Marca: {{ $brand }}</div>
                <div class="col-span-1">Modelo: {{ $model }}</div>
                <div class="col-span-1">Cor: {{ $color }}</div>
                <div class="col-span-1">Ano: {{ $year }}</div>
            </div>
            <div class="grid grid-cols-2 gap-1 py-1 px-1">
                <div class="col-span-1">Placa: {{ $plate }}</div>
                <div class="col-span-1">Renavam: {{ $renavam }}</div>
            </div>
            @if($observation)
                <div>
                    <h3>Observações</h3>
                    {{ $observation }}
                </div>
            @endif
            <input type="hidden" id="customer_id" wire:model="customer" value="{{ $customer->id }}">
            <div class="px-1 py-2"><hr></div>
            <div class="px-1 py-1 bg-red-500 sm-border rounded">
                <div class="px-1 py-1">
                    <label for="front_damage" class="block mb- text-sm font-medium text-gray-200 py-1">Danos frontais?</label>
                    <input type="text" id="front_damage" wire:model="front_damage" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="px-1 py-1">
                    <label for="front_damage" class="block mb- text-sm font-medium text-gray-200 py-1">Danos traseiros?</label>
                    <input type="text" id="back_damage" wire:model="back_damage" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="px-1 py-1">
                    <label for="right_side_damage" class="block mb- text-sm font-medium text-gray-200 py-1">Danos na lateral direita?</label>
                    <input type="text" id="right_side_damage" wire:model="right_side_damage" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="px-1 py-1">
                    <label for="left_side_damage" class="block mb- text-sm font-medium text-gray-200 py-1">Danos na lateral esquerda?</label>
                    <input type="text" id="left_side_damage" wire:model="left_side_damage" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="px-1 py-1">
                    <label for="roof_damage" class="block mb- text-sm font-medium text-gray-200 py-1">Danos no teto ou capô?</label>
                    <input type="text" id="roof_damage" wire:model="roof_damage" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="px-1 py-1">
                    <label for="fuel_gauge" class="block mb- text-sm font-medium text-gray-200 py-1">Quantidade de combustível</label>
                    <select id="fuel_gauge"  wire:model="fuel_gauge" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">quanto de combustível há no tanque?</option>
                        <option value="vazio">vazio</option>
                        <option>1/4</option>
                        <option>1/2</option>
                        <option>3/4</option>
                        <option value="cheio">cheio</option>
                    </select>
                </div>
            </div>
            <div class="py-1 px-1 text-center">
                Observações do cliente
            </div>
            @foreach($checkupObservations as $observation)
                <div class="px-1 py-1">
                    <label for="checkup_observation{{ $observation->id }}" class="block mb- text-sm font-medium text-gray-900 py-1">{{ $observation->type }}</label>
                    <input type="text" id="checkup_observation{{ $observation->id }}" wire:model="checkup_observations.{{ $observation->id }}" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            @endforeach
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
    @endif

    @if($confirmVehicleModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmVehicleModal"></div>
            <form wire:submit.prevent="saveVehicle">
                <!-- Modal content -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-2/3 relative z-10">
                    <!-- Close button -->
                    <button wire:click="hideConfirmVehicleModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Confirmation message -->
                    <div class="text-center">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Verifique os dados do veículo que está cadastrando para {{ $customer->name }}</h2>
                    </div>
                    <div class="grid grid-cols-4 gap-1 py-1 px-1">
                        <div class="col-span-1">Marca: {{ $brand }}</div>
                        <div class="col-span-1">Modelo: {{ $model }}</div>
                        <div class="col-span-1">Cor: {{ $color }}</div>
                        <div class="col-span-1">Ano: {{ $year }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-1 py-1 px-1">
                        <div class="col-span-1">Placa: {{ $plate }}</div>
                        <div class="col-span-1">Renavam: {{ $renavam }}</div>
                    </div>
                    @if($observation)
                        <div>
                            <h3>Observações</h3>
                            {{ $observation }}
                        </div>
                    @endif
                    <div class="text-center">
                        <button wire:click="hideConfirmVehicleModal" type="button" class="text-white bg-red-700 hover:bg-blue-800 focus:ring-4
                        focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Corrigir</button>
                        <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if($modalConfirm)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmVehicleModal"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-h-screen overflow-y-auto relative z-10">
                <!-- Close button -->
                <button wire:click="hideModalConfirm" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Verifique os dados do checkup</h2>
                </div>
                <div class="py-3 px-3">
                   <form wire:submit.prevent="save">
                       <div class="grid grid-cols-3 gap-3 py-1 px-1">
                           <div class="col-span-1">
                               <input type="hidden" wire:model="customer_id">
                               Cliente: {{ $customer->name }}
                           </div>
                           <div class="col-span-1">E-mail: {{ $customer->email }}</div>
                           <div class="col-span-1">Celular: {{ $customer->cellphone }}</div>
                       </div>
                       <div class="grid grid-cols-4 gap-3 py-1 px-1">
                           <div class="col-span-1">Marca: {{ $brand }}</div>
                           <div class="col-span-1">Modelo: {{ $model }}</div>
                           <div class="col-span-1">Cor: {{ $color }}</div>
                           <div class="col-span-1">Ano: {{ $year }}</div>
                       </div>
                       <div class="grid grid-cols-2 gap-3 py-1 px-1">
                           <div class="col-span-1">Placa: {{ $plate }}</div>
                           <div class="col-span-1">Renavam: {{ $renavam }}</div>
                       </div>
                       <div class="px-1 py-1">
                           {{ $vehicleObservation }}
                       </div>
                       <div><hr></div>
                       <div class="text-center"><h3><b>Avarias</b></h3></div>
                       <div class="grid grid-cols-2 gap-3 py-1 px-1">
                           <div class="col-span-1"><b>Danos frontais:</b> {{ $front_damage }}</div>
                           <div class="col-span-1"><b>Danos traseira:</b> {{ $back_damage }}</div>
                       </div>
                       <div class="grid grid-cols-2 gap-3 py-1 px-1">
                           <div class="col-span-1"><b>Danos do lado esquerdo:</b> {{ $left_side_damage }}</div>
                           <div class="col-span-1"><b>Danos do lado direito:</b> {{ $right_side_damage }}</div>
                       </div>
                       <div class="grid grid-cols-2 gap-3 py-1 px-1">
                           <div class="col-span-1"><b>Danos no teto e/ou capô:</b> {{ $roof_damage }}</div>
                           <div class="col-span-1"><b>Combustível:</b> {{ $fuel_gauge }}</div>
                       </div>
                       @foreach($checkup_observations as $observation => $data )
                           <div class="px-1 py-1">
                                @php
                                $observationType = $checkupObservations->firstWhere('id', $observation);
                                @endphp
                               <div class="py-1 px-1">
                                   <b>{{ $observationType->type }}: </b>{{ $data }}
                               </div>

                           </div>
                       @endforeach
                       <div class="text-center py-3">
                           <button wire:click="hideModalConfirm" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4
                        focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Corrigir</button>
                           <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Salvar</button>
                       </div>
                   </form>
                </div>
            </div>
        </div>
    @endif

    @if($errorModal)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalError"></div>

        <!-- Modal content -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
            <!-- Close button -->
            <button wire:click="hideModalError" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
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
                            onclick="window.location.href='{{ route('web.checkup.show', $checkup_id) }}'">Ver</button>
                </div>
            </div>
        </div>
    @endif
</div>
