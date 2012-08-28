<?php 
/* SVN FILE: $Id$ */
/* Titulo Test cases generated on: 2010-03-16 11:03:42 : 1268749422*/
require_once dirname(__FILE__) . DS . '..' . DS . 'extra_functions.php';


class TituloTestCase extends CakeTestCase {
    var $Titulo = null;
    var $fixtures = array();

    function __construct() {
        $this->fixtures = getAllFixtures();
    }

    function startTest() {
        $this->Titulo =& ClassRegistry::init('Titulo');
    }

    function testTituloInstance() {
        $this->assertTrue(is_a($this->Titulo, 'Titulo'));
    }

    function testTituloFind() {
        $this->Titulo->recursive = -1;
        $results = $this->Titulo->find('first', array('conditions'=> array('id'=>344)));

        $this->assertTrue(!empty($results));

        $expected = array('Titulo' => array(
                        'id'  		=> 344,
                        'name'  	=> 'Plomero',
                        'marco_ref' => false,
                        'oferta_id' => 1
        ));
        $this->assertEqual($results, $expected);
    }


    function testTituloAdd() {
        $this->Titulo->recursive = -1;

        $titulo['Titulo'] = array(
                'id'  => 9898,
                'name' => 'Titulo Nuevo',
                'marco_ref' => true,
                'oferta_id' => 1,
        );
        $this->Titulo->save($titulo);
        $res = $this->Titulo->find('first', array('conditions'=>array('id'=> 9898)));
        $this->assertEqual($res,  $titulo);
    }


    function testFindCompleto() {
        $conditions = array(
                    'recursive' => 3,
                    'fields' => array('Titulo.id', 'Titulo.name','Titulo.marco_ref', 'Titulo.oferta_id', 'Oferta.abrev', 'Oferta.name'),
                    'conditions'=> array(
                        'lower(Titulo.name) SIMILAR TO ?' => convertir_texto_plano('inventado'),
                        'Titulo.oferta_id' => 1,
                        'SectoresTitulo.sector_id' => 2,
                        'SectoresTitulo.subsector_id' => 1,
                        'Instit.jurisdiccion_id' => 2,
                        'Instit.departamento_id' => 1,
                        'Instit.localidad_id' => 1,
                        ),
                    'group' => array('Titulo.id', 'Titulo.name','Titulo.marco_ref', 'Titulo.oferta_id', 'Oferta.abrev', 'Oferta.name'),
                    'order' => array('Titulo.name' => 'ASC', 'Titulo.oferta_id' => 'ASC'));

        $results = $this->Titulo->find('all', $conditions);
        $cant = $this->Titulo->find('count', $conditions);

        // que contenga todos los array del contain que hace el Model Titulo
        foreach($results as $titulo) {
            $this->assertTrue(array_key_exists('Titulo', $titulo));
            $this->assertTrue(array_key_exists('Oferta', $titulo));
            $this->assertTrue(array_key_exists('SectoresTitulo', $titulo));

            if (!empty($titulo['SectoresTitulo'])) {
                foreach($titulo['SectoresTitulo'] as $sectit) {
                    $this->assertTrue(array_key_exists('Sector', $sectit));
                    $this->assertTrue(array_key_exists('Subsector', $sectit));
                }
            }
        }

        $this->assertEqual(count($results), $cant);
    }
}
?>