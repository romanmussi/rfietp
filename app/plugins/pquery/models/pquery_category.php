<?php
class PqueryCategory extends AppModel {

	var $name = 'PqueryCategory';


	var $hasMany = array(
		'Query' => array(
			'className' => 'Query',
			'foreignKey' => 'pquery_category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>