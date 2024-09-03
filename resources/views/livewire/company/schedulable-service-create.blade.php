<div>
    <div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
        <form wire:submit.prevent="showConfirmModal">
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
                        <input type="hidden" wire:model="vehicleId" value="{{ $customer->vehicle[0]->id }}">
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
                        rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option selected value="">Selecione o veículo</option>
                        @foreach($customer->vehicle as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ strtoupper($vehicle->brand)  }} {{ strtoupper($vehicle->model) }} - {{ $vehicle->color }} - placa {{ $vehicle->plate }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="py-1 px-1">
                <table class="table w-full">
                    <tr>
                        <td colspan="4" class="text-center w-full"><b>Serviços a serem agendados</b></td>
                    </tr>
                    @foreach($scheduleService as $index => $service)
                        <tr>
                            <td>
                                <label for="scheduleService{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Serviço</label>
                                <select id="scheduleService{{ $index }}"  wire:model.defer="scheduleService.{{ $index }}.schedulable_service_id" class="bg-gray-50 w-full border border-gray-300 text-gray-900 text-sm
                                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" required>
                                    <option selected value="">Selecione o serviço</option>
                                    @foreach($schedulableServices as $schedule)
                                        @if(!in_array($schedule->id, $selectedServices) || $schedule->id == $service['schedulable_service_id'])
                                            <option value="{{ $schedule->id }}">{{ $schedule->service }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <label for="scheduleService{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Data</label>
                                <input type="date" id="scheduleService{{ $index }}" wire:model.defer="scheduleService.{{ $index }}.scheduled_date" class="block w-full p-2 text-gray-900 border border-gray-300
                                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </td>
                            <td class="px-2 text-center">
                                <label for="scheduleService{{ $index }}" class="block text-sm font-medium text-gray-800 py-1 mr-2">
                                    Ativar lembrete?
                                </label>
                                <input type="checkbox" id="scheduleService{{ $index }}" wire:model.defer="scheduleService.{{ $index }}.reminder_active" class=" rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="scheduleService{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Observação</label>
                                    <input type="text" id="scheduleService{{ $index }}" wire:model.defer="scheduleService.{{ $index }}.observation" class="block w-full p-2 text-gray-900 border border-gray-300
                                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                                </td>
                                <td>
                                    <label for="scheduleService{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Km atual</label>
                                    <input type="number" id="scheduleService{{ $index }}" wire:model.defer="scheduleService.{{ $index }}.current_mileage" class="block w-full p-2 text-gray-900 border border-gray-300
                                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500"
                                     @if(isset($scheduleService[0]['current_mileage']))
                                           value="{{ intval($scheduleService[0]['current_mileage']) }}"
                                        @endif
                                    >
                                </td>
                                <td>
                                    <label for="scheduleService{{ $index }}" class="block mb- text-sm font-medium text-gray-800 py-1">Km previsto</label>
                                    <input type="number" id="scheduleService{{ $index }}" wire:model.defer="scheduleService.{{ $index }}.expected_mileage" class="block w-full p-2 text-gray-900 border border-gray-300
                                    rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                                </td>
                                <td class="px-1 py-1 v-align-center">
                                    <br />
                                    <button type="button" wire:click="removeScheduleService({{ $index }})" class="text-red-500" title="Remove linha">
                                    <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    </button>
                                </td>
                            </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-right v-align-center">
                            <button type="button" wire:click="addScheduleService" class="mt-2 p-2 text-white rounded" title="adicionar linha">
                                <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </table>
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
    </div>
    <!-- modal de confirmação -->
    @if($confirmModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmModal"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-h-screen overflow-y-auto relative z-10">
                <!-- Close button -->
                <button wire:click="hideConfirmModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Verifique os dados do agendamento</h2>
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
                            <div class="col-span-1">Marca: {{ $vehicle->brand }}</div>
                            <div class="col-span-1">Modelo: {{ $vehicle->model }}</div>
                            <div class="col-span-1">Cor: {{ $vehicle->color }}</div>
                            <div class="col-span-1">Ano: </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 py-1 px-1">
                            <div class="col-span-1">Placa: {{ $vehicle->plate }}</div>
                            <div class="col-span-1">Renavam: {{ $vehicle->renavam }}</div>
                        </div>
                        <div class="px-1 py-1">
                            <table class="w-full">
                                <tr>
                                    <td colspan="6" class="text-center">Agendamentos</td>
                                </tr>
                                <tr>
                                    <td><b>Tipo de serviço</b></td>
                                    <td><b>Data do agendamento</b></td>
                                    <td><b>Km atual</b></td>
                                    <td><b>Km previsto</b></td>
                                    <td><b>Observações</b></td>
                                    <td><b>Lembrete</b></td>
                                </tr>

                                @foreach($scheduleService as $i)
                                <tr>
                                    <td>{{ $schedulableServices->firstWhere('id',$i['schedulable_service_id'])->service }}</td>
                                    <td>{{ \Carbon\Carbon::parse($i['scheduled_date'])->format('d/m/Y') }}</td>
                                    <td>{{ $i['current_mileage'] }}</td>
                                    <td>{{ $i['expected_mileage'] }}</td>
                                    <td>{{ $i['observation'] }}</td>
                                    <td>
                                        @if($i['reminder_active'] == true)
                                            lembrete ativo
                                        @else
                                            <span class="text-red-700">lembrete inativo</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div><hr></div>

                        <div class="text-center py-3">
                            <button wire:click="hideConfirmModal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4
                        focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Corrigir</button>
                            <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- success modal -->
    @if($successModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideSuccessModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
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
                            onclick="window.location.href='#'">Ver</button>
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
