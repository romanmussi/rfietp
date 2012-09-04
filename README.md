rfietp
======

Registro Federal de Instituciones de Educación Técnica

=========================================================================================================
TECNOLOGIAS UTILIZADAS
=========================================================================================================
CakePHP Framework v.1.2
Base de datos PostgreSQL

=========================================================================================================
REQUERIMIENTOS
=========================================================================================================
HTTP Server. Apache con mod_rewrite activado
PHP 4.3.2 o mayor

=========================================================================================================
ENCODINGS
=========================================================================================================
Tanto los archivos como la base de datos tienen encoding ISO-8859-1 (LATIN1)

=========================================================================================================
INSTALACION
=========================================================================================================
1. Hacer checkout del trunk.
2. Crear base de datos en PostgreSQL.
3. Crear en directorio app/config/ archivo database.php con configuración de conexión 
a base de datos y config.email.php con configuración de servidor de email (tomar como base config.email.php.default).
[Para más información dirigirse a http://book.cakephp.org/view/922/Database-Configuration]
4. Dar permisos de escritura a directorio /app/tmp/.
5. Activar aspell en español (solo en Linux) preferentemente, para uso de corrector ortográfico. 
En caso de correr bajo Windows o simplemente no querer utilizar esta funcionalidad se debe setear en 
"false" la variable de configuración "modo_linux" de registro/app/config/core.php
[Para más información dirigirse a trunk/docs/instructivo_aspell.txt]

=========================================================================================================
PERMISOS DE USUARIOS DENTRO DE LA APLICACION
=========================================================================================================
La aplicación utiliza ACL para controlar los permisos de los usuarios en la aplicación.

Ejecutar con permisos de Desarrollador: 
    Desarrollo - Usuarios y permisos - Actualizar controladores
Correr en el mismo panel de Usuarios y permisos los "Scripts de permisos" de las distintas versiones hasta la última.
