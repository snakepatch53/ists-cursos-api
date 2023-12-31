# 📝 RESUMEN DE LA APLICACION WEB

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
    <br><br>
</p>

## 📋 REQUISITOS

<ul>
    <li><b>PHP Versión (Mínima):</b> 8.0</li>
</ul>

## 📝 LICENCIA

<p>
    Este proyecto es de código abierto, ¡lo que significa que es completamente libre! 🙌 Puedes usarlo, copiarlo, modificarlo y distribuirlo como desees para tus propios proyectos sin ningún tipo de restricciones. 🚀
    <br><br>
    Nos encanta la idea de que más personas puedan utilizar y mejorar nuestro código. 🤓
    <br><br>
    ¡Gracias por visitarnos y disfruta del código! 😎
    <br><br>
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
