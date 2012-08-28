<?php
    for ($i=2006; $i <= date('Y'); $i++) {
        $anios = null;
        foreach($plan['Anio'] as $anio) {
            if ($anio['ciclo_id'] == $i) {
                $anios[] = $anio;
            }
        }
?>
    <td class="td_ciclos">
        <?php 
        if (!empty($anios)) {
            // con links para editar
            echo $html->link(
                $this->element('graficadorPlan', array(
                            'anios' => $anios,
                            'depurado' => (in_array($i, $anios_incorrectos) ? false : true))),
                '/depurador_planes/arregladorDeAnios/'.$anio['plan_id'].'/'.$i,
                array(
                    'title' => 'Click para editar',
                    'alt' => 'Click para editar',
                    'onclick' => 'return EditarCiclo(this)',
                    'escape' => false
                    )
                );
        }
        else {
            // sin links
            echo $this->element('graficadorPlan', array(
                            'anios' => $anios,
                            'depurado' => (in_array($i, $anios_incorrectos) ? false : true)));
        }
                    ?>
        
    </td>
<?php
}
?>