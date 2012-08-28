<?php

header('Content-Type:text/html; charset=ISO-8859-1');

echo $form->input('titulo_id', 
        array(
            'options'=>$titulos,
            'empty'=>'seleccione',
            'div' => false,
            'onchange'=>"seleccionarTitulosEnMasa();",
            'selected'=> $this->data['Titulo']['id'],
            ));

