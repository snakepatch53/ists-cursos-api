# 📝 RESUMEN DE LA APLICACION WEB

<div style="text-align:center">
    <img src="./public/img/logo.png" style="width:200px;aspect-ratio:1/1;object-fit:cover;background:white;border-radius:50%;margin:50px" />
</div>

## 📋 DATOS GENERALES

<ul>
    <li><b>Cliente:</b> ✅ Instituto Superior Tecnológico Sucua</li>
    <li><b>Estado:</b> 🎉 Producción</li>
    <li><b>Version:</b> 🚀 1.0.0</li>
    <li><b>Nombre:</b> 😎 Cursos ISTS - API</li>
</ul>

## 📋 DESCRIPCION

<p>
    Este proyect es una api rest para el manejo de cursos, estudiantes, docentes y usuarios del instituto superior tecnologico sucua.
    <br>
    Esta desarrollada bajo las tecnologias web principales: <b>PHP, LARAVEL, MYSQL</b>
    <br>
    El lenguaje de programacion principal es <b>PHP</b> y el gestor de base de datos es <b>MYSQL</b>
    <br>
    El framework de desarrollo es <b>LARAVEL</b> y el ORM es <b>ELOQUENT</b>
    <br>
    Tambien es importante recalcar que se trabajo con la arquitectura <b>MVC</b> y se utilizo el patron de diseño <b>REPOSITORY</b>
</p>

## 📋 REQUISITOS

<ul>
    <li><b>PHP Versión (Mínima):</b> 8.0</li>
</ul>

## 📝 LICENCIA

<p>
    Este proyecto tiene derechos reservados para `Instituto Superior Tecnológico Sucua` y `Ideasoft` y no puede ser utilizado por terceros sin previa autorización.
    <br>
    Tenemos una clausula que te permitira usar nuestro proyecto en caso de ser por fines educativos, pero no podras usarlo para fines comerciales.
    <br>
    En caso de querer hecharle un vistazo al codigo, para inspirarte o aprender, puedes hacerlo sin problemas, pero no podras usarlo para fines comerciales.
    <br>
    ¡Gracias por visitarnos y disfruta del código! 😎
    <br>
</p>

# 📦 DOCUMENTACION DE INSTALACION

## 📄 VARIABLES DE ENTORNO

Crea el archivo <b><i>.env</i></b> en base al archivo <b><i>.env.example</i></b> y configuralo. Principalmente las variables de entorno que se deben configurar son:

```env
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE={{YOUR_DB_NAME}}
    DB_USERNAME={{YOUR_DB_USER}}
    DB_PASSWORD={{YOUR_DB_PASS}}
```

## 🐬 MYSQL

Crea la base de datos

```sql
  CREATE DATABASE {{YOUR_DB_NAME}};
```

-   Asegurate de que el nombre de la base de datos sea el mismo que el que usas en el archivo .env
-   Si estas en CPANEL tendras que crearla con ayuda de la interfaz grafica.

### 🛠 CONFIGURACION

Para migrar las tablas de la base de datos puedes ejecutar el siguiente comando

```bash
  php artisan migrate
```

Suponiendo que CPANEL no te da acceso a una consola, puedes habilitarte el servicio en CPANEL de REMOTE MYSQL y desde tu proyecto en local puedes conectarte a la base de datos remota. Con eso puedes ejecutar el comando de migracion desde tu consola local.
Posteriormente puedes deshabilitar el servicio de REMOTE MYSQL para que no se conecte desde cualquier lugar.

## 🪶 APACHE

#### 🛠 En caso de que tu proyecto ya este funcionando con un dominio y quieras usar _https_, puedes agregar esta configuracion en _htaccess_

```htaccess
  RewriteEngine On
  RewriteCond %{HTTPS} !=on
  RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE]
  Header always set Content-Security-Policy "upgrade-insecure-requests;"
```

## CONFIGURACION DE VERSION DE PHP

En caso de que tu _CPANEL_ o tu entorno _LOCAL_ no tenga la version de _PHP_ minimamente _8.0_ debes asegurarte de instalarla y activarla.
