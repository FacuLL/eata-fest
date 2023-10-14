# EATA Fest

EATA Fest es un evento que se realiza anualmente en la Escuela Agropecuaria de Tres Arroyos. Los participantes ganan puntos participando en las distintas actividades. Esta aplicación realizada con Laravel, Inertia, VueJS y Tailwind; permite crear distintos juegos y registrar responsables y participantes, así como también llevar el conteo de puntos en tiempo real utilizando WebSockets.

## ¿Cómo desplegar? (Se requiere PHP, Composer, MySQL y NodeJS instalados)

- Clonar el repo.
- Configurar el archivo .env (copiar .env.example).
- Instalar dependencias de Composer.

  ```console
  composer install
  ```
- Instalar dependencias.
  
  ```console
  npm install
  ```
- Ejecutar migraciones.

  ```console
  php artisan migrate
  ```
- Iniciar servidor NodeJS.

  ```console
  npm run dev
  ```
- Iniciar servidor PHP.

  ```console
  php artisan serve
  ```

## Galería
<p align="center">
    <img src="https://github.com/FacuLL/eata-fest/assets/69525757/2ab7f0f6-6787-464d-9dc6-79ad4b7482e6" />
    <img src="https://github.com/FacuLL/eata-fest/assets/69525757/e3d9cbfe-ddbb-4e72-b2fa-3d33fae41ebe" />
</p>

