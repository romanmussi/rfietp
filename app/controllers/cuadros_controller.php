<?php
class CuadrosController extends AppController {

	var $name = 'Cuadros';
	var $uses = array('CustomQuery');
	
	function total_instits_por_ambito_de_gestion() {
		$this->CustomQuery->sql = "
				(SELECT j.name as \"División político-territorial\" ,
	                    sum(CASE WHEN (i.gestion_id = 1 ) THEN 1 ELSE 0 END )as \"Estatal\" ,
	                    sum(CASE WHEN (i.gestion_id = 2 ) THEN 1 ELSE 0 END )as \"Privada\" ,
                        count(*) as \"Total\"
                 FROM   instits i LEFT JOIN jurisdicciones j ON j.id = i.jurisdiccion_id
                 WHERE  i.activo = 1
                 AND    i.dependencia_id <> 2
                 GROUP BY j.name
                 ORDER BY j.name
                )
                UNION ALL
                (
                 SELECT cast ('Universidades Nacionales' as varchar(40)) as \"División político-territorial\",
	                    sum(CASE WHEN (i.gestion_id = 1) THEN 1 ELSE 0 END )as \"Estatal\" ,
	                    sum(CASE WHEN (i.gestion_id = 2) THEN 1 ELSE 0 END )as \"Privada\" ,
                        count(*) as \"Total\"
                 FROM  instits i
                 WHERE i.dependencia_id = 2
                 AND   i.activo = 1
                )
                UNION ALL
                (
                 SELECT cast ( 'Total' as varchar(40)) as \"División político-territorial\" ,
                 sum(CASE WHEN (i.gestion_id = 1) THEN 1 ELSE 0 END ) as \"Estatal\" ,
                 sum(CASE WHEN (i.gestion_id = 2) THEN 1 ELSE 0 END )as \"Privada\",
                 count(*) as \"Total\"
                 FROM   instits i 
                 WHERE  i.activo = 1
                )	
              ";
		
		//$data = $this->paginate($this->CustomQuery);
		$data = $this->CustomQuery->query();
		
		$precols = array(0=>"",1=>"Ámbito de Gestión",2=>"");
		$cols = array_keys($data['0']['0']);
		$this->set('precols', $precols); 
		$this->set('cols', $cols);
		$this->set('queries', $data);
	}
	
	function total_instits_por_tipo_de_etp() {
		$this->CustomQuery->sql = '

		( 
SELECT j.name as "División político-territorial" , 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END )as "estatal_SEC", 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END )as "estatal_SUP", 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END )as "estatal_FP" , 
sum(CASE WHEN (i.gestion_id = 1 AND i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "estatal_ETP", 
sum(CASE WHEN (i.gestion_id = 1 ) THEN 1 ELSE 0 END )as "estatal" ,

sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "privada_SEC", 
sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "privada_SUP", 
sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "privada_FP" , 
sum(CASE WHEN (i.gestion_id = 2 AND i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "privada_ETP", 
sum(CASE WHEN (i.gestion_id = 2 ) THEN 1 ELSE 0 END )as "privada" , 

sum(CASE WHEN (i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "total_SEC", 
sum(CASE WHEN (i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "total_SUP", 
sum(CASE WHEN (i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "total_FP" , 
sum(CASE WHEN (i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "total_ETP", count(*) as "total" 
FROM instits i LEFT JOIN jurisdicciones j ON j.id = i.jurisdiccion_id 

WHERE i.activo = 1 AND i.dependencia_id <> 2 
GROUP BY j.name ORDER BY j.name 
) 

UNION ALL 

( 
SELECT cast (\'Universidades Nacionales\' as varchar(40)) as "División político-territorial", 

sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Estatal_SEC", 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Estatal_SUP", 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Estatal_FP" , 
sum(CASE WHEN (i.gestion_id = 1 AND i.etp_estado_id = 1 ) THEN 1 ELSE 0 END ) as "Estatal_ETP", 
sum(CASE WHEN (i.gestion_id = 1) THEN 1 ELSE 0 END )as "Estatal" , 

sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Privada_SEC", 
sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Privada_SUP", 
sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Privada_FP" , 
sum(CASE WHEN (i.gestion_id = 2 AND i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "Privada_ETP", 
sum(CASE WHEN (i.gestion_id = 2) THEN 1 ELSE 0 END )as "Privada" , 

sum(CASE WHEN (i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "TOT_SEC", 
sum(CASE WHEN (i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "TOT_SUP", 
sum(CASE WHEN (i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "TOT_FP" , 
sum(CASE WHEN (i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "TOT_ETP", count(*) as "Total" 
FROM instits i 
WHERE i.dependencia_id = 2 AND i.activo = 1 
) 



UNION ALL 
( 
SELECT cast ( \'Total\' as varchar(40)) as "División político-territorial" , 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Estatal_SEC", 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Estatal_SUP", 
sum(CASE WHEN (i.gestion_id = 1 AND i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "Estatal_FP" , 
sum(CASE WHEN (i.gestion_id = 1 AND i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "Estatal_ETP", 
sum(CASE WHEN (i.gestion_id = 1) THEN 1 ELSE 0 END ) as "Estatal" , 

sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END )as "Privada_SEC", 
sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END )as "Privada_SUP",
sum(CASE WHEN (i.gestion_id = 2 AND i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END )as "Privada_FP" , 
sum(CASE WHEN (i.gestion_id = 2 AND i.etp_estado_id = 1 ) THEN 1 ELSE 0 END ) as "Privada_ETP", 
sum(CASE WHEN (i.gestion_id = 2) THEN 1 ELSE 0 END ) as "Privada", 

sum(CASE WHEN (i.claseinstit_id = 3 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "TOT_SEC", 
sum(CASE WHEN (i.claseinstit_id = 4 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "TOT_SUP", 
sum(CASE WHEN (i.claseinstit_id = 1 AND i.etp_estado_id = 2) THEN 1 ELSE 0 END ) as "TOT_FP" , 
sum(CASE WHEN (i.etp_estado_id = 1) THEN 1 ELSE 0 END ) as "TOT_ETP", count(*) as "Total" 
FROM instits i 
WHERE i.activo = 1 
)
		
		';
		
		//$data = $this->paginate($this->CustomQuery);
		$data = $this->CustomQuery->query();
		
		$precols = array(0=>"",1=>"Ámbito de Gestión",2=>"");
		$cols = array_keys($data['0']['0']);
		$this->set('precols', $precols); 
		$this->set('cols', $cols);
		$this->set('queries', $data);
	}
}
?>