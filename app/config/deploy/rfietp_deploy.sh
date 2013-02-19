#!/bin/sh
START_HERE="/var/www/rfietp/"
SHELL_DIR=$START_HERE"app"
BD_SCRIPTS_DIR=$START_HERE"app/config/sql/scripts_migracion/"

cd $START_HERE

# primero hacer git pull (actualizar del repositorio)
echo "\ngit pull de $START_HERE\n"
 
git pull

echo "\ngit pull finalizado.\n"

# ejecuta shell de cakephp para correr script de actualizacion de BD
echo "\nDesea ejecutar un script de actualización de base de datos? [S/n]"
read RTA

if [ $RTA = "S" -o $RTA = "s" ]; then
        cd $SHELL_DIR
        cake db_migration_script
fi

# ejecuta shell de cakephp que actualiza ACOs
echo "\nDesea actualizar los ACL ACOs de la aplicacion? [S/n]"
read RTA

if [ $RTA = "S" -o $RTA = "s" ]; then
	cd $SHELL_DIR
	cake deploy
fi
