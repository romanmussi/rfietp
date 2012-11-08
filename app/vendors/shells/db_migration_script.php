<?php  
App::import('Component','Auth'); 
App::import('Component','Acl'); 
App::import('Core', 'Controller');

define("NOMBRE_ARCHIVO", "../app/config/sql/scripts_migracion/script_migracion_v%s.sql");

class DbMigrationScriptShell extends Shell { 
    var $uses = array('Aco');
    
    function main() { 
        
        $this->Auth = new AuthComponent(null);
        
        $this->out('Migracion de base de datos RFIETP');
        $this->hr();
        $this->out('Introduzca la version a la que desea migrar (por ej: 1.7 o "q" para salir):'); 
        $user_version = trim($this->in(''));
        
        if ($user_version != 'q') {
            $this->out('Chequeando version de base de datos...'); 

            $db = ConnectionManager::getInstance();
            $conn = $db->getDataSource('default');
            $res = $conn->query('SELECT * FROM version ORDER BY id DESC;');
            $current_version = $res[0][0]['version'];
            
            $this->out($current_version);
            
            if (version_compare($user_version, $current_version) == 1) {
                // actualiza version => ejecuta script en BD
                if (file_exists(sprintf(NOMBRE_ARCHIVO, $user_version))) {
                    // ejecuta script sql
                    $sql = file_get_contents(sprintf(NOMBRE_ARCHIVO, $user_version), true);
                    $conn->query($sql);
                    // actualiza version de BD
                    $conn->query("INSERT INTO version (version, fecha) VALUES ('".$user_version."', NOW())");
                    $this->out("La base de datos se ha actualizado a la version ".$user_version);
                }
                else {
                    $this->out("El archivo ".sprintf(NOMBRE_ARCHIVO, $user_version)." no existe. Proceso abortado!");
                }
            }
            else {
                $this->out("La versión actual ".$current_version. " es mayor que ".$user_version);
            }
        }      
        
        $this->out("");
        $this->hr();
    }
    
    
} 
?>