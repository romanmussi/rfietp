<?php
set_time_limit(60*60*0.5); // media hora de ejecucion limite

class ZFondoWorksController extends AppController {

    var $name = 'ZFondoWorks';
    var $helpers = array('Html', 'Form');
    /**
     * @var ZFondoWork
     */
    var $ZFondoWork;


    /**
     *
     * @param boolean $validar default en true Esta variable es para que no me haga el checkeo de totales al inicio y al final
     * @param integer $cantDeFondosDelExcel default en 0. Indica el numero de registros que hay en el excel original
     * @param integer $cantRegistros, default en 0 para que traiga todos. Es el LIMIT que quiero ponerle al traerme registros para procesar
     * @return <type>
     */
    function migrator($validar = 1, $cantDeFondosDelExcel = 0, $cantRegistros = 0) {
        // solo migro por defecto instits y jurisdiccionales
        // y no me importa si estan chekeados o no
        $cosasAmigrar = 'ij';
        
        if ($validar == 2) {
            $cosasAmigrar = 'ijc';
        }
        
        if ( $validar == 1) {
            $tempsComprobacion = $this->ZFondoWork->temporalesFiltradosX('ijc', $cantRegistros);
            $totTemps = count($tempsComprobacion);
            if ( $totTemps != $cantDeFondosDelExcel || $cantDeFondosDelExcel == 0) {
                $this->set('msg', '');
                $this->set('msg_type', '');
                $this->set('msg_check', "hay solo $totTemps registros en z_fondo_work, cuando en el excel hay $cantDeFondosDelExcel.");
                $this->set('msg_check_type', 'error');
                return;
            }
            // generalmente si quiero validar es porque estoy realizando
            // la migracion definitiva
            // en ese caso quiero aegurarme que tanto las instituciones
            // como los jurisdiccionales
            // esten checkeados ya sea su CUE o sus TOTALES
             $cosasAmigrar = 'ijc';
        }


        $iMi = $this->ZFondoWork->migrar($cosasAmigrar, $cantRegistros);
        switch ($iMi) {
            case -1:
                $msg = "La migración finalizó correctamente: ".implode(', ',$this->ZFondoWork->migrationStatus);
                $msg_type = "notice";
                break;

            case ($iMi > 0):
                 $msg = "La migración finalizó correctamente: ".implode(', ',$this->ZFondoWork->migrationStatus);
                $msg_type = "success";
                break;

            case ($iMi < 1):
                $msg = "La migración resultó con ERRORES: ".implode(', ',$this->ZFondoWork->migrationStatus);
                $msg_type = "error";
                break;
        }
        $msg_check = '';
        $msg_check_type = '';
        $pasoOk = $this->ZFondoWork->checkCantRegistrosFondoConExcel($cantDeFondosDelExcel);
        if ($pasoOk != 0) {
            $msg_check = "[$pasoOk registros en el excel)]. No se migraron todos los registros que hay en el excel original.";
            $msg_check_type = 'error';
        }
        $this->set('msg',$msg);
        $this->set('msg_type',$msg_type);
        $this->set('msg_check',$msg_check);
        $this->set('msg_check_type',$msg_check_type); 
    }
}

?>