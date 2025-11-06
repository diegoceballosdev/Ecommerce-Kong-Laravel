<div>
    <form wire:submit="addFeature" class="flex space-x-2">

        <div class="flex-1">

            <x-label class="mb-2">
                Valor
            </x-label>    

            @switch($option->type)      

                @case(1)
                    <x-input 
                        wire:model="newFeature.value"
                        class="w-full" 
                        placeholder="Ingrese el valor de la opción" />
                    @break    

                    @case(2)
                    <div class="border border-gray-300 h-[42px] rounded-md flex items-center px-3 justify-between">       

                        {{-- el operador "?:" va a verifiar que la variable este definida y que tenga almacenado un valor no nulo. Si cumple esa condicion se muestra el contenido de $newOption['features'][$index]['value'], caso contrario pide 'Seleccionar un color --}}

                        {{
                            $newFeature['value'] ?: 'Seleccione un color'
                        }}  

                        <input type="color"
                            wire:model.live="newFeature.value">
                    </div>          
                    @break

                @default

            @endswitch
        </div>

        <div class="flex-1">
            <x-label class="mb-2">
                Descripción
            </x-label>

            <x-input 
            wire:model="newFeature.description"
            class="w-full" 
            placeholder="Ingrese una descripción" />
        </div>

        <div class="pt-7">
            <x-button>
                Agregar
            </x-button>
        </div>

    </form>
</div>