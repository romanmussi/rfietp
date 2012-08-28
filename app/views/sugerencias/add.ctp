<div class="sugerencias form">
    <h1>
        <?php echo $html->image('bulbIcon_normal.png', array(
        'height'=>'40px',
        'align'=>'absmiddle',
        'style'=>'botom: -5px;',
        'alt'=>'idea',
        'title'=>'Idea')); ?>
        <?php __('Sugerencias');?>
    </h1>

    <br>
    
    <p>
    Habilitamos el presente formulario para que Ud. pueda hacernos llegar sugerencias y opiniones sobre la aplicación Registro Federal de Instituciones de ETP (RFIETP). Puede solicitar nuevas características, o proponer modificaciones y ampliaciones de funcionalidad existente. Cualquier sugerencia será bienvenida.
    Las propuestas serán tomadas en cuenta para mejorar el programa.
    </p>

    
    <?php echo $form->create('Sugerencia');?>
    
    <fieldset>
        <?php
        // echo $form->input('asunto');
        //echo $form->hidden( 'asunto' );
        echo $form->hidden('asunto', array('value'=>'Sugerencia por medio Web'));
        echo $form->input('mensaje', array('label'=>''));
        echo $form->hidden('user_id', array('value'=>$session->read('Auth.User.id')));
        echo $form->hidden('email', array('value'=>$session->read('Auth.User.mail')));
        echo $form->hidden('IP', array('value'=>$_SERVER['REMOTE_ADDR']));
        // echo $form->input('leido');
        ?>
    </fieldset>
    <?php echo $form->end('Enviar');?>
</div>

