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
                    <x-input class="w-full" placeholder="Ingresa el sku del producto" wire:model="productEdit.sku" />
                </div>

                {{-- name --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Nombre
                    </x-label>
                    <x-input class="w-full" placeholder="Ingresa el nombre del producto"
                        wire:model="productEdit.name" />
                </div>

                {{-- price --}}
                <div class="mb-4">
                    <x-label class="mb-2">
                        Precio
                    </x-label>
                    <x-input type="number" step="0.01" class="w-full" placeholder="Ingresa el precio del producto"
                        wire:model="productEdit.price" />
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

                    <x-select name="subcategory_id" class="w-full" wire:model.live="productEdit.subcategory_id">

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
                    <x-textarea wire:model="productEdit.description" class="w-full" rows=6
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
                                <input type="file" class="hidden" wire:model.live="image">

                            </label>

                        </div>

                        {{-- aqui hay cambios respecto al product-create, reemplazando la funcion 'asset()' por el
                        acceso a la llave 'image_path' del producEdit: --}}
                        <img src="{{ $image ? $image->temporaryUrl() : Storage::url($productEdit['image_path'])}}"
                            class="aspect-[1/1] w-full object-cover object-center" accept="image/*">

                    </figure>

                </div>
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

    <form action="{{route('admin.products.destroy', $product)}}" method="POST" id="delete-form">

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
</div>