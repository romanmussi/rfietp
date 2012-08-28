<div id="boxInstituciones">
    <h1  id="boxInstituciones" class="menu_head">Instituciones</h1>

    <ul class="menu_body">
           
            <li>
                <?php
                    //echo $html->image('labs.png', array('style' => 'float:right;display:inline; margin-bottom:3px; padding-right:10px;width:20px'));
                    echo $html->link(__('Buscador', true), '/instits/search_form');
                ?>
            </li>
            <li><?php echo $html->link(__('Buscador Avanzado', true), '/instits/advanced_search_form'); ?></li>
            <li><?php echo $html->link(__('Histórico de CUE', true), '/historialCues/search_form'); ?></li>
    </ul>
</div>