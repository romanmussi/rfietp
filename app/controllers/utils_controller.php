<?php
/*
 * Utils generales para la app
 *
*/
set_time_limit(60*60*0.5); // media hora de ejecucion limite

class UtilsController extends AppController {

    var $name = 'Utils';
    var $uses = array('Departamento', 'Instit', 'Orientacion', 'Localidad', 'Plan', 'Sector', 'Subsector', 'Tipoinstit', 'Titulo', 'User');
    var $helpers = array('Html','Form','Ajax');


    function convertTablesToLower() {
        setlocale(LC_ALL, 'es_AR');
        
        $this->autoRender = false;

        $this->Plan->recursive = -1;
        $planes = $this->Plan->find('all', array(
                                'fields' => array('Plan.id', 'Plan.norma')
        ));

        $this->Instit->recursive = -1;
        $instits = $this->Instit->find('all', array(
                                'fields' => array('id',
                                                  'direccion',
                                    ),
                                'order' => array('id')
        ));
/*
        $this->Orientacion->recursive = -1;
        $orientaciones = $this->Orientacion->find('all', array(
                                'fields' => array('Orientacion.id', 'Orientacion.name')
        ));

        $this->Localidad->recursive = -1;
        $localidades = $this->Localidad->find('all', array(
                                'fields' => array('Localidad.id', 'Localidad.name')
        ));

        $this->Plan->recursive = -1;
        $planes = $this->Plan->find('all', array(
                                'fields' => array('Plan.id', 'Plan.nombre', 'Plan.perfil')
        ));

        $this->Sector->recursive = -1;
        $sectores = $this->Sector->find('all', array(
                                'fields' => array('Sector.id', 'Sector.name')
        ));

        $this->Subsector->recursive = -1;
        $subsectores = $this->Subsector->find('all', array(
                                'fields' => array('Subsector.id', 'Subsector.name')
        ));

        $this->Tipoinstit->recursive = -1;
        $tipoinstits = $this->Tipoinstit->find('all', array(
                                'fields' => array('Tipoinstit.id', 'Tipoinstit.name'),
                                'conditions' => array('Tipoinstit.id <>' => 0)
        ));

        $this->Titulo->recursive = -1;
        $titulos = $this->Titulo->find('all', array(
                                'fields' => array('Titulo.id', 'Titulo.name')
        ));
 
        foreach($departamentos as &$departamento) {
            $departamento['Departamento']['name'] = $this->__strToSpecialLower($departamento['Departamento']['name']);
        }
        $this->Departamento->saveAll($departamentos);
*/
        foreach($instits as &$instit) {
            //$instit['instit']['nombre'] = $this->__strToSpecialLower($instit['instit']['nombre']);
            //$instit['instit']['direccion'] = $this->__strToSpecialLower($instit['instit']['direccion']);
            //$instit['instit']['dir_nombre'] = $this->__strToSpecialLower($instit['instit']['dir_nombre']);
            //$instit['instit']['vice_nombre'] = $this->__strToSpecialLower($instit['instit']['vice_nombre']);
            //$instit['instit']['lugar'] = $this->__strToSpecialLower($instit['instit']['lugar']);
            if (!empty($instit['instit']['direccion'])) {
                $instit['instit']['direccion'] = str_ireplace("S/n", "S/N", $instit['instit']['direccion']);
                $instit['instit']['direccion'] = str_ireplace("s/n", "S/N", $instit['instit']['direccion']);
            }
        }
        $this->Instit->saveAll($instits, array('validate'=>false));
/*
        foreach($orientaciones as &$orientacion) {
            $orientacion['Orientacion']['name'] = $this->__strToSpecialLower($orientacion['Orientacion']['name']);
        }
        $this->Orientacion->saveAll($orientaciones, array('validate'=>false));

        foreach($localidades as &$localidad) {
            $localidad['Localidad']['name'] = $this->__strToSpecialLower($localidad['Localidad']['name']);
        }
        $this->Localidad->saveAll($localidades, array('validate'=>false));
*/
        foreach($planes as &$plan) {
            //$plan['Plan']['nombre'] = $this->__strToSpecialLower($plan['Plan']['nombre']);
            //$plan['Plan']['perfil'] = $this->__strToSpecialLower($plan['Plan']['perfil']);
            if (!empty($plan['Plan']['norma']))
               $plan['Plan']['norma'] = $this->__strToSpecialLower($plan['Plan']['norma']);
        }
        $this->Plan->saveAll($planes, array('validate'=>false));
/*
        foreach($sectores as &$sector) {
            $sector['Sector']['name'] = $this->__strToSpecialLower($sector['Sector']['name']);
        }
        $this->Sector->saveAll($sectores, array('validate'=>false));

        foreach($subsectores as &$subsector) {
            $subsector['Subsector']['name'] = $this->__strToSpecialLower($subsector['Subsector']['name']);
        }
        $this->Subsector->saveAll($subsectores, array('validate'=>false));

        foreach($tipoinstits as &$tipoinstit) {
            $tipoinstit['Tipoinstit']['name'] = $this->__strToSpecialLower($tipoinstit['Tipoinstit']['name']);
        }
        $this->Tipoinstit->saveAll($tipoinstits, array('validate'=>false));

        foreach($titulos as &$titulo) {
            $titulo['Titulo']['name'] = $this->__strToSpecialLower($titulo['Titulo']['name']);
        }
        $this->Titulo->saveAll($titulos, array('validate'=>false));
*/
        die("Finalizado!");
    }

    /*
     * Convierte la cadena a minúsculas con mayúsculas en cada primera letra salvo
     * preposiciones y otros casos
     */
    function __strToSpecialLower($string) {
        if (!strlen($string))
            return '';

        if (is_numeric($string))
            return $string;

        setlocale(LC_ALL, 'es_AR');
        $preposiciones = array('a','ante','bajo','cabe','con','contra','de','desde','en','entre','hacia','hasta','para','por','según','sin','so','sobre','tras',/* no es prepo*/'del','al');
        $articulos = array('el', 'la', 'las', 'los', 'un', 'unos', 'un', 'una', 'unas');
        $nexos = array('y', 'u', 'o', 'e');

        $string = trim(preg_replace('/\s\s+/', ' ', $string)); // elimina muchos espacios
        //$string = ucwords(strtolower($string)); // mayuscula la primer letra de cada palabra
        $palabras = split(' ', $string);

        foreach ($palabras as $key => &$palabra) {
            if (!empty($palabra)) {
                if (strlen($palabra) <= 4 &&
                    ($palabra == 'EGB' || $palabra == 'S/N' ||
                     $palabra == 'II' || $palabra == 'III' || $palabra == 'IV' ||
                     $palabra == 'VI' || $palabra == 'VII' || $palabra == 'VIII' ||
                     $palabra == 'IX' || $palabra == 'XI' || $palabra == 'XII' || $palabra == 'XIII')) {

                    $palabra = strtoupper($palabra);
                }
                elseif ($key == 0 && strpos($palabra, '.') === false && $palabra[0] != '"' && $palabra[0] != '(') {
                    $palabra = ucfirst(strtolower($palabra));
                }
                elseif (in_array(strtolower($palabra), $preposiciones)) {
                    // es preposicion
                    $palabra = strtolower($palabra);
                }
                elseif (in_array(strtolower($palabra), $nexos)) {
                    // es nexo
                    $palabra = strtolower($palabra);
                }
                elseif (in_array(strtolower($palabra), $articulos)) {
                    // es artículo, si contiene antes una preposicion va en minúscula
                    if (in_array(strtolower($palabras[$key-1]), $preposiciones)) {
                        // Antofagasta de la Sierra
                        $palabra = strtolower($palabra);
                    }
                    else {
                        // General Las Heras
                        $palabra = ucfirst(strtolower($palabra));
                    }
                }
                elseif (strpos($palabra, '.') !== false) {
                    // contiene puntos: C.A.B.A / Dr.
                    $palabra = ucfirst(strtolower($palabra));

                    $precede_punto = false;
                    for($i=0; $i < strlen($palabra); $i++) {
                        if ($precede_punto) {
                            $palabra[$i] = strtoupper($palabra[$i]);
                            $precede_punto = false;
                        }
                        elseif ($palabra[$i] == '.' && $i > 0) {
                            $precede_punto = true;
                        }
                        elseif ($palabra[$i] == '"' || $palabra[$i] == '(') {
                            $precede_punto = true;
                        }
                    }
                }
                elseif (strlen($palabra) > 1 && ($palabra[0] == '"' || $palabra[0] == '(' || $palabra[0] == '\'')) {
                    // comienza con comillas, parentesis (C.A.B.J) | "Jose de San Martín"
                    $palabra = strtolower($palabra);
                    $palabra[1] = strtoupper($palabra[1]);
                }
                elseif (strpos($palabra, '.') === false) {
                    // no es preposicion ni contiene puntos, paréntesis, comillas
                    $palabra = ucfirst(strtolower($palabra));
                }
            }
        }

        return $string = implode(' ', $palabras);
    }


    function checkPasswords() {
        $this->autoRender = false;

        $this->User->recursive = -1;
        $users = $this->User->find('all', array(
           'contain' => array('UserLogin' => array(
                                'order' => 'UserLogin.created DESC',
                                'limit' => '1'
           )),
           'conditions' => array('User.role' => 'referentes'),
           'order' => array('User.created')
        ));

        foreach ($users as $user) {
            switch ($user['User']['username']) {
                case "edillon":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("xMz23U") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "pcassutti":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("P26cT1") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "mrubio":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("rt53xq") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "dadicarlo":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("Ti44tW") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "jaramendi":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("ajm18x") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "cmaggio":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("c14rma") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "cdeluca":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("wer7df") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "jmonteagudo":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("rsj65m") != $user['User']['password']) {
                        echo "cambió password";
                    } 
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "hjose":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("yu27bu") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "mavila":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("r56tuu") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "vhgerea":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("cma4re") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "adolbar":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("a29bar") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "murbieta":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("ta43uu") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "mbroky":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("lus7ou") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "sreyes":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("mo92na") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "slibonati":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("m37til") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;

                case "daringoli":
                    echo "[".$user['User']['id']."] ".$user['User']['username'].": ";
                    if ($this->Auth->password("apr0Mo") != $user['User']['password']) {
                        echo "cambió password";
                    }
                    else {
                        echo "<b>no cambió password</b>";
                    }
                    echo " (último login: ".date('d/m/Y H:i', strtotime($user['UserLogin'][0]['created'])).")";
                    break;
            }
            
            echo "<br /><br />";
        }
    }
}
?>