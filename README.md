# Empleados App (PHP)

CRUD básico de empleados usando **Programación Orientada a Objetos (POO)**, validación en **cliente (JS)** y **servidor (PHP)**, y vistas con **Bootstrap 5**.  
Incluye el esquema SQL y datos de ejemplo versionados como parte del proyecto.  
El desarrollo se realizó utilizando **XAMPP** como entorno local y **Visual Studio Code** como editor.

---

## 🚀 Requisitos

- **PHP 8.1+** (compatible con PDO para conexión a base de datos)
- **MySQL** (para el almacenamiento de empleados, áreas y roles)
- **HTML, CSS y JavaScript** (implícitos para las vistas y validaciones en cliente)
- **XAMPP** u otro stack LAMP/WAMP para entorno local
- Navegador moderno (Chrome, Edge, Firefox, Brave)

---

## 🔧 Configuración de PHP en XAMPP

Es necesario habilitar la extensión **pdo_mysql** para que la conexión a MySQL funcione correctamente.

1. Abre el archivo `php.ini` en la carpeta `xampp/php/`.
2. Busca la línea:
   ```ini
   ;extension=pdo_mysql
3. Quita el ; al inicio para descomentarla
4. Guardar el archivo
5. Reinicia Apache desde el panel de control de XAMPP.

--- 

## 📂 Estructura del proyecto

- public/                # Front controller (index.php)
- src/
  - Config/Database.php  # Conexión PDO a MySQL
  - Controllers/         # EmpleadoControlador.php
  - Repositories/        # EmpleadoRepositorio, AreaRepositorio, - - RolRepositorio
  - Services/            # EmpleadoServicio (validaciones del dominio)
- views/
  - empleado/            # lista.php, formulario.php (Bootstrap)
- sql/
  - schema.sql           # Esquema de base de datos
  - seed.sql             # Datos iniciales de prueba

---

## 🗄️ Configuración de base de datos

1. Inicia XAMPP y asegúrate de que Apache y MySQL estén activos.

2. Edita src/Config/Database.php con tus credenciales locales de MySQL (por defecto en XAMPP suele ser usuario root sin contraseña):

// src/Config/Database.php (ejemplo para XAMPP)
- $host = '127.0.0.1';
- $db   = 'empleados_db';
- $user = 'root';
- $pass = '';
- $charset = 'utf8mb4';

3. Crea la base de datos e importa el esquema y los datos:

CREATE DATABASE IF NOT EXISTS empleados_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE empleados_db;

4. Importa los archivos:

mysql -u root empleados_db < sql/schema.sql
mysql -u root empleados_db < sql/seed.sql

---

## ▶️ Ejecutar la aplicación 

1. Clonar repositorio
https://github.com/FelipePerez99/empleados-app.git
cd empleados-app

2. Inicia XAMPP y verifica que Apache/MySQL estén corriendo.

3. Abre una terminal en la raíz del proyecto.

4. Lanza el servidor embebido de PHP:
php -S localhost:8000 -t public

5. Abre en tu navegador:
http://localhost:8000

--- 

## ✨ Funcionalidad

Listar empleados (Nombre, Email, Sexo, Área, Boletín) con acciones Modificar y Eliminar.

Crear / Editar empleados:

- Campos: Text (nombre, correo), Textarea (descripción), Select (área), Radio (sexo), Checkbox (boletín y roles).

Validaciones:

- Cliente (JS): nombre, correo, sexo, área y descripción antes de enviar.

- Servidor (PHP): validador en EmpleadoServicio.

Mensajes:

-  Flash de éxito o error tras crear, modificar o eliminar.

- Confirmación antes de eliminar.

Manejo de errores:

- try/catch global en index.php → HTTP 500 si hay errores de ejecución.

---

## 🔗 Rutas principales
Acción	       URL
- Listar	     GET /?accion=listar
- Crear	       GET /?accion=nuevo
- Editar	     GET /?accion=editar&id=ID
- Guardar	     POST /?accion=guardar
- Eliminar     GET /?accion=eliminar&id=ID

---

## 📦 Tecnologías usadas

- XAMPP (Apache + PHP + MySQL)

- PHP 8.1+ (POO y namespaces)

- PDO para acceso a MySQL

- Bootstrap 5 + Bootstrap Icons

- HTML5 + JavaScript para validaciones

- Visual Studio Code como editor principal

- Autoloader PSR-4 custom para cargar clases

---

## 📝 Notas técnicas

- Proyecto basado en Front Controller (public/index.php) que actúa como router.

- Inyección de dependencias: el controlador recibe instancias de Database, repositorios y servicio.

- SQL versionado: los scripts sql/schema.sql y sql/seed.sql permiten reproducir el entorno en cualquier equipo.

- Código con tipado estricto (declare(strict_types=1)).