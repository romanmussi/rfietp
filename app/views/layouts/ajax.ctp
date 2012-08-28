
<?php

$jsPoner = 'views'.DS.Inflector::underscore($this->name).DS.$this->action;
$jsView = WWW_ROOT.'js'.DS.$jsPoner;
if (file_exists($jsView.'.js')) {
    echo $javascript->link($jsPoner);
}
echo $content_for_layout;
?>