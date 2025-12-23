# Kong Store: Tienda Online de Indumentaria y Equipamiento Policial

El proyecto consiste en el desarrollo de una tienda online diseñada para la comercialización de indumentaria y equipamiento policial. La solución combina tecnologías modernas para garantizar una experiencia de usuario intuitiva, segura y funcional, tanto para los compradores como para los administradores del sistema

# Tecnologías principales
Frontend / UI: Blade + TailwindCSS | Diseño Responsive | Layouts reutilizables (x-app-layout, x-admin-layout) | Componentes reutilizables (inputs, buttons, tablas, cards). <br>

Backend / Lógica: Laravel (framework principal) | Livewire para componentes dinámicos sin recargar la página | Observers, Middlewares, Enums, Scopes, Eloquent ORM.

Base de Datos: MySQL gestionada con Migraciones, Seeders y Factories.<br>

Arquitectura: Modelo - Vista - Controlador (MVC)

Integraciones: Jetstream, Laravel permission, dompdf, laravel-excel, sweetalert2, swiperjs, sortablejs, smtp.gmail, hardevine/shoppingcart, mercagopago, niubiz y otros.

<img width="1901" height="908" alt="image" src="https://github.com/user-attachments/assets/8529a039-13eb-4915-bc77-6cb99f88f6d3" />

# Estructura del Sistema
El proyecto se divide en dos grandes módulos: el área de usuario y el área administrativa, diseñados para satisfacer necesidades específicas y diferenciadas.

# 1. Zona de Usuario
Funcionalidades principales:

<img width="2272" height="2032" alt="image" src="https://github.com/user-attachments/assets/5cd965eb-376f-469f-b1e4-fb5b28cb77dc" />

•	Exploración de Productos: Los usuarios pueden navegar por el catálogo general o visualizar productos por categorías específicas. La página principal muestra nuevos lanzamientos, los más vendidos y recomendaciones.

<img width="1901" height="877" alt="image" src="https://github.com/user-attachments/assets/64e66230-7d3c-438d-9ffb-6e3c4a06d970" />

•	Detalles del Producto: Cada producto cuenta con una página de detalle que incluye información completa, como nombre, descripción, precio, imágenes y disponibilidad. De acuerdo a la cantidad de Stock se visualizan las etiquetas “Stock alto”, “ultimas unidades” o en caso de no existir stock se visualizara una etiqueta “Sin Stock” (desapareciendo el boton de Añadir al carro).

<img width="1280" height="568" alt="image" src="https://github.com/user-attachments/assets/1700b7c8-dd80-4656-a87e-61653bc3270c" />

•	Gestión del Carrito de Compras: Los usuarios registrados pueden añadir productos al carrito, con persistencia entre sesiones. Esto asegura que no se pierdan los datos del carrito incluso si el usuario cierra sesión. Además, dentro del carrito se puede modificar la cantidad de productos a comprar, quitarlos de allí, o vaciar el carrito por completo. Tambien se tiene un control respecto a la cantidad que se desea comprar y el stock existente.  <br>

Middleware VerifyStock: Actualiza carrito según stock real y estado del producto. Ajusta cantidades y elimina ítems no válidos. Sincroniza precios cuando cambian ofertas o se desactivan.

<img width="1397" height="460" alt="image" src="https://github.com/user-attachments/assets/3771bf95-5571-439a-872b-4503c96c242b" />

•	Gestión de Direcciones: El usuario puede crear, editar y eliminar direcciones de envio, y estas direcciones se muestran como tarjetas, donde solo una puede estar seleccionada (por defecto) y esta será la utilizada para el envío.

<img width="1411" height="776" alt="image" src="https://github.com/user-attachments/assets/ebce4d09-d465-4583-b924-755ffa16c0ab" />

•	Procesamiento de Compras: El sistema utiliza Mercado pago con webhooks y tambien niubiz para procesar los pagos. Las compras son seguras y garantizan la confidencialidad de los datos. Cuando la compra finaliza con éxito, se crea una orden de compra con todos los detalles necesarios, se modifica el stock y ventas en la base de datos, y se notifica al comprador via email.

![Imagen de WhatsApp 2025-12-06 a las 13 26 32_10553589](https://github.com/user-attachments/assets/2385079b-a951-46a8-9439-03394be5fd38)

<img width="2240" height="614" alt="image" src="https://github.com/user-attachments/assets/82d3de28-9001-44d2-839e-989ca40fd384" />

•	Historial de Compras: Una sección dedicada permite a los usuarios visualizar todas sus compras anteriores. Además, pueden generar un PDF de cada compra, los cuales incluyen el listado de productos adquiridos, precios, fechas y estados de las órdenes.

<img width="1211" height="337" alt="image" src="https://github.com/user-attachments/assets/f529cf95-3e2d-46ae-8ccf-c15c0e47a47f" />

•	Notificaciones por Correo Electrónico: Al completar una compra, el usuario recibe un correo electrónico con la confirmación y los detalles de la transacción.

<img width="1624" height="867" alt="image" src="https://github.com/user-attachments/assets/665ac816-8ab3-4084-a394-f970b1a6dd54" />

# 2. Zona Administrativa

Funcionalidades principales:

•	Gestión de Usuarios: El administrador puede visualizar los usuarios registrados, asignar roles (User o Admin) y cambiar roles si es necesario. Esto se gestiona mediante la librería Spatie Laravel-permission, que garantiza un control granular sobre los accesos y permisos.

![Imagen de WhatsApp 2025-12-06 a las 13 30 14_8f9c780b](https://github.com/user-attachments/assets/5b6e19f9-a23d-4d8e-b1ef-7bb57a51f6a3)

•	Gestión de Productos: Los administradores tienen la capacidad de:<br>
- Añadir nuevos productos con imágenes y detalles relevantes.<br>
- Editar información de productos existentes.<br>
- Eliminar productos (esto se modificara por una opción de habilitar/deshabilitar producto).
- Tambien hay operaciones CRUD para las familias, categorias y subcategorias, que se muestran en sus respectivas tablas, similares a la tabla de productos.

![Imagen de WhatsApp 2025-12-06 a las 13 32 09_3399f265](https://github.com/user-attachments/assets/3af29756-dcce-48a6-b2b1-08c855b6af9e)

•	Gestión de Opciones: Las diferentes opciones y valores de las mismas pueden ser creadas, editadas, y eliminadas. A partir de esto se crean las variantes de productos

![Imagen de WhatsApp 2025-12-06 a las 13 33 51_83a47a03](https://github.com/user-attachments/assets/89e43b16-c595-4100-9e62-b487b555c440)

•	Varaintes: en la sección de edicion de productos se pueden gestionar las variantes que tendra el mismo, basado en las opciones y valores creados en la seccion "Opciones". La logica se maneja con el fin de mantener la integridad de los datos luego de que dicho producto/variantes generen ventas.

![Imagen de WhatsApp 2025-12-06 a las 13 51 43_9cbdeb01](https://github.com/user-attachments/assets/6f22ef4e-2f87-4e2f-8700-3c7b58c50d71)
![Imagen de WhatsApp 2025-12-06 a las 13 53 17_ce22fa4a](https://github.com/user-attachments/assets/044cc0a0-a841-47a5-9747-5e60f01382c1)
![Imagen de WhatsApp 2025-12-06 a las 13 53 33_f743adab](https://github.com/user-attachments/assets/4c85334f-17ca-4f6c-9eb9-37a7455513c0)

•	Sistema de descuentos jerárquicos: Descuentos configurables en familia, categoría, subcategoría y producto. El producto calcula su precio final según reglas y fechas. El descuento del producto puede ser heredado o propio (ignorando la herencia).

![Imagen de WhatsApp 2025-12-06 a las 13 52 01_f1329c5d](https://github.com/user-attachments/assets/7194a7b9-abca-4dee-9951-fea400a2adeb)

•	Gestión de Portadas: Las diferentes portadas pueden ser creadas, editadas, eliminadas, habilitdas o deshabilitadas. Estas se mostraran en el inicio de la tienda como un slider.

<img width="1630" height="435" alt="image" src="https://github.com/user-attachments/assets/501e6280-2f04-4784-bc32-274d60ecbdc2" />

•	Gestión de Órdenes: Los administradores pueden revisar las órdenes de compra realizadas por los usuarios, verificando su estado (pendiente, completada, cancelada). Puenden generar el PDF de la compra o bien ver una tarjeta modal con la información.

<img width="1896" height="840" alt="image" src="https://github.com/user-attachments/assets/7c8fd10e-b270-4120-bf38-c77550075372" />

•	Generación de Reportes Personalizados: Los administradores pueden seleccionar campos, filtrar y ordenar datos de usuarios, productos y ventas para generar reportes PDF y EXCEL:

<img width="922" height="1963" alt="image" src="https://github.com/user-attachments/assets/3ec78a52-236e-4674-b6e1-7f9ac29e3552" />

•	Estadísticas: Se incluye un panel de estadísticas que muestra gráficos y resúmenes relacionados con: Número de usuarios registrados, Productos en inventario, Cantidad de ventas, Ingresos por ventas, etc:

<img width="1351" height="651" alt="image" src="https://github.com/user-attachments/assets/b8ba2554-41b7-4d52-a795-d4cb73bfd8be" />

![Imagen de WhatsApp 2025-12-06 a las 13 49 54_9901f755](https://github.com/user-attachments/assets/5e49bb04-c752-47c7-b5e8-27fa311e9c35)
![Imagen de WhatsApp 2025-12-06 a las 13 50 21_2c6460ae](https://github.com/user-attachments/assets/e44d2e1f-fed6-417a-bf24-c111b88db0bc)


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

Se ha tratado de resumir y mostrar el alcance de este proyecto de forma rapida y visual, pero ningun resumen le hace justicia a cada detalle de la logica implementada en el codigo. Este es mi principal proyecto, y en el que más tiempo he trabajado. Y el codigo de la version final no formara parte de este repositorio pues es un sistema altamente comercializable, con un alto valor economico y emocional para mi. Sin embargo una buena parte del codigo, donde el proyecto esta bastante avanzado, sí estara en el repositorio, y son libres de usarlo para aprender o para expandirlo como un sistema propio. <br>

Gracias por tomarse el tiempo de leer este 'readmi'.
