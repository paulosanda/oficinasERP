<div>
    <table class="bg-gray-300 w-full text-sm text-left rtl:text-right text-gray-900 sm:border-r rounded">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nome
                </th>
                <th scope="col" class="px-6 py-3">
                    E-mail
                </th>
                <th scope="col" class="px-6 py-3">
                    Privilégio
                </th>
                <th scope="col" class="px-6 py-3">
                    Situação
                </th>
                <th>
                </th>
                <th>

                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-gray-100 border-b">
                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                        {{ $user->name }}
                    </th>
                    <td class="px-6 py-2">
                        {{ $user->email }}
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                            {{ $role->role }}
                        @endforeach
                    </td>
                    <td>
                        @if($user->enable)
                            liberado
                        @else
                            bloqueado
                        @endif

                    </td>
                    <td>
                        <button wire:click="showModalEditUser({{ $user->id }})" class="flex items-center bg-transparent p-0 text-gray-800 dark:text-white" title="editar usuário">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z"/>
                            </svg>
                        </button>
                    </td>
                    <td>
                        <button wire:click="showConfirmDeleteUser({{ $user->id }})" class="flex items-center bg-transparent p-0 text-gray-800 dark:text-white" title="deletar usuário">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- modal edit user -->
    @if($modalEditUser)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalEditUser"></div>

            <!-- Modal -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/5 h-4/5 max-h-full overflow-y-auto relative z-10">
                <!-- Botão de fechar -->
                <button wire:click="hideModalEditUser" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <form wire:submit.prevent="updateUser">
                    <div class="px-1 py-1">
                        <input type="hidden" wire:model="user_id">
                        <label for="name" class="block mb- text-sm font-medium text-gray-900 py-1">Nome</label>
                        <input type="text" id="name" wire:model="name" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>
                    <div class="px-1 py-1">
                        <label for="email" class="block mb- text-sm font-medium text-gray-900 py-1">E-mail</label>
                        <input type="email" id="email" wire:model="email" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="px-1 py-1">
                        <span class="block mb- text-sm font-medium text-gray-900 py-1">Roles</span>
                        @foreach($roles as $role)
                            <div class="flex items-center mb-2">
                                <input id="role-{{ $role['id'] }}" type="checkbox" wire:model="selectedRoles" value="{{ $role['id'] }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                @if(collect($user->roles)->contains('id', $role['id']))
                                    @checked(TRUE)
                                    @endif
                                />
                                <label for="role-{{ $role['id'] }}" class="ml-2 text-sm text-gray-900">{{ $role['role_description'] }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-1 py-1">
                        <label for="enable" class="block mb- text-sm font-medium text-gray-900 py-1">Status</label>
                        <input type="checkbox" id="enable" wire:model="enable" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        />
                        <label for="status" class="ml-2 text-sm text-gray-900">
                            Ativo
                        </label>
                    </div>
                    <div class="px-1 py-1">
                        <label for="password" class="block mb- text-sm font-medium text-gray-900 py-1">Senha</label>
                        <input type="password" id="password" wire:model="password" class="block w-full p-2 text-gray-900 border border-gray-300
                rounded-lg bg-gray- text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="py-1 px-1">
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
            font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                            <span class="sr-only">save</span>
                        </button></div>
                </form>
            </div>
        </div>
    @endif
    <!-- modal user update success -->
    @if($modalEditUserSuccess)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideModalEditUserSuccess"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideModalEditUserSuccess" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Dados do usuário alterados com sucesso</h2>
                </div>
            </div>
        </div>
    @endif

    <!-- modal confirm delete user -->
    @if($confirmDeleteUser)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="hideConfirmDeleteUser"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative z-10">
                <!-- Close button -->
                <button wire:click="hideConfirmDeleteUser" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Confirmation message -->
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deseja deletar o usuário:</h2>
                    <b>{{ $userDelete->name }}</b>
                </div>
                <div class="py-1 px-1">
                    <form wire:submit.prevent="deleteUser">
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                            font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                        <span class="sr-only">deletar</span>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
