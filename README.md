¡Claro! Aquí tienes un archivo `README.md` que resume toda la conversación y proporciona una documentación general para la página que hemos estado viendo. El README cubre desde la estructura de la aplicación hasta instrucciones de despliegue y uso.

---

# README.md

## Descripción del Proyecto

Este proyecto es una aplicación web desarrollada en **PHP** que permite la **gestión de usuarios** y **documentos**. Los usuarios pueden subir, editar y visualizar documentos (como archivos PDF, DOCX, PPTX) en un entorno seguro, mientras que los administradores tienen la capacidad de gestionar los usuarios y sus roles.

## Estructura del Proyecto

El proyecto está dividido en varias carpetas y archivos para organizar los diferentes componentes de la aplicación:

```
/Desktop/documentos2
│
├── /assets                 # Archivos estáticos (CSS, JS, imágenes)
│   ├── /css                # Hojas de estilo (CSS)
│   ├── /images             # Imágenes estáticas
│   └── /js                 # Archivos JavaScript
│
├── /documents              # Carpeta donde se almacenan los documentos subidos
├── /includes               # Archivos incluidos en varias páginas (conexión DB, exportación de usuarios)
├── /login                  # Archivos relacionados con el inicio de sesión y registro
├── /views                  # Archivos de las vistas (Dashboard, gestión de usuarios, edición)
├── /test_connection.php    # Prueba de conexión a la base de datos
├── index.php               # Página principal
└── .htaccess               # Configuración de acceso y redirección
```

## Funcionalidades Principales

1. **Autenticación de Usuario:**
   - Los usuarios pueden iniciar sesión utilizando un nombre de usuario y una contraseña.
   - Los administradores tienen un panel de control para gestionar otros usuarios y roles.

2. **Gestión de Documentos:**
   - Los usuarios pueden subir documentos (PDF, DOCX, PPTX) a través de un formulario de carga.
   - Los administradores pueden ver y gestionar los documentos subidos.
   - Se incluyen funciones para renombrar documentos y visualizar los archivos PDF.

3. **Gestión de Usuarios:**
   - Los administradores pueden agregar, editar y eliminar usuarios.
   - Los administradores pueden asignar roles (usuario o administrador) y géneros.

4. **Vistas y Funcionalidad de Modales:**
   - Modal para agregar nuevos usuarios.
   - Modal para la visualización de documentos en formato PDF.

---

## Requisitos

1. **PHP 7.4 o superior**.
2. **Servidor web** (Apache o Nginx).
3. **MySQL o MariaDB**.
4. **Dependencias de PHP**: PDO, soporte para carga de archivos.

---

## Instalación y Despliegue

### 1. **Preparación del Entorno Local**

Antes de subir el proyecto al servidor, realiza las siguientes configuraciones en tu entorno local:

1. Clona o descarga el proyecto.
2. Configura la base de datos y ajusta las credenciales en el archivo `includes/db.php`.
3. Instala las dependencias necesarias en el servidor.

### 2. **Configuración del Servidor de Producción**

1. **Sube los Archivos al Servidor:**
   - Sube todos los archivos a tu servidor (puedes usar **FTP**, **SFTP**, o cualquier herramienta de despliegue que prefieras).

2. **Configura el Servidor Web (Apache o Nginx):**
   - Si usas Apache, asegúrate de habilitar los módulos de **mod_rewrite** y configurar correctamente el archivo `.htaccess` para gestionar las URLs.
   
3. **Base de Datos:**
   - Crea la base de datos en MySQL o MariaDB.
   - Importa las tablas necesarias (puedes crear las tablas manualmente o mediante un script de instalación si existe).

4. **Configura los Permisos de Archivos:**
   - Asegúrate de que las carpetas de documentos tengan permisos adecuados para ser accesibles y editables por el servidor web.

5. **Dependencias y Extensiones:**
   - Verifica que PHP tenga las extensiones necesarias habilitadas (por ejemplo, **PDO**, **GD** para la manipulación de imágenes, etc.).

6. **Configuración del Archivo `.htaccess`** (si usas Apache):
   ```apache
   RewriteEngine On
   RewriteRule ^(.*)$ index.php/$1 [L]
   ```

### 3. **Pruebas Finales**

- Asegúrate de que todas las funciones estén operativas, como el inicio de sesión, la carga de documentos y la visualización en el modal.
- Verifica que los documentos se pueden cargar correctamente y que el tamaño de archivo no excede el límite establecido.
  
---

## Documentación de Funcionalidades

### 1. **Dashboard del Usuario**
   - Los usuarios pueden ver los documentos que han subido.
   - Los administradores pueden ver y gestionar todos los documentos subidos.

### 2. **Gestión de Usuarios**
   - Los administradores tienen un panel para agregar, editar y eliminar usuarios.
   - Se puede asignar un **rol** (usuario o administrador) y un **género** a cada usuario.
   
### 3. **Subir y Gestionar Documentos**
   - Los usuarios pueden subir documentos a la plataforma.
   - Solo se permiten archivos con las extensiones: `.pdf`, `.docx`, `.pptx`.
   - El tamaño máximo de cada archivo es de 2 MB.

### 4. **Ver Documentos**
   - Los documentos PDF se pueden visualizar en un modal mediante el visor PDF.js.

---

## Archivos Importantes

- **`index.php`**: Página de inicio de la aplicación.
- **`login/login.php`**: Página de inicio de sesión.
- **`includes/db.php`**: Configuración de la conexión a la base de datos.
- **`views/dashboard.php`**: Dashboard del usuario.
- **`views/user_management.php`**: Gestión de usuarios por parte del administrador.
- **`views/edit_user.php`**: Edición de datos de un usuario.

---

## Seguridad

1. **Protección de Contraseñas**: Las contraseñas de los usuarios se almacenan de forma segura utilizando `password_hash()` y `password_verify()` en PHP.
2. **Prevención de Inyecciones SQL**: Se utilizan declaraciones preparadas con PDO para evitar vulnerabilidades de inyección SQL.
3. **Protección de Sesiones**: Se utiliza `session_start()` para gestionar las sesiones de los usuarios y mantener la seguridad de las páginas restringidas.

---

## Licencia

Este proyecto se distribuye bajo la licencia MIT. Puedes usar, modificar y distribuir el código según los términos de la licencia.

---

¡Y eso es todo! Este es el resumen completo de la conversación, organizado en un `README.md` para tu proyecto. Si necesitas más detalles o algún ajuste, no dudes en indicarlo.
