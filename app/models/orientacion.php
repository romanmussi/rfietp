<?php
class Orientacion extends AppModel {

    var $name = 'Orientacion';
    var $order = 'Orientacion.name';

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasMany = array(
            'Sector',
            'Instit',
    );

}
?>