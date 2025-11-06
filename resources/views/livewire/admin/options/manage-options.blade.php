<div>

    <section class="rounded-lg bg-white shadow-xl dark:bg-gray-800">

    {{-- Encabezado del Panel con color azul/gris --}}
    <header class="border-b border-blue-100 dark:border-blue-900 px-6 py-4 bg-blue-50/50 dark:bg-gray-700/50">

        <div class="flex justify-between items-center">

            <h1 class="text-xl font-bold text-gray-700 dark:text-gray-200">
                Opciones
            </h1>

            {{-- Botón (estilo azul consistente) --}}
            <x-button 
            class="bg-blue-600 hover:bg-blue-700 active:bg-blue-900 focus:border-blue-900 focus:ring-blue-300"
            wire:click="$set('newOption.openModal', true)"> 
                Agregar nuevo
            </x-button>
        </div>
    </header>

    <div class="p-6">

        <div class="space-y-6">

            @foreach ($options as $option)
                {{-- Contenedor de Opción (borde azul claro/gris, fondo sutil) --}}
                <div class="p-6 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50/30 dark:bg-gray-700/30 relative"
                    wire.key="option-{{$option->id}}">

                    {{-- Etiqueta del título (fondo blanco/oscuro, borde azul/gris) --}}
                    <div class="absolute -top-3 px-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-blue-300 dark:border-blue-700 flex items-center">

                        {{-- Icono de eliminar en color rojo --}}
                        <button class="mr-1 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 transition" 
                        onclick="confirmDelete({{$option->id}}, 'option')">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            {{$option->name}}
                        </span>
                    </div>

                    {{-- Valores --}}
                    <div class="flex flex-wrap pt-4 mb-4">

                        @foreach ($option->features as $feature)
                        
                            @switch($option->type)

                                @case(1)
                                {{-- texto --}}

                                {{-- Etiqueta de valor de texto (Badge azul) --}}
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mb-2 me-2 px-2.5 py-0.5 pr-1.5 rounded-full dark:bg-blue-900/50 dark:text-blue-200 border border-blue-400/50 flex items-center">

                                    {{$feature->description}}

                                    {{-- Botón de eliminar valor (ícono de cierre) --}}
                                    <button class="ml-0.5 text-blue-600 hover:text-red-600 dark:text-blue-400 dark:hover:text-red-400 transition" 
                                    onclick="confirmDelete({{$feature->id}}, 'feature')">
                                        <i class="fa-solid fa-xmark text-xs" ></i>
                                    </button>

                                </span>
                                @break

                                @case(2)
                                {{-- color --}}
                                <div class="relative mb-2 me-2">
                                    <span 
                                    class="inline-block h-6 w-6 shadow-md rounded-full border-2 border-gray-400 mr-4"
                                    style="background-color: {{$feature->value}}">
                                    </span>

                                    {{-- Botón de eliminar color (rojo) --}}
                                    <button class="absolute z-10 -top-2 left-3 rounded-full bg-red-500 hover:bg-red-700 h-4 w-4 flex justify-center items-center transition"
                                    onclick="confirmDelete({{$feature->id}}, 'feature')">
                                        <i class="fa-solid fa-xmark text-xs text-white"></i>
                                    </button>
                                </div>
                                @break

                                @default

                            @endswitch

                        @endforeach
                    </div>

                    <div>
                        @livewire('admin.options.add-new-feature', ['option' => $option], key('add-new-feature-'.$option->id))
                        {{-- Mandamos llave key de seguimiento para cada $option --}}
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>

    {{-- Modal --}}
    <x-dialog-modal wire:model="newOption.openModal">

        <x-slot name="title">
            Crear nueva opción
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4"/>

            {{-- Nombre - Tipo --}}
            <div class="grid grid-cols-2 gap-6 mb-4">

                <div>
                    <x-label class="mb-2">
                        Nombre
                    </x-label>

                    <x-input 
                    wire:model='newOption.name'
                    class="w-full" 
                    placeholder="Ingrese Tamaño, Color" />

                </div>

                <div>
                    <x-label class="mb-2">
                        Tipo
                    </x-label>

                    <x-select 
                    class="w-full"
                    wire:model.live='newOption.type'>

                        <option value="1">Texto</option>
                        <option value="2">Color</option>

                    </x-select>
                </div>

            </div>

            {{-- Valores Title--}}
            <div class="flex items-center mb-4">
                <hr class="flex-1">
                <span class="mx-4">
                    Valores
                </span>
                <hr class="flex-1">
            </div>

             {{-- Inputs de Valor y Descripcion- --}}
            <div class="mb-4 space-y-4">
                @foreach ($newOption->features as $index => $feature)

                    {{-- usamos $index para acceder a la llave de cada feature --}}
                    <div class="p-6 rounded-lg border border-gray-200 relative"
                        wire:key="features-{{$index}}">
                        {{-- hemos agregado la llave wire:key="featues" para hacer seguimiento y poder editar|eliminar los valores agregados con el boton "Agregar valor" --}}

                        <div class="absolute -top-3 px-3 bg-white">
                            <button wire:click="removeFeature({{$index}})">
                                <i class="fa-solid fa-trash-can text-red-400 hover:text-red-600"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-6">

                            <div>
                            <x-label class="mb-2">
                                Valor
                            </x-label>

                            @switch($newOption->type)

                                @case(1)
                                    <x-input 
                                        wire:model="newOption.features.{{$index}}.value"
                                        class="w-full" 
                                        placeholder="Ingrese el valor de la opción" />
                                    @break

                                @case(2)
                                <div class="border border-gray-300 h-[42px] rounded-md flex items-center px-3 justify-between">

                                    {{-- el operador "?:" va a verifiar que la variable este definida y que tenga almacenado un valor no nulo. Si cumple esa condicion se muestra el contenido de $newOption['features'][$index]['value'], caso contrario pide 'Seleccionar un color--}}
                                    {{$newOption->features[$index]['value'] ?: 'Seleccione un color'}}

                                    <input type="color"
                                        wire:model.live="newOption.features.{{$index}}.value">
                                </div>

                                    @break
                                @default
                                    
                            @endswitch
                            </div>


                            <div>
                            <x-label class="mb-2">
                                Descripción
                            </x-label>

                            <x-input 
                            wire:model="newOption.features.{{$index}}.description"
                            class="w-full" 
                            placeholder="Ingrese una descripción" />
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Agregar nueva caja de valores --}}
            <div class="flex justify-end">
                <x-button
                wire:click="addFeature">
                    Agregar valor
                </x-button>
            </div>

        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-blue" wire:click="addOption">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    @push('js')
    <script>
        function confirmDelete(id, type) {
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
                        switch (type) {
                            case 'feature':
                                @this.call('deleteFeature',id);
                                break;
                            case 'option':
                                @this.call('deleteOption',id);
                                break;
                            default:
                                break;
                        }
                    }
                });
            }
        </script>
    @endpush

</div>