<nav>
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul class="flex flex-col p-4 md:p-0 mt-4 md:space-x-8
                rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center text-gray-800 hover:text-gray-200">
                        Usuários
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg></button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{ route('company.user.index') }}" class="block px-4 py-2 hover:bg-gray-100">Todos</a>
                            </li>
                            <li>
                                <a href="{{ route('web.company.user.create') }}" class="block px-4 py-2 hover:bg-gray-100">Cadastrar</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Para usar</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0">Services</a>
                </li>
                <li>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800">Sair</button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
