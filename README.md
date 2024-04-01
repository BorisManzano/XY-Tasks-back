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

9. **Genial la aplicación ya esta en funcionamiento.**
