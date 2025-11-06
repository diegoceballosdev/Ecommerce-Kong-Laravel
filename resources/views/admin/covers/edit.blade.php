<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Portadas',
            'route' => route('admin.covers.index')
        ],
        [
            'name' => 'Editar',
        ],
    ]">

<div class="card">

        <form action="{{route('admin.covers.update', $cover)}}" method="POST" 
        enctype="multipart/form-data">
        {{-- enctype es usado para poder enviar img en este formulario --}}

            @csrf
            @method('PUT')

            <x-validation-errors class="mb-4" />

            {{-- imagen --}}
            <figure class="mb-4 relative">

                <div class="absolute top-3 right-3">

                    <label class="flex items-center px-4 py-2 rounded-lg bg-blue-100 cursor-pointer text-gray-700">

                        <i class="fa-solid fa-camera mr-2"></i>
                        Actualizar Imagen
                        <input type="file" accept="image/*" class="hidden" name="image"
                        onchange="previewImage(event, '#imgPreview')">

                    </label>

                </div>

                <img src="{{$cover->image}}" alt="Portada"
                    class="w-full aspect-[3/1] object-cover object-center" id="imgPreview">

            </figure>

            {{-- titulo --}}
            <div class="mb-4">

                <x-label class="mb-2">
                    Titulo
                </x-label>

                <x-input name="title" class="w-full" placeholder="Ingresa el titulo de la portada"
                    value="{{old('title', $cover->title)}}" />

            </div>

            {{-- fecha de inicio --}}
            <div class="mb-4">

                <x-label class="mb-2">
                    Fecha de inicio
                </x-label>

                <x-input name="start_at" type="date" class="w-full" 
                    value="{{old('start_at', $cover->start_at->format('Y-m-d'))}}" />

            </div>

            {{-- fecha de fin --}}
            <div class="mb-4">

                <x-label class="mb-2">
                    Fecha de finalización (opcional)
                </x-label>

                <x-input name="end_at" type="date" class="w-full" 
                    value="{{old('end_at', $cover->end_at ? $cover->end_at->format('Y-m-d') : '')}}" />

            </div>

            {{-- estado --}}
            <div class="flex mb-4 space-x-2">

                <label>
                    <input type="radio" name="is_active" value="1" :checked="{{$cover->is_active == 1}}" />
                    Activo
                </label>

                <label>
                    <input type="radio" name="is_active" value="0" :checked="{{$cover->is_active == 0}}" />
                    Inactivo
                </label>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Actualizar Portada
                </x-button>
            </div>
        </form>

    </div>

    @push('js')
        <script>
            function previewImage(event, querySelector) {

                //Recuperamos el input que desencadeno la acción
                let input = event.target;

                //Recuperamos la etiqueta img donde cargaremos la imagen
                let imgPreview = document.querySelector(querySelector);

                // Verificamos si existe una imagen seleccionada
                if (!input.files.length) return

                //Recuperamos el archivo subido
                let file = input.files[0];

                //Creamos la url
                let objectURL = URL.createObjectURL(file);

                //Modificamos el atributo src de la etiqueta img
                imgPreview.src = objectURL;

            }
        </script>
    @endpush

</x-admin-layout>