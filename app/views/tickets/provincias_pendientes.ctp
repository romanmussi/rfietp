<div>
    <?php
    foreach($prov_pend as $id=>$name) {
        ?><li>
        <? echo $html->link($name, array('controller'=>'Tickets', 'action'=>'index', $id), array(
            'onclick'=>'Javascript: location.href="'.$html->url('/tickets/index/'.$id).'"')); ?>
    </li>
        <?php
    }

    if(count($prov_pend) < 1) {
        ?><li>
        <? echo $html->link("No hay pendientes","/pages/home/") ?>
    </li>
            <?php
    }
    ?>
</div>