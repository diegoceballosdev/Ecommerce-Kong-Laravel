<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Portadas',
        ]
    ]">

    <x-slot name='action'>
        <a class="btn btn-blue" href="{{route('admin.covers.create')}}">
            Agregar Nuevo
        </a>
    </x-slot>

    @if ($covers->count())
        <ul class="space-y-4" id="covers">
            @foreach ($covers as $cover)
                {{-- Tarjeta de Portada: fondo blanco/gris claro, borde sutil celeste y hover para indicar que es movible --}}
                <li data-id="{{$cover->id}}"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden lg:flex cursor-move 
                               border border-sky-200 dark:border-sky-900 hover:shadow-xl hover:bg-sky-50 dark:hover:bg-gray-700 transition duration-200 ease-in-out">

                    <img src="{{$cover->image}}" alt="" {{-- Imagen con esquinas redondeadas --}}
                        class="w-full lg:w-64 aspect-[3/1] object-cover object-center rounded-l-xl">

                    {{-- Contenedor de contenido: texto oscuro/claro --}}
                    <div
                        class="p-4 lg:flex-1 lg:flex lg:justify-between lg:items-center space-y-3 lg:space-y-0 text-gray-800 dark:text-gray-300">

                        <div>
                            <h1 class="font-bold text-lg dark:text-white">
                                {{$cover->title}}
                            </h1>

                            <p>
                                @if ($cover->is_active)
                                    {{-- Badge Activo en verde (color positivo) --}}
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900/50 dark:text-green-300">
                                        Activo
                                    </span>
                                @else
                                    {{-- Badge Inactivo en rojo (color negativo) --}}
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900/50 dark:text-red-300">
                                        Inactivo
                                    </span>

                                @endif
                            </p>
                        </div>

                        <div>
                            {{-- Etiquetas con énfasis (color oscuro/claro) --}}
                            <p class="font-semibold text-gray-700 dark:text-gray-200">
                                Feacha de inicio
                            </p>
                            <p class="text-sm">
                                {{$cover->start_at->format('d/m/Y')}}
                            </p>
                        </div>

                        <div>
                            {{-- Etiquetas con énfasis (color oscuro/claro) --}}
                            <p class="font-semibold text-gray-700 dark:text-gray-200">
                                Feacha de finalización
                            </p>
                            <p class="text-sm">
                                {{$cover->end_at ? $cover->end_at->format('d/m/Y') : "No definida"}}
                            </p>
                        </div>

                        <div>
                            {{-- Botón "Editar" en celeste/azul (color de acción) --}}
                            <a href="{{route('admin.covers.edit', $cover)}}"
                                class="inline-flex items-center btn btn-blue text-sm">
                                Editar
                            </a>
                        </div>


                    </div>
                </li>

            @endforeach
        </ul>
    @else
        {{-- ALERT (azul consistente) --}}
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">¡Alerta!</span> Todavia no hay portadas registradas.
            </div>
        </div>

    @endif

    {{-- Script para hacer sortable las portadas --}}

    @push('js')

        {{-- importamos sortablejs --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"></script>

        <script>
            //Definimos el elemento a hacer sortable con el id='covers' de mi etiqueta <ul id='covers'></ul>
            new Sortable(covers, {
                animation: 150,
                ghostClass: 'bg-blue-100',
                store: {

                    // Guardar el orden de los elementos
                    set: (sortable) => {

                        const sorts = sortable.toArray(); //Obtenemos un array con los ids de los elementos en el nuevo orden

                        axios.post('{{route('api.sort.covers')}}', {

                            //Hacemos una petición a la ruta que hemos creado en api.php
                            sorts: sorts //Enviamos el array con los ids en el nuevo orden

                        }).catch((error) => {
                            console.log(error);
                        });
                    },

                }
            });
        </script>
    @endpush

</x-admin-layout>