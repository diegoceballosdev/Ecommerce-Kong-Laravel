<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Conductores',
            'route' => route('admin.drivers.index')
        ],
        [
            'name' => $driver->user->name,
        ],
    ]">

    <div class="card">

        <form action="{{route('admin.drivers.update', $driver)}}" method="POST">

            @csrf

            @method('PUT')

            {{-- usuario --}}
            <div class="mb-4">
                <x-label class="mb-2">
                    Usuario
                </x-label>
                <x-select class="w-full" name="user_id">

                    <option value="" selected disabled>
                        Selecciona un usuario
                    </option>

                    @foreach($users as $user)

                        <option value="{{$user->id}}"
                            @selected($user->id == old('user_id', $driver->user_id))>
                            {{$user->name}}
                        </option>

                    @endforeach
                </x-select>
            </div>

            {{-- vehiculo --}}
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <x-label class="mb-2">
                        Tipo de unidad
                    </x-label>

                    <x-select class="w-full" name="type">

                        <option value="" selected disabled>
                            Selecciona un tipo de unidad
                        </option>

                        <option value="1" @selected(old('type', $driver->type) == 1)>
                            Moto
                        </option>

                        <option value="2" @selected(old('type', $driver->type) == 2)>
                            Bicicleta
                        </option>

                    </x-select>

                </div>

                {{-- placa --}}
                <div>

                    <x-label class="mb-2">
                        Placa
                    </x-label>
                    <x-input class="w-full" placeholder="Ingresa la placa del vehiculo" name="plate_number"
                        value="{{ old('plate_number', $driver->plate_number) }}" />

                </div>

            </div>

            <div class="flex justify-end">

                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>

                <x-button class="ml-2">
                    Actualizar
                </x-button>
            </div>
        </form>

    </div>

    <form action="{{route('admin.drivers.destroy', $driver)}}" method="POST" id="delete-form">

        @csrf

        @method('DELETE')

    </form>

    @push('js')
        <script>
            function confirmDelete() {
                Swal.fire({
                    title: "Estas seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar!",
                    cancelButtonText: "Cancelar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
                });
            }
        </script>
    @endpush

</x-admin-layout>