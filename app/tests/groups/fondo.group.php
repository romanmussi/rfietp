<?php
class FondoGroupTest extends GroupTest {
  var $label = 'Fondos';
  function FondoGroupTest() {
    TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models'.DS.'z_fondo_work');
    TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models'.DS.'fondos_lineas_de_accion');
    TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models'.DS.'fondo_temporal');
  }
}
?> 
