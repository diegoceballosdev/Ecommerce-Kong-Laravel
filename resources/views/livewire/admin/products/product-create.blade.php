<div>
    <form wire:submit="store">

        <x-validation-errors class="mb-4" />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">

            <div class="col-span-1">

                {{-- sku --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Código sku
                    </x-label>
                    <x-input class="w-full" placeholder="Ingresa el sku del producto" wire:model="product.sku" />
                </div>

                {{-- name --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Nombre
                    </x-label>
                    <x-input class="w-full" placeholder="Ingresa el nombre del producto" wire:model="product.name" />
                </div>

                {{-- price --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Precio
                    </x-label>
                    <x-input type="number" step="0.01" class="w-full" placeholder="Ingresa el precio del producto"
                        wire:model="product.price" />
                </div>

                {{-- family --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Familia
                    </x-label>

                    <x-select class="w-full" wire:model.live="family_id">

                        <option value="" disabled>
                            Seleccione una familia
                        </option>

                        @foreach ($families as $family)
                            <option value="{{$family->id}}">
                                {{$family->name}}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                {{-- category --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Categoria
                    </x-label>

                    <x-select name="category_id" class="w-full" wire:model.live="category_id">

                        <option value="">
                            Seleccione una categoria
                        </option>

                        @foreach ($this->categories as $category)
                            <option value="{{$category->id}}">
                                {{$category->name}}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                {{-- subcategory --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Subcategoria
                    </x-label>

                    <x-select name="subcategory_id" class="w-full" wire:model.live="product.subcategory_id">

                        <option value="">
                            Seleccione una subcategoria
                        </option>

                        @foreach ($this->subcategories as $subcategory)
                            <option value="{{$subcategory->id}}">
                                {{$subcategory->name}}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                {{-- description --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Descripción
                    </x-label>
                    <x-textarea wire:model="product.description" class="w-full" rows=6
                        placeholder="Ingresa la descripción del producto">
                    </x-textarea>
                </div>
            </div>

            <div class="col-span-1">

                {{-- image --}}
                <div class="mb-4">

                    <figure class="relative">

                        <div class="absolute top-8 right-8">

                            <label
                                class="flex items-center px-4 py-2 rounded-lg bg-blue-100 cursor-pointer text-gray-700">

                                <i class="fa-solid fa-camera mr-2"></i>
                                Actualizar Imagen
                                <input type="file" accept="image/*" class="hidden" wire:model.live="image">

                            </label>

                        </div>

                        <img src="{{ $image ? $image->temporaryUrl() : asset('img/no-image.png')}}"
                            class="aspect-[1/1] object-cover object-center w-full" accept="image/*">

                    </figure>
                </div>

            </div>
        </div>

        <div class="flex justify-end">
            <x-button>
                Guardar
            </x-button>
        </div>

    </form>

</div>