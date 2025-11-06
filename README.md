# Kong Store: Tienda Online de Indumentaria y Equipamiento Policial (Aún en Desarrollo)

El proyecto consiste en el desarrollo de una tienda online diseñada para la comercialización de indumentaria y equipamiento policial. La solución combina tecnologías modernas para garantizar una experiencia de usuario intuitiva, segura y funcional, tanto para los compradores como para los administradores del sistema

# Tecnologías principales
- Frontend: HTML, Tailwindcss, JavaScript y Alpine.js. <br>
- Backend: PHP con Laravel y Livewire para la actualización dinámica de componentes.<br>
- Base de Datos: MySQL gestionada con Migraciones, Seeders y Factories.<br>
- Arquitectura: Modelo - Vista - Controlador (MVC)

<img width="1901" height="908" alt="image" src="https://github.com/user-attachments/assets/8529a039-13eb-4915-bc77-6cb99f88f6d3" />

# Estructura del Sistema
El proyecto se divide en dos grandes módulos: el área de usuario y el área administrativa, diseñados para satisfacer necesidades específicas y diferenciadas.

# 1. Zona de Usuario
Funcionalidades principales:

<img width="2274" height="1700" alt="image" src="https://github.com/user-attachments/assets/513dc120-7ee7-4ed7-9813-b2d352693fcf" />

•	Exploración de Productos: Los usuarios pueden navegar por el catálogo general o visualizar productos por categorías específicas. La página principal muestra nuevos lanzamientos, los más vendidos y recomendaciones.

<img width="1901" height="903" alt="image" src="https://github.com/user-attachments/assets/eec378b1-3989-418e-a4ca-659bc11cf34a" />

•	Detalles del Producto: Cada producto cuenta con una página de detalle que incluye información completa, como nombre, descripción, precio, imágenes y disponibilidad. De acuerdo a la cantidad de Stock se visualizan las etiquetas “Stock alto”, “ultimas unidades” o en caso de no existir stock se visualizara una etiqueta “Sin Stock” (desapareciendo el boton de Añadir al carro).

<img width="1898" height="906" alt="image" src="https://github.com/user-attachments/assets/ba2ab1a8-cf9c-415e-a707-e0b018dba618" />

<img width="1507" height="820" alt="image" src="https://github.com/user-attachments/assets/be24bc62-b613-4414-9fdd-61021a01dee0" />

•	Gestión del Carrito de Compras: Los usuarios registrados pueden añadir productos al carrito, con persistencia entre sesiones. Esto asegura que no se pierdan los datos del carrito incluso si el usuario cierra sesión. Además, dentro del carrito se puede modificar la cantidad de productos a comprar, quitarlos de allí, o vaciar el carrito por completo. Tambien se tiene un control respecto a la cantidad que se desea comprar y el stock existente.

<img width="1397" height="460" alt="image" src="https://github.com/user-attachments/assets/3771bf95-5571-439a-872b-4503c96c242b" />

•	Gestión de Direcciones: El usuario puede crear, editar y eliminar direcciones de envio, y estas direcciones se muestran como tarjetas, donde solo una puede estar seleccionada (por defecto) y esta será la utilizada para el envío.

<img width="1411" height="776" alt="image" src="https://github.com/user-attachments/assets/ebce4d09-d465-4583-b924-755ffa16c0ab" />

•	Procesamiento de Compras: El sistema utiliza Mercado pago con webhooks y tambien niubiz para procesar los pagos. Las compras son seguras y garantizan la confidencialidad de los datos. Cuando la compra finaliza con éxito, se crea una orden de compra con todos los detalles necesarios, se modifica el stock y ventas en la base de datos, y se notifica al comprador via email.

<img width="1397" height="634" alt="image" src="https://github.com/user-attachments/assets/ad7e1f7f-a26b-49be-a59d-e7dd9143ff69" />

<img width="2240" height="614" alt="image" src="https://github.com/user-attachments/assets/82d3de28-9001-44d2-839e-989ca40fd384" />

<img width="1044" height="631" alt="image" src="https://github.com/user-attachments/assets/09d404c5-55dc-4772-83e9-a55fd01ff7d7" />

•	Historial de Compras: Una sección dedicada permite a los usuarios visualizar todas sus compras anteriores. Además, pueden generar un PDF de cada compra, los cuales incluyen el listado de productos adquiridos, precios, fechas y estados de las órdenes.

<img width="1044" height="429" alt="image" src="https://github.com/user-attachments/assets/b8fcd4b6-bf8b-46eb-8028-0fa72a6f9861" />

•	Notificaciones por Correo Electrónico: Al completar una compra, el usuario recibe un correo electrónico con la confirmación y los detalles de la transacción.

<img width="1624" height="867" alt="image" src="https://github.com/user-attachments/assets/665ac816-8ab3-4084-a394-f970b1a6dd54" />

# 2. Zona Administrativa

Funcionalidades principales:

•	Gestión de Usuarios: El administrador puede visualizar los usuarios registrados, asignar roles (User o Admin) y cambiar roles si es necesario. Esto se gestiona mediante la librería Spatie Laravel-permission, que garantiza un control granular sobre los accesos y permisos.

<img width="1879" height="724" alt="image" src="https://github.com/user-attachments/assets/98a6ba14-ee70-4858-961b-29ae31c168fa" />

•	Gestión de Productos: Los administradores tienen la capacidad de:<br>
- Añadir nuevos productos con imágenes y detalles relevantes.<br>
- Editar información de productos existentes.<br>
- Eliminar productos (esto se modificara por una opción de habilitar/deshabilitar producto).
- Tambien hay operaciones CRUD para las familias, categorias y subcategorias, que se muestran en sus respectivas tablas, similares a la tabla de productos.

<img width="1896" height="819" alt="image" src="https://github.com/user-attachments/assets/90babf0d-ec56-45d8-af46-3ffa85aba932" />

•	Gestión de Opciones: Las diferentes opciones y valores de las mismas pueden ser creadas, editadas, y eliminadas. A partir de esto se crean las variantes de productos

<img width="1623" height="723" alt="image" src="https://github.com/user-attachments/assets/cbbf40d0-99f2-491d-a0ea-b73dcb141104" />

•	Gestión de Portadas: Las diferentes portadas pueden ser creadas, editadas, eliminadas, habilitdas o deshabilitadas. Estas se mostraran en el inicio de la tienda como un slider.

<img width="1630" height="435" alt="image" src="https://github.com/user-attachments/assets/501e6280-2f04-4784-bc32-274d60ecbdc2" />

•	Gestión de Órdenes: Los administradores pueden revisar las órdenes de compra realizadas por los usuarios, verificando su estado (pendiente, completada, cancelada). Puenden generar el PDF de la compra o bien ver una tarjeta modal con la información.

<img width="1896" height="840" alt="image" src="https://github.com/user-attachments/assets/7c8fd10e-b270-4120-bf38-c77550075372" />

•	Generación de Reportes Personalizados (PROXIMAMENTE): Los administradores pueden filtrar y ordenar datos de usuarios, productos y ventas para generar reportes PDF. Los filtros incluyen campos específicos, criterios de ordenación y límites de registros.

<img width="1883" height="777" alt="image" src="https://github.com/user-attachments/assets/e818ff66-8a64-45f2-a5b8-2165f6e58eaa" />

•	Estadísticas (PROXIMAMENTE): Se incluye un panel de estadísticas que muestra gráficos y resúmenes relacionados con: Número de usuarios registrados, Productos en inventario, Cantidad de ventas, Ingresos por ventas.

![image](https://github.com/user-attachments/assets/4f70c275-e055-460f-a9f9-a8f6ef009013)

# Gestión de Seguridad
El sistema implementa varias capas de seguridad para proteger los datos de los usuarios y garantizar el acceso autorizado:
1.	Autenticación y Recuperación de Contraseña: Utilizando Laravel Breeze, los usuarios pueden registrarse, iniciar sesión y recuperar sus contraseñas mediante un flujo seguro.

<img width="1114" height="759" alt="image" src="https://github.com/user-attachments/assets/0954fe00-5b50-42e3-90b1-4d1c7699eb50" />

<img width="942" height="1302" alt="image" src="https://github.com/user-attachments/assets/ffd587c8-1d1d-479b-b2a0-5aef788e8bc9" />

2.	Roles y Permisos: Las rutas y acciones están protegidas según los roles asignados:
o	Visitante: Puede explorar productos, pero no interactuar con el carrito ni realizar compras.
o	Usuario Registrado: Tiene acceso al carrito y al flujo completo de compra.
o	Administrador: Accede a todas las funcionalidades, incluyendo la gestión de usuarios, productos y órdenes.

Aquellos que intenten acceder a rutas que no le corresponen, seran informados mediante el respectivo mensaje de error:

![image](https://github.com/user-attachments/assets/ddc04804-829b-4a52-8891-8d1254e18980)

