<?php
/* SVN FILE: $Id: app_model.php 7945 2008-12-19 02:16:01Z gwoo $ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	
	var $actsAs = array('Containable');
	
		
	/**
	 * Me trae los campos de los BELONGS para poder hacer el group by de los HASMANY sin problemas
	 * @return array
	 */	
	 function getPagFields(){
              $fields = array();
              // me pone los campos del mismo modelo que llma  a getPagFields
              foreach ($this->_schema as $name => $options){
                 $fields[] = $this->name . "." . $name;
              }

              // busco los belongs to y sus atributos
              foreach ($this->belongsTo as $bName => $bOptions){
               //   debug($bName);
                 foreach ($this->$bName->_schema as $name => $options){
                    $fields[] = $bName . "." . $name;
//debug($name);
                 }
              }

              return $fields;
           }


           /**
            * Me devuelve un array con el listado de modelos BelongsTo relacionados
            * al modelo $this que lo invoque
            * @return array
            */
           function getBelongsTos()
           {
               $vRet = array();
               foreach ($this->belongsTo as $bName => $bOptions){
                 $vRet[] = $bName;
               }
               return $vRet;
           }


           /**
            *Me escribe los errores de validacion surgidos
            * de un Save, separados por un salto de linea
            * @return string
            *
            */
           function listarErroresDeValidacionEnHtml() {
               $txt = '';
               foreach ($this->validationErrors as $ee) {
                   $txt = $ee . '<br>';
               }
               return $txt;
           }



           /**
     * Makes a subquery
     * @param strin|array $type The type o the query (only available 'count') or the $options
     * @param string|array $options The options array or $alias in case of $type be a array
     * @param string $alias You can use this intead of $options['alias'] if you want
     */
    public function subquery($type, $options = null, $alias = null){
        $fields = array();
        if(is_string($type)){
            $isString = true;
        }else{
            $alias = $options;
            $options = $type;
        }

        if($alias === null){
            $alias = $this->alias . '2';
        }

        if(isset($isString)){
            switch ($type){
                case 'count':
                    $fields = array('COUNT(*)');
                    unset($options['fields']);
                    break;
            }
        }

        $dbo = $this->getDataSource();

        $default = array(
            'fields' => $fields,
            'table' => $dbo->fullTableName($this),
            'alias' => $alias,
            'limit' => null,
            'offset' => null,
            'joins' => array(),
            'conditions' => array(),
            'order' => null,
            'group' => null
        );

        $params = array_merge($default, $options);
        $subQuery = $dbo->buildStatement($params, $this);

        return $subQuery;
    }
    
    
    /***************************
         *
         * log en archivo de texto
         */
        function logDepuradores($user, $group, $depurador){
            $logTxt = $headTxt = '';
            $logTxt .= '|'. $depurador; $headTxt .= '|'.'Depurador';
            $logTxt .= '|'. $user; $headTxt .= '|'.'Usuario';
            $logTxt .= '|'. $group; $headTxt .= '|'.'Rol';

            $log_file_name = 'depuradores_'.date('m_Y',strtotime('now'));;
            $archivo = APP . 'tmp' . DS . 'logs' . DS . $log_file_name.'.log';
            if (!file_exists($archivo)){
                 // armo el encabezado del CSV
                 $this->log($headTxt,$log_file_name);
            }
            //meto la data en el log
            $this->log($logTxt,$log_file_name);
        }
   
	
}
	
?>