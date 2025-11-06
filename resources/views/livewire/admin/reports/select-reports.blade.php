<div>

    <!-- Aviso/ayuda -->
    <div class="mb-6 rounded-xl border border-white/40 bg-white p-4 shadow-sm">
      <p class="text-sm text-gray-600">
        Sugerencia: usa <span class="font-medium">“Ejecutar”</span> para descargar el reporte con filtros por defecto
        (últimos 30 días, todos los estados, etc.) o <span class="font-medium">“Personalizar”</span> para abrir el modal
        de filtros avanzados.
      </p>
    </div>

    <!-- Grid de tarjetas -->
    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
      <!-- Tarjeta: Usuarios -->
      <article class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">
        <div class="mb-4 flex items-start justify-between">
          <div>
            <h2 class="text-lg font-semibold">Usuarios</h2>
            <p class="mt-1 text-sm text-gray-500">Reportes operativos y de gestión.</p>
          </div>
          {{-- <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Scope: usuarios</span> --}}
        </div>

        <ul class="space-y-4">
          <!-- Reporte: Altas por mes -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Altas por mes</h3>
                <p class="text-sm text-gray-500">Nuevos registros por periodo (últimos 12 meses).</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/usuarios-altas-mensuales" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/usuarios-altas-mensuales" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>

          <!-- Reporte: Roles y permisos -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Roles y permisos</h3>
                <p class="text-sm text-gray-500">Distribución de roles y permisos asignados.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/usuarios-roles-permisos" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/usuarios-roles-permisos" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>

          <!-- Reporte: Usuarios inactivos -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Usuarios inactivos</h3>
                <p class="text-sm text-gray-500">Cuentas sin actividad en X días.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/usuarios-inactivos" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/usuarios-inactivos" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>
        </ul>
      </article>

      <!-- Tarjeta: Productos -->
      <article class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">
        <div class="mb-4 flex items-start justify-between">
          <div>
            <h2 class="text-lg font-semibold">Productos</h2>
            <p class="mt-1 text-sm text-gray-500">Stock, rotación y ventas por categoría.</p>
          </div>
          {{-- <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Scope: productos</span> --}}
        </div>

        <ul class="space-y-4">
          <!-- Reporte: Stock bajo -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Stock bajo</h3>
                <p class="text-sm text-gray-500">Productos por debajo del umbral de seguridad.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/productos-stock-bajo" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/productos-stock-bajo" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>

          <!-- Reporte: Top vendidos -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Top vendidos</h3>
                <p class="text-sm text-gray-500">Ranking por unidades y facturación.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/productos-top-vendidos" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/productos-top-vendidos" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>

          <!-- Reporte: Rotación por categoría -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Rotación por categoría</h3>
                <p class="text-sm text-gray-500">Velocidad de rotación e inventario promedio.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/productos-rotacion-categoria" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/productos-rotacion-categoria" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>
        </ul>
      </article>

      <!-- Tarjeta: Ventas -->
      <article class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">
        <div class="mb-4 flex items-start justify-between">
          <div>
            <h2 class="text-lg font-semibold">Ventas</h2>
            <p class="mt-1 text-sm text-gray-500">Ingresos, métodos de pago y ticket promedio.</p>
          </div>
          {{-- <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Scope: ventas</span> --}}
        </div>

        <ul class="space-y-4">
          <!-- Reporte: Ventas por período y método de pago -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Ventas por período y método de pago</h3>
                <p class="text-sm text-gray-500">Comparativo de ingresos por fecha y canal.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/ventas-por-periodo-metodo" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/ventas-por-periodo-metodo" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>

          <!-- Reporte: Ticket promedio -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Ticket promedio</h3>
                <p class="text-sm text-gray-500">Promedio por orden y por cliente.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/ventas-ticket-promedio" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/ventas-ticket-promedio" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>

          <!-- Reporte: Cohortes de clientes -->
          <li class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-medium">Cohortes de clientes</h3>
                <p class="text-sm text-gray-500">Retención y repetición de compra por cohortes.</p>
              </div>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <a href="/reportes/run/ventas-cohortes-clientes" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ejecutar</a>
              <a href="/reportes/customize/ventas-cohortes-clientes" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Personalizar</a>
            </div>
          </li>
        </ul>
      </article>
    </section>

    <!-- CTA secundario -->
    <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm border border-gray-200">
      <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div>
          <h3 class="text-base font-semibold">¿Necesitás algo más específico?</h3>
          <p class="text-sm text-gray-600">Abrí el catálogo completo para ver todos los reportes disponibles o crear una plantilla nueva.</p>
        </div>
        <div class="flex gap-3">
          <a href="/reportes" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Ver catálogo</a>
          <a href="/reportes/nuevo" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Crear reporte</a>
        </div>
      </div>
    </div>


  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>


</div>