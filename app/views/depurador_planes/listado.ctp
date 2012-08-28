

<div class="instits form">
<h1>Depurador de Estructuras</h1>
<h2>¡¡¡ Vamos que faltan sólo <?php echo $cantFaltan?> Instituciones!!!</h2>


<?php 
	echo $form->create('Depurador',array('url'=>'/depuradorPlanes/listado',
					'id'=>'estructura_plan'));

        echo $form->input('jurisdiccion_id', array(
            'empty'=>'Seleccione',
            'default'=>$jurisdiccion_id,
            'div'=>array('style'=>'float: left')
                ));

        echo $form->input('orientacion_id', array(
            'empty'=>'Seleccione',
            'default'=>$orientacion_id,
            'div'=>array('style'=>'float: left')
                ));

        echo $form->input('gestion_id', array(
            'empty'=>'Seleccione',
            'default'=>$gestion_id,
            'div'=>array('style'=>'float: left')
                ));

        echo $form->input('cue', array(
            'empty'=>'Seleccione',
            'default'=>$cue,
            'div'=>array('style'=>'float: left')
                ));

        echo $form->input('limit',  array(
            'label' => 'Traer',
            'empty'=>'Seleccione',
            'default'=>$limit,
            'div'=>array('style'=>'float: left; clear:none;'),
            'options' => array(10=>10, 25=>25, 50=>50, 100=>100, 9999=>'Todo'),
            ));

        echo $form->input('errores',  array(
            'label' => 'Ordenar Por',
            'empty'=>'Seleccione',
            'default'=>$errores,
            'div'=>array('style'=>'float: left; clear:none;'),
            'options' => array('CUE', 'Cantidad de errores (mayor a menor)', 'Cantidad de errores (menor a mayor)'),
            ));

        echo $form->button('Filtrar',  array(
            'type' => 'submit',
            'style'=>'clear:right; margin-top: 19px',
            ));


	echo $form->end();
?> 
<br>

<h2>Instituciones a depurar</h2>


<?php foreach ($institsMal as $i):?>
<p>
    <?php
        $nro = empty($i['Instit']['nro'])?'': ' Nº '.$i['Instit']['nro'];
        $nombre = $i['Instit']['tipoinstit'].$nro." - ".$i['Instit']['nombre'];
        echo "-- ".$html->link($i['Instit']['cue']*100+$i['Instit']['anexo']. " ::: ".$nombre. " (".$i['Instit']['errores']." errores)",
                '/depuradorPlanes/index/'.$i['Instit']['id']
                );
    ?>

    <span>
        <?php
        echo $html->link($html->image('search.png', array('width'=>'18px')),
                '/instits/view/'.$i['Instit']['id'],
                array('escape'=>false)
                );
        ?>
    </span>
</p>
    

<?php endforeach;?>

        
</div>



