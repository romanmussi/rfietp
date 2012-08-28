<?php
class FondosLineasDeAccion extends AppModel {

	var $name = 'FondosLineasDeAccion';
	var $validate = array(
		'fondo_id' => array('numeric'),
		'lineas_de_accion_id' => array('numeric'),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Fondo' => array(
			'className' => 'Fondo',
			'foreignKey' => 'fondo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LineasDeAccion' => array(
			'className' => 'LineasDeAccion',
			'foreignKey' => 'lineas_de_accion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


     /**
     * Returns a result set array.
     *
     * Also used to perform new-notation finds, where the first argument is type of find operation to perform
     * (sum / all / first / count / neighbors / list / threaded ),
     * second parameter options for finding ( indexed array, including: 'conditions', 'limit',
     * 'recursive', 'page', 'fields', 'offset', 'order')
     *
     * Eg:
     * {{{
     *	find('all', array(
     *		'conditions' => array('name' => 'Thomas Anderson'),
     * 		'fields' => array('name', 'email'),
     * 		'order' => 'field3 DESC',
     * 		'recursive' => 2,
     * 		'group' => 'type'
     * ));
     * }}}
     *
     * Specifying 'fields' for new-notation 'list':
     *
     *  - If no fields are specified, then 'id' is used for key and 'model->displayField' is used for value.
     *  - If a single field is specified, 'id' is used for key and specified field is used for value.
     *  - If three fields are specified, they are used (in order) for key, value and group.
     *  - Otherwise, first and second fields are used for key and value.
     *
     * @param array $conditions SQL conditions array, or type of find operation (all / first / count / neighbors / list / threaded)
     * @param mixed $fields Either a single string of a field name, or an array of field names, or options for matching
     * @param string $order SQL ORDER BY conditions (e.g. "price DESC" or "name ASC")
     * @param integer $recursive The number of levels deep to fetch associated records
     * @return array Array of records
     * @access public
     * @link http://book.cakephp.org/view/449/find
     */
    function find($conditions = null, $fields = array(), $order = null, $recursive = null){
        if (!empty($conditions)) {
            $conditions = strtolower($conditions);
            if ($conditions == 'sum') {
                $campoAMeter = array('sum("FondosLineasDeAccion"."monto") AS "FondosLineasDeAccion__sum"');
                if (is_array($fields)) {                    
                    if (!empty($fields['fields'])) {
                        $fields['fields'] = Set::merge($fields['fields'], $campoAMeter);
                    } else {
                        $fields['fields'] = $campoAMeter;
                    }
                    if (!empty($fields['group'])) {
                        $fields['fields'] = Set::merge($fields['fields'], $fields['group']);
                    }
                } elseif (is_string($fields)) {
                    return parent::find($conditions, $fields, $order, $recursive);
                }
                $trajo = parent::find('all', $fields, $order, $recursive);
                
                if (count($trajo)> 1)
                    return $trajo;
                else
                    return $trajo[0]['FondosLineasDeAccion']['sum'];
           }
        }
        return parent::find($conditions, $fields, $order, $recursive);
    }
}
?>