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
                Celular
            </th>
            <th scope="col" class="px-6 py-3">

            </th>
            <th>

            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr class="bg-gray-100 border-b">
                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap flex items-center">
                    {{ $customer->name }}
                    </th>
                    <td class="px-6 py-2">
                        {{ $customer->email }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $customer->cellphone }}
                    </td>
                    <td class="px-6 py-2">
                        <button wire:click="editCustomer({{ $customer->id }})" title="editar cliente">
                        <svg class="w-6 h-6 text-gray-800 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z"/>
                        </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
