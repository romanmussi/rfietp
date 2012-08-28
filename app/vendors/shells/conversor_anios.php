<?php

class ConversorAniosShell extends Shell {
    var $uses = array('Instit','Plan','Sector','Jurisdiccion', 'Tipoinstit','Anio','PlanCiclo','Ciclo');

    function main($command = null) {
        while (true) {
            if (empty($command)) {
                $command = trim($this->in(''));
            }

            switch ($command) {
                case '':
                case 'help':
                    $this->out('Ayuda del Conversor Años:');
                    $this->out('-------------');
                    $this->out('debe escribir alguna opción');
                    $this->out('Las opciones son:');
                    $this->out('');
                    $this->out('1) "iniciar"');
                    $this->out('');
                    break;

                case 1:
                case 'iniciar':
                    $this->comenzar();
                    break;

                case 'q':
                case 'quit':
                case 'exit':
                    return true;
                    break;

                default:
                    $this->out("Invalid command\n");
                    break;
            }
            $command = '';
        }
    }


    function comenzar(){
        $limit = 1000;
        $offset = 0;
        $planCicloId = 0;

        while (
                $anios = $this->Anio->find('all', array(
                    'limit' => $limit,
                    'offset' => $offset,
                    'conditions' => array('Anio.plan_ciclo_id' => 0)
                    ))
        ) {
            $offset += $limit;
            $this->out("buscando proximos $offset");

            foreach ($anios as $a) {
                $planCiclo = array(
                    'plan_id' => empty($a['Anio']['plan_id'])?0:$a['Anio']['plan_id'],
                    'ciclo_id' => empty($a['Anio']['ciclo_id'])?0:$a['Anio']['ciclo_id'],
                );
                if ($this->PlanCiclo->find('count', array(
                    'conditions' => $planCiclo, 'recursive'=>-1)) == 0) {
                        $this->PlanCiclo->create();
                        if (!$this->PlanCiclo->save($planCiclo)) $this->out('No se pudo guardar el planCiclo');
                        $planCicloId = $this->PlanCiclo->id;
                }

                $a['Anio']['plan_ciclo_id'] = $planCicloId;
                if (!$this->Anio->save($a['Anio'])) $this->out('No se pudo guardar el anio '.$a['Anio']['id']);
            }
        }
        $this->out($anios);
        $this->out("LISTTO");
    }

    



}



?>
