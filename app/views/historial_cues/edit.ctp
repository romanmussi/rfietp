<?php 

echo $form->create('HistorialCue');
echo $form->input('id');
echo $form->input('cue',array('maxlength'=>7));
echo $form->input('anexo',array('maxlength'=>2));
echo $form->input('created');
echo $form->input('observaciones');
echo $form->input('instit_id',array('type'=>'hidden'));
echo $form->end('Guardar');

?>