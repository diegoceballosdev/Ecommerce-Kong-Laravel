<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Repartidores',
            'route' => route('admin.drivers.index')
        ],
        [
            'name' => 'Nuevo',
        ],
    ]">

    <div class="card">

        <form action="{{route('admin.drivers.store')}}" method="POST">

            @csrf

            <x-validation-errors class="mb-4" />

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
                            @selected($user->id == old('user_id'))>
                            {{$user->name}}
                        </option>

                    @endforeach
                </x-select>
            </div>


            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <x-label class="mb-2">
                        Tipo de unidad
                    </x-label>

                    <x-select class="w-full" name="type">

                        <option value="" selected disabled>
                            Selecciona un tipo de unidad
                        </option>

                        <option value="1" @selected(old('type') == 1)>
                            Moto
                        </option>

                        <option value="2" @selected(old('type') == 2)>
                            Bicicleta
                        </option>

                    </x-select>

                </div>

                <div>

                    <x-label class="mb-2">
                        Placa
                    </x-label>
                    <x-input class="w-full" placeholder="Ingresa la placa del vehiculo" name="plate_number" value="{{ old('plate_number') }}" />

                </div>

            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </form>

    </div>

</x-admin-layout>