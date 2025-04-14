# 📋 Gestor de Tareas en PHP

Este es un proyecto web completo para gestionar tareas, creado con PHP, MySQL y Bootstrap. Permite crear, editar, eliminar y marcar tareas como completadas. Es ideal para prácticas de CRUD, manejo de sesiones y estructura MVC básica en PHP.

## 🚀 Tecnologías Utilizadas


- 🐘 [PHP](https://www.php.net/downloads.php) >= 7.0
- 🐬 [MySQL](https://dev.mysql.com/downloads/) o [XAMPP](https://www.apachefriends.org/index.html) (que incluye MySQL y Apache)
- 🎨 [Bootstrap](https://getbootstrap.com/) (para el diseño de la interfaz)
- 🖥️ InfinityFree (hosting gratuito para tener mi sitio web online)

---

## 📁 Estructura del Proyecto

```bash
/gestor-tareas 
  │ 
  ├── index.php # Página principal con formulario y lista de tareas 
  ├── actualizar_tarea.php # Pagina para editar tareas 
  ├── config.php # Archivo de configuracion para la base de datos
  ├── logout.php # Cierre de sesión 
  ├── captcha.php # Página de acceso o validación inicial 
  ├── login.php # Página de validacion de credenciales para el acceso
  ├── twofa.php # Página de validacion de 2 pasos para mayor seguridad (123456 por defecto)
  │ 
  ├── /css # Archivos de Estilos personalizados 
  │ └── globalstyle.css 
  │ └── style.css
  │
  ├── /database # Archivo de la Base de datos para importar en PHPMyadmin 
  │ └── gestor_tareas.sql
  │── README.md # Documentación del proyecto
```

---

## 🧠 Funcionalidades

- Crear tareas con título y descripción y prioridad (Baja 🟢 - Media 🟡 - Alta 🔴).
- Editar tareas existentes.
- Eliminar tareas.
- Marcar tareas como completadas.
- Diseño responsive con Bootstrap.
- Seguridad básica con sesiones y validación tipo CAPTCHA y 2FA
- Certificado SSL instalado para HTTPS.

---

## 🔧 Requisitos

- Servidor web (Apache recomendado)
- PHP 7.0 o superior
- MySQL
- Editor de código (ej. VSCode)
- Navegador moderno

---

## 🛠️ Instalación

1. **Clona el repositorio**

   ```bash
   git clone https://github.com/tuusuario/gestor-tareas.git

2. Importa la base de datos:

* Abre phpMyAdmin o tu cliente de base de datos.
* Crea una base de datos llamada gestor_tareas.
* Importa el archivo gestor_tareas.sql.

3. Configura la conexión a la base de datos en config.php:
  ```bash
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $dbname = 'gestor_tareas';
```
## 👾 Cómo usar
* Ingresa al sistema desde https://gestor-tareas-wilson.42web.io
*  Resuelve el Captcha, el Login con las credenciales, y el metodo de 2FA
##  Captcha
  ![image](https://github.com/user-attachments/assets/327d8a94-dc90-4597-b94c-86b8e168acad)
## Login
 ![image](https://github.com/user-attachments/assets/2d0b4842-63b0-479a-9a46-e546270f04dd)
## 2FA
 ![image](https://github.com/user-attachments/assets/c6c3e64f-bdc6-4e91-8b9c-973e6cef800d)

## Interfaz Sistema
  ![image](https://github.com/user-attachments/assets/561745e4-827e-47b9-8670-1b2a38530966)



*  Agrega nuevas tareas desde el formulario principal.
*  Puedes editar o eliminar usando los botones junto a cada tarea.
* El botón de cerrar sesión (logout.php) te devuelve a la página de inicio segura.

## 🔐 Seguridad
Se utiliza session_start() y session_destroy() para manejo de usuarios.




<div align="center">
  
  📝 `README.md`  por [Wilsoon77](https://github.com/wilsoon77)
  
  <img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&height=100&section=footer" width="100%" />
</div>

