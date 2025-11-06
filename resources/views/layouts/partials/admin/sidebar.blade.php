@php
    $links = [
        [
            'icon' => 'fa-solid fa-house-user',
            'name' => 'Dashboard',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard')
        ],
        [
            'icon' => 'fa-solid fa-chart-line',
            'name' => 'Reportes',
            'route' => route('admin.reports.index'),
            'active' => request()->routeIs('admin.reports.*')
        ],
        [
            'header' => 'Adminitrar página'
        ],
        [
            'icon' => 'fa-solid fa-users',
            'name' => 'Usuarios',
            'route' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*')
        ],
        [
            'icon' => 'fa-solid fa-book-open',
            'name' => 'Familias',
            'route' => route('admin.families.index'),
            'active' => request()->routeIs('admin.families.*')
        ],
        [
            'icon' => 'fa-solid fa-tags',
            'name' => 'Categorias',
            'route' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*')
        ],
        [
            'icon' => 'fa-solid fa-tag',
            'name' => 'Subcategorias',
            'route' => route('admin.subcategories.index'),
            'active' => request()->routeIs('admin.subcategories.*')
        ],
        [
            'icon' => 'fa-solid fa-boxes-packing',
            'name' => 'Productos',
            'route' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*')
        ],
        [
            'icon' => 'fa-solid fa-gear',
            'name' => 'Opciones',
            'route' => route('admin.options.index'),
            'active' => request()->routeIs('admin.options.*')
        ],
        [
            'icon' => 'fa-solid fa-image',
            'name' => 'Portadas',
            'route' => route('admin.covers.index'),
            'active' => request()->routeIs('admin.covers.*')
        ]
        ,
        [
            'header' => 'Ordenes y envíos'
        ],
        [
            'icon' => 'fa-solid fa-box',
            'name' => 'Ordenes',
            'route' => route('admin.orders.index'),
            'active' => request()->routeIs('admin.orders.*')
        ],
        [
            'icon' => 'fa-solid fa-user-tie',
            'name' => 'Conductores',
            'route' => route('admin.drivers.index'),
            'active' => request()->routeIs('admin.drivers.*')
        ],
        [
            'icon' => 'fa-solid fa-truck',
            'name' => 'Envios',
            'route' => route('admin.shipments.index'),
            'active' => request()->routeIs('admin.shipments.*')
        ],
    ]
@endphp

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full 

bg-gradient-to-b from-white via-neutral-50 to-neutral-100

border-r border-gray-200 
    {{-- md:translate-x-0   INDICA QUE HASTA EL ANCHO md EL SIDEBAR DEL LATERAL IZAQUIERDO ESTA OCULTO--}}
    md:translate-x-0
     dark:bg-gray-800 dark:border-gray-700" {{-- He agregado esto para que funcione bien el boton de ocultar y mostrar
    sidebar: --}} :class="{
            'translate-x-0 ease-out': sidebarOpen,
            '-translate-x-full ease-in': !sidebarOpen
        }" aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto
    
    bg-gradient-to-b from-white via-neutral-50 to-neutral-100

     dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            @foreach ($links as $link)

                <li>

                    @isset($link['header'])

                        <div
                            class="p-3 py-2 text-xs font-semibold text-gray-500 uppercase border-b border-gray-200 dark:border-gray-700">
                            {{$link['header']}}
                        </div>

                    @else


                        <a href="{{$link['route']}}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$link['active'] ? 'bg-gray-100' : '' }}">

                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i class="{{$link['icon']}} text-gray-500"></i>
                            </span>

                            <span class="ms-2">
                                {{$link['name']}}
                            </span>
                        </a>

                    @endisset
                </li>

            @endforeach
        </ul>
    </div>
</aside>