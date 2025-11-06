<div>

    <section class="bg-white rounded-lg shadow overflow-hidden">

        <header class="bg-blue-800 px-4 py-2">
            <h2 class="text-white text-lg font-semibold">
                Direcciones de envío guardadas
            </h2>
        </header>

        <div class="p-4">

            {{-- Si se está creando una nueva dirección: --}}
            @if ($newAddress)

                {{-- formulario de nueva direccion --}}

                <x-validation-errors class="mb-4" />

                <div class="grid grid-cols-4 gap-4">

                    {{-- Tipo --}}
                    <div class="col-span-1">

                        <x-select class="w-full" wire:model.live="createAddress.type">
                            <option value="" disabled>
                                Tipo de dirección
                            </option>
                            <option value="1">
                                Domicilio
                            </option>
                            <option value="2">
                                Oficina
                            </option>
                        </x-select>

                    </div>

                    {{-- Direccion --}}
                    <div class="col-span-3">

                        <x-input wire:model.live="createAddress.description" class="w-full"
                            placeholder="Dirección (Calle, número, etc.)" />

                    </div>

                    {{-- Referencia --}}
                    <div class="col-span-2">

                        <x-input wire:model.live="createAddress.reference" class="w-full"
                            placeholder="Referencia (Ej. Cerca de la esquina, etc.)" />

                    </div>

                    {{-- Codigo postal --}}
                    <div class="col-span-2">

                        <x-input wire:model.live="createAddress.postal_code" class="w-full" placeholder="Código postal" />

                    </div>

                    {{-- Localidad --}}
                    <div class="col-span-2">

                        <x-input wire:model.live="createAddress.locality" class="w-full" placeholder="Localidad/Ciudad" />

                    </div>

                    {{-- Provincia --}}
                    <div class="col-span-2">

                        <x-input wire:model.live="createAddress.province" class="w-full" placeholder="Provincia" />

                    </div>

                </div>

                <hr class="my-4">

                <div class=" mb-2" x-data="{ 
                                                receiver: @entangle('createAddress.receiver') ,
                                                {{-- enlaza la variable receiver con createAddress.receiver --}}
                                                receiver_info: @entangle('createAddress.receiver_info') 
                                                {{-- enlaza la variable receiver_info con createAddress.receiver_info --}}
                                            }" x-init="
                                             $watch('receiver', value => {
                                                if(value == 1){
                                                    receiver_info.name = '{{ auth()->user()->name }}';
                                                    receiver_info.last_name = '{{ auth()->user()->last_name }}';
                                                    receiver_info.document_type = '{{ auth()->user()->document_type }}';
                                                    receiver_info.document_number = '{{ auth()->user()->document_number }}';
                                                    receiver_info.phone = '{{ auth()->user()->phone }}';
                                                } else {
                                                        receiver_info.name = '';
                                                        receiver_info.last_name = '';
                                                        receiver_info.document_number = '';
                                                        receiver_info.phone = '';
                                                    }
                                           })
                                            ">

                    <p class="font-semibold mb-2">
                        ¿Quien recibirá el pedido?
                    </p>


                    <div class="flex space-x-4 mb-4">

                        <label class="flex items-center">

                            <input x-model="receiver" type="radio" value="1" class="mr-1">
                            Yo mismo

                        </label>

                        <label class="flex items-center">

                            <input x-model="receiver" type="radio" value="2" class="mr-1">
                            Otra persona

                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">

                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full"
                                placeholder="Nombres" />
                        </div>

                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full"
                                placeholder="Apellidos" />
                        </div>

                        <div class="flex space-x-2">

                            <x-select x-model="receiver_info.document_type">

                                @foreach (App\Enums\TypeOfDocument::cases() as $item)

                                    <option value="{{ $item->value }}">
                                        {{ $item->name }}
                                    </option>

                                @endforeach

                            </x-select>

                            <x-input x-model="receiver_info.document_number" class="w-full"
                                placeholder="Número de documento" />

                        </div>

                        <div>
                            <x-input x-model="receiver_info.phone" class="w-full" placeholder="Teléfono" />
                        </div>

                        <div>
                            <button class="btn btn-outline w-full" wire:click="$set('newAddress', false)">
                                Cancelar
                            </button>
                        </div>

                        <div>
                            <button wire:click="store" class="btn btn-blue w-full">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>

            {{-- Si no se está creando una nueva dirección: --}}
            @else

                @if ($editAddress->id)

                    {{-- formulario de edicion de direccion --}}

                    <x-validation-errors class="mb-4" />

                    <div class="grid grid-cols-4 gap-4">

                        {{-- Tipo --}}
                        <div class="col-span-1">

                            <x-select class="w-full" wire:model.live="editAddress.type">
                                <option value="" disabled>
                                    Tipo de dirección
                                </option>
                                <option value="1">
                                    Domicilio
                                </option>
                                <option value="2">
                                    Oficina
                                </option>
                            </x-select>

                        </div>

                        {{-- Direccion --}}
                        <div class="col-span-3">

                            <x-input wire:model.live="editAddress.description" class="w-full"
                                placeholder="Dirección (Calle, número, etc.)" />

                        </div>

                        {{-- Referencia --}}
                        <div class="col-span-2">

                            <x-input wire:model.live="editAddress.reference" class="w-full"
                                placeholder="Referencia (Ej. Cerca de la esquina, etc.)" />

                        </div>

                        {{-- Codigo postal --}}
                        <div class="col-span-2">

                            <x-input wire:model.live="editAddress.postal_code" class="w-full" placeholder="Código postal" />

                        </div>

                        {{-- Localidad --}}
                        <div class="col-span-2">

                            <x-input wire:model.live="editAddress.locality" class="w-full" placeholder="Localidad/Ciudad" />

                        </div>

                        {{-- Provincia --}}
                        <div class="col-span-2">

                            <x-input wire:model.live="editAddress.province" class="w-full" placeholder="Provincia" />

                        </div>

                    </div>

                    <hr class="my-4">

                    <div class=" mb-2" x-data="{ 
                                                    receiver: @entangle('editAddress.receiver') ,
                                                    {{-- enlaza la variable receiver con createAddress.receiver --}}
                                                    receiver_info: @entangle('editAddress.receiver_info') 
                                                    {{-- enlaza la variable receiver_info con createAddress.receiver_info --}}
                                                }" x-init="
                                                 $watch('receiver', value => {

                                                    if(value == 1){

                                                        receiver_info.name = '{{ auth()->user()->name }}';
                                                        receiver_info.last_name = '{{ auth()->user()->last_name }}';
                                                        receiver_info.document_type = '{{ auth()->user()->document_type }}';
                                                        receiver_info.document_number = '{{ auth()->user()->document_number }}';
                                                        receiver_info.phone = '{{ auth()->user()->phone }}';

                                                    } else {

                                                            receiver_info.name = '';
                                                            receiver_info.last_name = '';
                                                            receiver_info.document_number = '';
                                                            receiver_info.phone = '';
                                                        }
                                               })
                                                ">

                        <p class="font-semibold mb-2">
                            ¿Quien recibirá el pedido?
                        </p>


                        <div class="flex space-x-4 mb-4">

                            <label class="flex items-center">

                                <input x-model="receiver" type="radio" value="1" class="mr-1">
                                Yo mismo

                            </label>

                            <label class="flex items-center">

                                <input x-model="receiver" type="radio" value="2" class="mr-1">
                                Otra persona

                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">

                            <div>
                                <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full"
                                    placeholder="Nombres" />
                            </div>

                            <div>
                                <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full"
                                    placeholder="Apellidos" />
                            </div>

                            <div class="flex space-x-2">

                                <x-select x-model="receiver_info.document_type">

                                    @foreach (App\Enums\TypeOfDocument::cases() as $item)

                                        <option value="{{ $item->value }}">
                                            {{ $item->name }}
                                        </option>

                                    @endforeach

                                </x-select>

                                <x-input x-model="receiver_info.document_number" class="w-full"
                                    placeholder="Número de documento" />

                            </div>

                            <div>
                                <x-input x-model="receiver_info.phone" class="w-full" placeholder="Teléfono" />
                            </div>

                            <div>
                                <button class="btn btn-outline w-full" wire:click="$set('editAddress.id', null)">
                                    Cancelar
                                </button>
                            </div>

                            <div>
                                <button wire:click="update()" class="btn btn-blue w-full">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </div>

                @else

                    {{-- Muestro listado de direcciones si es mayor a cero:--}}
                    @if ($addresses->count())

                        <ul class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            @foreach ($addresses as $address)

                                <li wire:key="addresses-{{ $address->id }}"
                                    class=" {{$address->default ? 'bg-blue-100' : 'bg-white'}} rounded-lg shadow-lg">

                                    <div class="p-4 flex items-center">

                                        <div>
                                            <i class="fa-solid fa-house text-xl text-blue-800"></i>
                                        </div>

                                        {{-- datos mostrados en cada direccion --}}
                                        <div class="flex-1 mx-4 text-sm">

                                            <p class="font-semibold">
                                                {{ $address->type == 1 ? 'Domicilio' : 'Oficina' }}
                                            </p>
                                            <p class="text-gray-700">
                                                {{ $address->description }}
                                            </p>
                                            <p class="text-gray-700">
                                                {{ $address->locality }} - {{ $address->province }}
                                            </p>
                                            <p class="text-gray-700">
                                                CP: {{ $address->postal_code }}
                                            </p>

                                            <p class="font-semibold mt-2">
                                                Persona que recibe:
                                            </p>
                                            <p>
                                                {{ $address->receiver_info['name'] }} {{ $address->receiver_info['last_name'] }}
                                            </p>

                                            {{-- seleccionar y mostrar direccion predeterminada --}}
                                            @if ($address->default)
                                                <p class="text-blue-500 font-semibold mt-2">
                                                    Dirección seleccionada
                                                </p>
                                            @else
                                                <button class="text-blue-500 font-semibold mt-2 hover:text-blue-800 hover:underline"
                                                    wire:click="setDefaultAddress({{ $address->id }})">
                                                    Elegir esta dirección
                                                </button>

                                            @endif
                                        </div>

                                        <div class="text-sm text-gray-800 flex flex-col space-y-4 ">
                                            <button wire:click="edit({{ $address->id }})">
                                                <i class="fa-solid fa-pencil hover:text-blue-600"></i>
                                            </button>
                                            <button wire:click="delete({{ $address->id }})">
                                                <i class="fa-solid fa-trash-can hover:text-red-600"></i>
                                            </button>
                                        </div>

                                    </div>



                                </li>
                            @endforeach
                        </ul>

                        {{-- Si no hay direcciones muestro mensaje: --}}
                    @else
                        <p class="text-center text-gray-500">
                            No tienes direcciones de envío guardadas.
                        </p>
                    @endif

                    <button class="btn btn-outline mt-4 w-full flex items-center justify-center"
                        wire:click="$set('newAddress', true)">
                        Agregar
                        <i class="fa-solid fa-plus ml-2"></i>
                    </button>

                @endif

            @endif



        </div>

    </section>
</div>