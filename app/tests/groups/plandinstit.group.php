<?php
class PlandinstitGroupTest extends GroupTest {
  var $label = 'Plan, Titulo & Instit';
  function PlandinstitGroupTest() {
      TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models'.DS.'instit');
      TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models'.DS.'plan');
      TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models'.DS.'titulo');
  }
}
?> 
