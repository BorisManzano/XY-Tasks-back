# XY Tasks

Aplicación para administración de tareas de los empleados de una empresa por parte del administrador.

## Requisitos

-   PHP >= 8.1
-   Composer
-   Laravel >= 10
-   MySQL

## Instalación

1. **Clona este repositorio en tu máquina local:**

    ```bash
    git clone https://github.com/tu-usuario/tu-proyecto.git
    ```

2. **Instala las dependencias del proyecto utilizando Composer:**

    ```bash
    cd tu-proyecto
    composer install
    ```

3. **Copia el archivo `.env.example` y renómbralo a `.env`. Luego, actualiza las variables de entorno con la configuración correspondiente para tu entorno local. Asegúrate de incluir los datos para la base de datos:**

    ```bash
    cp .env.example .env
    ```

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=XYTasksDB
    DB_USERNAME=tu_usuario_db
    DB_PASSWORD=tu_contrasena_db
    ```

    Reemplaza `XYTasksDB` con el nombre de la base de datos que deseas crear. Luego, crea una base de datos nueva y un usuario con permisos de lectura y escritura para la base de datos.

4. **Genera una nueva clave de aplicación:**

    ```bash
    php artisan key:generate
    ```

5. **Ejecuta las migraciones de la base de datos para crear las tablas necesarias:**

    ```bash
    php artisan migrate
    ```

6. **Opcional: Ejecuta los seeders para poblar la base de datos con datos de prueba:**

    ```bash
    php artisan db:seed
    ```

7. **Para almacenar las imágenes, debes correr el siguiente comando para crear un enlace simbólico al directorio de almacenamiento:**

    ```bash
    php artisan storage:link
    ```

8. **Inicia el servidor de desarrollo:**

    ```bash
    php artisan serve
    ```

9. **Genial! la aplicación ya esta en funcionamiento.**

## Configuración de Correo Electrónico

La aplicación ha sido configurada y probada para enviar correos electrónicos utilizando Mailtrap, un servicio de pruebas de correo electrónico. A continuación, se detallan los pasos para configurar y probar el envío de correos electrónicos:

1. **Crea una cuenta en Mailtrap:**

    - Ve a [Mailtrap](https://mailtrap.io/) y regístrate para obtener una cuenta gratuita si aún no tienes una.

2. **Configura las credenciales de correo en el archivo `.env`:**

    - Abre el archivo `.env` en tu proyecto Laravel.
    - Actualiza las siguientes variables de entorno con las credenciales proporcionadas por Mailtrap:

    ```dotenv
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=tu_username_de_mailtrap
    MAIL_PASSWORD=tu_password_de_mailtrap
    MAIL_ENCRYPTION=tls
    ```

3. **Prueba el envío de correos electrónicos:**
    - Después de configurar las credenciales de correo, puedes probar el envío de correos electrónicos desde la aplicación.
    - Envía correos electrónicos desde cualquier parte de tu aplicación que requiera la funcionalidad de correo electrónico.
    - Verifica en tu bandeja de entrada de Mailtrap que los correos electrónicos hayan sido recibidos correctamente.

Recuerda que Mailtrap proporciona un entorno de pruebas seguro para el desarrollo y la depuración de envíos de correo electrónico sin enviar correos electrónicos reales a los destinatarios.

## Seeders y Usuario Superadmin

Al ejecutar los seeders, se creará un usuario superadmin con el correo `admin@gmail.com` y la contraseña `admin123`. Este usuario tendrá acceso a todas las funcionalidades de la aplicación como administrador.

Para ejecutar los seeders, utiliza el siguiente comando:

```bash
php artisan db:seed
```

## Uso

### Autenticación

#### Registro de nuevo usuario

-   **URL:** `/register`
-   **Método:** `POST`
-   **Parámetros:**
    -   `name` (string): El nombre del nuevo usuario.
    -   `email` (string): El correo electrónico del nuevo usuario.
    -   `role` (string): El rol del nuevo usuario (employee o super_admin).

#### Recuperar contraseña

-   **URL:** `/recoverPassword`
-   **Método:** `POST`
-   **Parámetros:**
    -   `email` (string): El correo electrónico del usuario registrado.

#### Actualizar contraseña

-   **URL:** `/updatePassword`
-   **Método:** `PUT`
-   **Parámetros:**
    -   `token` (string): El token de recuperación de contraseña.
    -   `email` (string): El correo electrónico del usuario.
    -   `password` (string): La nueva contraseña del usuario.

#### Iniciar sesión

-   **URL:** `/login`
-   **Método:** `POST`
-   **Parámetros:**
    -   `email` (string): El correo electrónico del usuario.
    -   `password` (string): La contraseña del usuario.

#### Cerrar sesión

-   **URL:** `/logout`
-   **Método:** `POST`

#### Obtener información del usuario autenticado

-   **URL:** `/me`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

#### Obtener todos los empleados

-   **URL:** `/allEmployees`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

#### Obtener todas las tareas de todos los empleados

-   **URL:** `/allEmployeesTasks`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

#### Obtener todas las tareas de un empleado específico

-   **URL:** `/employeeTasks`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

### Tareas

#### Crear nueva tarea

-   **URL:** `/newTask`
-   **Método:** `POST`
-   **Encabezado:** `Authorization: Bearer {token}`
-   **Parámetros:**
    -   `user_id` (integer): El ID del usuario al que se asignará la tarea.
    -   `task` (string): El título de la tarea.
    -   `details` (string): Los detalles de la tarea.

#### Eliminar tarea

-   **URL:** `/deleteTask`
-   **Método:** `DELETE`
-   **Encabezado:** `Authorization: Bearer {token}`
-   **Parámetros:**
    -   `id` (integer): El ID de la tarea que se eliminará.

#### Cambiar empleado asignado a una tarea

-   **URL:** `/changeEmployee/{id}`
-   **Método:** `PUT`
-   **Encabezado:** `Authorization: Bearer {token}`
-   **Parámetros:**
    -   `user_id` (integer): El ID del nuevo usuario asignado a la tarea.

#### Cambiar estado de la tarea

-   **URL:** `/changeStatus`
-   **Método:** `PUT`
-   **Encabezado:** `Authorization: Bearer {token}`
-   **Parámetros:**
    -   `id` (integer): El ID de la tarea.
    -   `status` (string): El nuevo estado de la tarea ("Pendiente", "En proceso", "Bloqueado", "Completado").

### Comentarios

#### Crear nuevo comentario

-   **URL:** `/newComment`
-   **Método:** `POST`
-   **Encabezado:** `Authorization: Bearer {token}`
-   **Parámetros:**
    -   `task_id` (integer): El ID de la tarea a la que se agregará el comentario.
    -   `comment` (string): El texto del comentario.
    -   `files` (archivo): Archivos adjuntos (opcional).

#### Eliminar comentario

-   **URL:** `/deleteComment/{comment}`
-   **Método:** `DELETE`
-   **Encabezado:** `Authorization: Bearer {token}`

#### Obtener todos los comentarios de una tarea

-   **URL:** `/allComments/{task_id}`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

#### Adjuntar archivo a un comentario

-   **URL:** `/comments/{comment}/attachments`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

#### Descargar archivo adjunto

-   **URL:** `/attachments/download/{attachment}`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`

### Reportes

#### Generar reporte PDF

-   **URL:** `/reports/generate`
-   **Método:** `GET`
-   **Encabezado:** `Authorization: Bearer {token}`
-   **Parámetros:**

    -   `start_date` (fecha): Fecha de inicio del período para el informe (Formato: YYYY-MM-DD).
    -   `end_date` (fecha): Fecha de fin del período para el informe (Formato: YYYY-MM-DD).

### ¡Felicidades!

Has completado la configuración e instalación de XY Tasks. Ahora estás listo para comenzar a administrar las tareas de los empleados de tu empresa de manera eficiente. Si tienes alguna pregunta o encuentras algún problema, no dudes en ponerte en contacto con Boris Manzano para que pueda ayudarte.

¡Gracias y espero que disfrutes de XY Tasks!
