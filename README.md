import os

# Contenido del archivo README.md personalizado para el proyecto del usuario
readme_content = """
# 🚀 Sistema de Chat en Tiempo Real - TFG

Este proyecto es una aplicación de chat profesional construida con un stack moderno enfocado en la reactividad, el rendimiento y la escalabilidad. Implementa una arquitectura distribuida para el manejo de mensajes mediante WebSockets y colas de trabajo.

## 🛠 Stack Tecnológico

* **Backend:** [Laravel 11](https://laravel.com/) (PHP)
* **Frontend:** [Vue.js 3](https://vuejs.org/) (Composition API)
* **Puente:** [Inertia.js](https://inertiajs.com/) (Navegación SPA con SSR)
* **Tiempo Real:** [Laravel Echo](https://laravel.com/docs/11.x/broadcasting) + [Pusher](https://pusher.com/)
* **Estilos:** [Tailwind CSS](https://tailwindcss.com/)
* **Base de Datos:** MySQL / PostgreSQL

---

## 🧐 ¿De qué trata el proyecto?

La aplicación permite a los usuarios autenticados comunicarse en tiempo real. No es solo un chat simple; cuenta con una arquitectura robusta diseñada para soportar carga de tráfico:

1.  **Comunicación Bidireccional:** Uso de WebSockets para recibir mensajes al instante sin refrescar la página.
2.  **Arquitectura de Colas (Workers):** Para evitar bloqueos en el servidor, el envío de eventos al WebSocket se maneja de forma asíncrona.
3.  **Hydration & SSR:** Renderizado del lado del servidor para una carga inicial ultra rápida, con hidratación posterior en el cliente para mantener la interactividad.
4.  **Prevención de Eco:** Sincronización inteligente entre Axios y Echo para evitar mensajes duplicados en la interfaz del emisor.

---

## 👨‍🍳 La Arquitectura del "Cocinero" (Sistema de Colas)

Para este proyecto se ha implementado un sistema de **Workers**. Imagina un restaurante:
* **El Camarero (Laravel):** Recibe tu mensaje, lo guarda en la base de datos y te da un "ticket" (Job).
* **La Barra (Cola/Database):** Donde se acumulan los tickets en orden.
* **El Cocinero (Worker):** Un proceso independiente que va cogiendo tickets de la barra y los "cocina" (envía el mensaje a Pusher).

Esto permite que, si hay 1000 mensajes a la vez, el servidor nunca se bloquee, ya que el Worker los procesa de fondo de manera eficiente.

---

## 💻 Instalación y Configuración

Sigue estos pasos para ejecutar el proyecto en tu ordenador:

### 1. Clonar el repositorio
```bash
git clone [https://github.com/tu-usuario/nombre-del-repo.git](https://github.com/tu-usuario/nombre-del-repo.git)
cd nombre-del-repo


Intslacion de dependencias servidor :
composer install

Instalacion de depencencias cliente:
npm install

Configuracion del .env

Use sus siguientes credenciales aqui
DB_DATABASE=nombre_tu_db
QUEUE_CONNECTION=database
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=tu_id
PUSHER_APP_KEY=tu_key
PUSHER_APP_SECRET=tu_secret
PUSHER_APP_CLUSTER=eu

Configura se base de datos y claves
php artisan key:generate
php artisan migrate
php artisan queue:table # Crea la tabla necesaria para los tickets (cola)
php artisan migrate


Ejecucion del entorno

Terminal 1:
php artisan serve

Terminal 2:
npm run dev

Terminal 3:
php artisan queue:work


Samu - Desarrollo Integral  - https://github.com/SamuelBonillaBaquero/
