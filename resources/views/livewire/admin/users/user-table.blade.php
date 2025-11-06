<div>
    {{-- buscador --}}
        <div class="col-span-2 items-center">
            <input wire:model.live="search" id="search" type="text"
                placeholder="Buscar por nombre, apellido, email, telefono, documento o rol"
                class="px-4 py-2 border border-gray-400 rounded-lg mb-4 w-full" />
        </div>

    {{-- tabla --}}
    <div class="">
        @if ($users->count())
            {{-- TABLE--}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                    {{-- Encabezado de la tabla (color azul claro) --}}
                    <thead
                        class="text-xs text-white uppercase bg-gradient-to-tl from-blue-900 to-gray-900 dark:bg-gray-700 dark:text-gray-400">
                        {{-- Fila del encabezado --}}
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="sortBy('id')" class="uppercase ">
                                        ID
                                    </button>
                                    <x-sort-icon field='id' :sortField="$sortField" :sortAsc="$sortAsc" />
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="sortBy('name')" class="uppercase ">
                                        Nombre
                                    </button>
                                    <x-sort-icon field='name' :sortField="$sortField" :sortAsc="$sortAsc" />
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="sortBy('last_name')" class="uppercase ">
                                        Apellido
                                    </button>
                                    <x-sort-icon field='last_name' :sortField="$sortField" :sortAsc="$sortAsc" />
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipo Doc.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="sortBy('document_number')" class="uppercase ">
                                        N° Doc
                                    </button>
                                    <x-sort-icon field='document_number' :sortField="$sortField" :sortAsc="$sortAsc" />
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="sortBy('email')" class="uppercase">
                                        Email
                                    </button>
                                    <x-sort-icon field='email' :sortField="$sortField" :sortAsc="$sortAsc" />
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Telefono
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Rol
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cambiar Rol
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)

                            @if($user->id != auth()->user()->id) {{-- Excluir al usuario autenticado para que no modifique su
                                propio rol asignado --}}

                                <tr class="odd:bg-white even:bg-blue-50 odd:dark:bg-gray-800 even:dark:bg-blue-950/20 border-b hover:bg-blue-100 transition duration-150 ease-in-out"
                                    wire:key="user-{{ $user->id }}">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$user->id}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        {{$user->name}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        {{$user->last_name}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        @if ($user->document_type == 1)
                                            DNI
                                        @else
                                            CUIL
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        {{$user->document_number}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        {{$user->email}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        {{$user->phone}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                        {{ $user->hasRole('admin') ? 'Administrador' : 'Usuario' }}
                                    </td>
                                    <td class="px-6 py-4 flex flex-col space-y-2">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" name="role-{{ $user->id }}" value="admin"
                                                @checked($user->hasRole('admin'))
                                                wire:change="assignRole({{ $user->id }}, $event.target.value)"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            Administrador
                                        </label>

                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" name="role-{{ $user->id }}" value="user"
                                                @checked($user->hasRole('user'))
                                                wire:change="assignRole({{ $user->id }}, $event.target.value)"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            Usuario
                                        </label>
                                    </td>
                                </tr>

                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
            {{-- PAGINATE--}}
            <div class="mt-4">
                {{$users->links()}}
            </div>

        @else
            {{-- ALERT--}}
            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">¡Alerta!</span> Todavia no hay usuarios registrados.
                </div>
            </div>

        @endif
    </div>
</div>