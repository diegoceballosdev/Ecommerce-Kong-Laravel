<div x-data="{
    open: false
}">

    {{-- Mediante alphine.js con x-data asignamos un valor a 'open'
    - si open es falso, no se muestran los div del menu
    - si es verdadero, si se muestran
    - con x-show se asocian los div a la variable 'open'-
    -con x-on:click cambiamos los valores de 'open' para mostrar u ocultar el menu:
    - al hacer click en el boton de las tres rayas, open pasa a ser true y se muestra el menu
    - al hacer click en la 'x' del menu o fuera del menu(fondo negro transpartente), open pasa a ser false y se oculta
    el menu
    --}}

    <header class="bg-gradient-to-tl from-blue-900 to-gray-900">

        <x-container class="px-4 py-2">

            <div class="flex space-x-4 md:space-x-8 items-center justify-between">

                {{-- BOTON MENU --}}
                <button x-on:click="open = true" class="text-3xl text-white">
                    <i class="fas fa-bars text-white"></i>
                </button>

                {{-- LOGO --}}
                <h1 class="text-white">
                    <a href="/" class="inline-flex flex-col items-end">

                        {{-- logo de la tienda --}}
                        <span class="text-2xl md:text-3xl font-semibold">
                            Kong
                        </span>

                        <span class="text-xs">
                            Tienda Online
                        </span>
                    </a>

                </h1>

                {{-- RUTAS --}}
                <a href="{{ route('about') }}" class="text-white">Nosotros</a>
                <a href="{{ route('contact') }}" class="text-white">Contacto</a>
                <a href="{{ route('faq') }}" class="text-white">Ayuda</a>

                {{-- BUSCADOR PANTALLA GRANDE --}}
                <div class="flex-1 hidden md:block">

                    <form wire:submit="searchProduct" wire:keydown.enter.prevent="searchProduct">

                        {{-- El buscador permandece oculto hasta llegar a md en adelante y vuelve recien un bloque --}}
                        <x-input wire:model.live="searchEnter" oninput="search(this.value)" class="w-full"
                            placeholder="Buscar" />

                    </form>
                </div>

                {{-- PERFIL AND CART --}}
                <div class="flex items-center space-x-4 md:space-x-8">

                    {{-- LOGIN - REGISTER - PERFIL - ADMIN - LOGOUT --}}
                    <x-dropdown>

                        <x-slot name="trigger">
                            @auth
                                {{-- boton de usuario con foto EXTRAIDO del navigation-menu de jetstram--}}
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                {{-- boton de usuario --}}
                                <button class="text-2xl md:text-3xl">
                                    <i class="fas fa-user-circle text-white"></i>
                                </button>
                            @endauth
                        </x-slot>

                        <x-slot name="content">

                            {{-- guest muestra contenido segun te logueas o no --}}
                            @guest
                                {{-- Se muestra si aun no se ha iniciado sesion --}}
                                <div class="px-4 py-2">

                                    <div class="flex justify-center">

                                        <a href="{{route('login')}}" class="btn btn-blue">
                                            Iniciar Sesion
                                        </a>

                                    </div>

                                    <p class="text-sm text-center mt-2">
                                        ¿Aun no tienes cuenta?
                                        <a href="{{route('register')}}"
                                            class="text-blue-600 hover:text-blue-400 font-semibold">
                                            Registrate
                                        </a>
                                    </p>

                                </div>
                            @else
                                {{-- Se muestra si ya se ha iniciado sesion --}}
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    Perfil
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                @role('admin')

                                <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                    Panel Administrativo
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                @endrole

                                <x-dropdown-link href="{{ route('my-purchases') }}">
                                    Mis compras
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>

                            @endguest


                        </x-slot>
                    </x-dropdown>

                    {{-- SHOPPING CART --}}
                    <a href="{{route('cart.index')}}" class="relative">
                        <i class="fas fa-shopping-cart text-white text-2xl md:text-3xl">

                        </i>

                        <span
                            class="absolute -top-2 -end-4 inline-flex bg-red-600 text-white text-xs w-5 h-5 items-center justify-center rounded-full"
                            id="cart-count">

                            {{Cart::instance('shopping')->count()}}
                            {{-- uso Cart recuperando la instancia de shopping pues no tengo CART EN MI CONTROLLER
                            NAVIAGTION --}}

                        </span>
                    </a>

                </div>

            </div>

            {{-- BUSCADOR PANTALLA PEQUEÑA --}}
            <div class="my-2 md:hidden">

                <form wire:submit="searchProduct" wire:keydown.enter.prevent="searchProduct">

                    {{-- El buscador permandece oculto despues de llegar a md --}}
                    <x-input wire:model.live="searchEnter" oninput="search(this.value)" class="w-full"
                        placeholder="Buscar" />

                </form>
            </div>

        </x-container>
    </header>

    {{-- FONDO negro transparente cuando se despliega el MENU --}}
    <div x-show="open" x-on:click="open = false" style="display:none"
        class="fixed top-0 left-0 inset-0 bg-black bg-opacity-25 z-10"></div>

    {{-- MENU para mostrar FAMILIAS, CATEGORIAS Y SUBCATEGORIAS --}}
    <div x-show="open" style="display:none" class="fixed top-0 left-0 z-20">

        <div class="flex">

            <div class="w-screen md:w-80 h-screen bg-white">

                {{-- Logo de menu con 'x' para cerrarlo --}}
                <div class="bg-gradient-to-tl from-blue-900 to-gray-900 px-4 py-3 text-white font-semibold ">

                    <div class="flex justify-between items-center">

                        <span class="text-lg">
                            Catalogo
                        </span>

                        <button class="" x-on:click="open = false">
                            <i class="fas fa-times"></i>
                        </button>

                    </div>

                </div>

                {{-- listado de familias --}}
                <div class="h-[calc(100vh-52px)] overflow-auto">

                    <ul>
                        @foreach ($families as $family)

                            {{-- usar el wire:mouseover hace que $family->id tenga el valor de la falily apuntada por el
                            mouse y eso me sirve para el boton "ver todo" de la familia, en el desplegable de categorias--}}
                            <li wire:mouseover="$set('family_id', {{ $family->id }})">
                                {{-- wire:mouseover con $set me permite escuchar el id de la familia sobre la cual esta el
                                mouse --}}
                                <a href="{{route('families.show', $family->id)}}"
                                    class="flex items-center justify-between px-4 py-4 text-gray-700  hover:text-white hover:bg-blue-600">
                                    {{ $family->name }}

                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>

                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="w-80 xl:w-[57rem] pt-[52px] hidden md:block">

                <div class="h-[calc(100vh-52px)] overflow-auto bg-white px-6 py-8">

                    {{-- Muestro nombre de familia seleccionada --}}
                    <div class="mb-8 flex justify-between items-center">

                        <p class="pb-2 border-b-[3px] border-gray-600 uppercase text-xl font-semibold">
                            {{ $this->familyName }}
                        </p>

                        {{-- El boton ver todo lleva a la pagina de la familia seleccionada gracias al wire:mouseover
                        anterior--}}
                        <a href="{{route('families.show', $family_id)}}" class="btn btn-blue">
                            Ver todo
                        </a>

                    </div>

                    {{-- Recorro las categorias y subcategorias de la familia seleccionada --}}
                    <ul class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                        @foreach ($this->categories as $category)

                            <li class="mb-6">
                                <a href="{{route('categories.show', $category)}}"
                                    class="text-lg font-semibold text-blue-700 hover:text-blue-600">
                                    {{ $category->name }}
                                </a>

                                <ul class="mt-2 space-y-2">
                                    {{-- Recorro las subcategorias de la categoria seleccionada --}}
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <a href="{{route('subcategories.show', $subcategory)}}"
                                                class="text-sm text-gray-600 hover:text-blue-600">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                        @endforeach
                    </ul>

                </div>

            </div>

        </div>
    </div>

    @push('js')
        <script>

            Livewire.on('cartUpdated', (count) => {
                document.getElementById('cart-count').innerText = count;
            });

            function search(value) {
                Livewire.dispatch('search', {
                    search: value
                }); // emite el evento 'searching' con el valor del input y sera oido en algun otro componente de livewire (FilterController)
            }
        </script>
    @endpush


</div>