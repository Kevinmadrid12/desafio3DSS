# Gestión de Academia

Sistema de gestión académica simple desarrollado con Laravel, enfocado en el seguimiento de estudiantes, tutores, grupos, asistencia y aspectos disciplinarios/académicos.

## Características Principales

*   **Autenticación y Roles:** Sistema de inicio de sesión con roles diferenciados (Administrador, Tutor, Estudiante).
*   **Dashboard de Administrador:**
    *   Estadísticas generales (total de estudiantes, tutores, grupos).
    *   Porcentaje de asistencia mensual.
    *   Listado de grupos con mayor ausentismo.
    *   Gestión completa de Grupos (CRUD): creación, asignación de tutores y estudiantes.
    *   Generación de reportes de estudiantes en PDF por trimestre.
    *   Listado de Estudiantes y Tutores.
    *   Exportación de datos del dashboard a PDF.
*   **Dashboard de Tutor:**
    *   Estadísticas personalizadas (estudiantes a cargo, grupos asignados, porcentaje de asistencia de sus grupos).
    *   Listado de grupos asignados con detalle de estudiantes.
    *   **Toma de Asistencia:** Funcionalidad para pasar lista los **sábados de 8:00 AM a 11:00 AM**.
    *   **Asignación de Aspectos:** Durante la toma de asistencia, el tutor puede asignar aspectos positivos y a mejorar a los estudiantes.
*   **Perfil de Estudiante:**
    *   Visualización de información personal.
    *   Historial de asistencia.
    *   Aspectos asignados.
    *   Indicador de "semáforo" de disciplina/rendimiento basado en asistencias y aspectos.
*   **Perfil de Usuario:** Los usuarios pueden ver y editar su información básica de perfil (nombre, email, contraseña).

## Tecnologías Utilizadas

*   **Backend:** PHP, Laravel Framework
*   **Frontend:** Blade (plantillas de Laravel), HTML, CSS, JavaScript.
    *   Bootstrap (para el diseño general y dashboards).
    *   Tailwind CSS (utilizado en la vista de toma de asistencia).
*   **Base de Datos:** Mysql
*   **Otros:** Composer (gestor de dependencias PHP), NPM (gestor de paquetes Node.js, si se usa para assets).

## Prerrequisitos

*   PHP >= 8.1 (o la versión especificada en tu `composer.json`)
*   Composer
*   Node.js y NPM (si estás compilando assets con Laravel Mix/Vite)
*   Servidor web (Nginx, Apache)
*   Base de datos compatible con Laravel (ej. MySQL, PostgreSQL)

## Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://tu-repositorio-url/gestion-academia.git
    cd gestion-academia
    ```

2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```

3.  **Instalar dependencias de Node.js (si aplica):**
    ```bash
    npm install
    npm run dev # o build, según tu configuración de assets
    ```

4.  **Configurar el archivo de entorno:**
    *   Copia `.env.example` a `.env`:
        ```bash
        cp .env.example .env
        ```
    *   Edita el archivo `.env` y configura los detalles de tu base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.) y otras configuraciones necesarias (como `APP_URL`).

5.  **Generar la clave de la aplicación:**
    ```bash
    php artisan key:generate
    ```

6.  **Ejecutar las migraciones de la base de datos:**
    ```bash
    php artisan migrate
    ```

7.  **Poblar la base de datos con datos de prueba (Seeders):**
    ```bash
    php artisan db:seed
    ```
    Esto creará usuarios de ejemplo (ver más abajo) y otros datos necesarios para el funcionamiento inicial.

8.  **Configurar el enlace simbólico para el almacenamiento (si usas `storage/app/public`):**
    ```bash
    php artisan storage:link
    ```

## Uso

1.  **Iniciar el servidor de desarrollo de Laravel:**
    ```bash
    php artisan serve
    ```
    La aplicación estará disponible por defecto en `http://127.0.0.1:8000`.

2.  **Credenciales de Acceso (creadas por los Seeders):**
    *   **Administrador:**
        *   Email: `admin@academia.edu`
        *   Contraseña: `Admin123!`
    *   **Tutor de Ejemplo:**
        *   Email: `tutor.ejemplo@academia.edu`
        *   Contraseña: `tutorejemplo123`
    *   **Estudiante de Ejemplo:**
        *   Email: `estudiante.ejemplo@academia.edu`
        *   Contraseña: `estudianteejemplo123`

## Funcionalidades Clave y Notas

*   **Toma de Asistencia Restringida:** Los tutores solo pueden acceder a la funcionalidad de toma de asistencia los días sábado entre las 8:00 AM y las 11:00 AM. Fuera de este horario, el acceso estará bloqueado.
*   **Middleware de Roles:** Se utilizan middlewares (`can:admin`, `can:tutor`) para proteger las rutas y funcionalidades según el rol del usuario.

## Contribuciones

Las contribuciones son bienvenidas. Si deseas contribuir, por favor:
1.  Haz un Fork del proyecto.
2.  Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
3.  Realiza tus cambios y haz commit (`git commit -am 'Añade nueva funcionalidad'`).
4.  Sube tus cambios a la rama (`git push origin feature/nueva-funcionalidad`).
5.  Abre un Pull Request.

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles (si decides añadir uno).
