<?php 
/* SVN FILE: $Id$ */
/* Fondo Test cases generated on: 2010-04-22 10:25:00 : 1271942700*/
App::import('Model', 'FondoTemporal');

class FondotemporalTestCase extends CakeTestCase {
    var $FondoTemporal = null;
    var $tipoInstits = null;

    var $fixtures = array(
            'app.jurisdiccion', 'app.instit', 'app.claseinstit',
            'app.orientacion',  'app.sector', 'app.plan', 'app.subsector',
            'app.lineas_de_accion', 'app.fondos_lineas_de_accion',
            'app.tipoinstit', 'app.dependencia', 'app.departamento', 'app.localidad',
            'app.etp_estado', 'app.oferta', 'app.titulo', 'app.anio', 'app.ciclo',
            'app.etapa', 'app.gestion', 'app.historial_cue', 'app.ticket', 'app.user',
            'app.user_login', 'app.fondo', 'app.fondo_temporal'
    );

    function startTest() {
        /*
        * @var FondoTemporal
        */
        $this->FondoTemporal =& ClassRegistry::init('FondoTemporal');
        $this->Tipoinstit =& ClassRegistry::init('Tipoinstit');
        $this->Instit =& ClassRegistry::init('Instit');

        // trae todos los tipoInstits
        $this->Tipoinstit->recursive = 0;
        $this->tipoInstits = $this->Tipoinstit->find("all", array(
                'order'=> array('LENGTH(Tipoinstit.name)'=>'desc')
            ));
    }

    function testFondoInstance() {
        $this->assertTrue(is_a($this->FondoTemporal, 'FondoTemporal'));
    }

    function testOptimiza_cadena() {
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('BLA N° 63'), 'bla nº63');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('E.E.T.N° 5'), 'eet nº5');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('E.E.T.N° 5-902'), 'eet nº5-902');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('BLA N°63-002'), 'bla nº63-002');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('BLA N° 63-002'), 'bla nº63-002');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('Misión Monotéc.N°72'), 'mision monotec nº72');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('ETAgro Nº1-Hued'), 'et agro nº1 -hued');
        //$this->assertEqual($this->FondoTemporal->optimizar_cadena('CFP Nº1Aguilares'), 'cfp nº1 aguilares');
    }

    function testCompara_numeroInstit() {
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N° 63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA Nº 63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N\' 63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N°63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA Nº63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N|63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('ET- Agro - Snopek','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N° 6','06'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N° 06','6'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('Centro de Formación Profesional Nº 402-Pablo Podestá- Tres de Febrero','402'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('E.E.T.N° 5 - Mar del Plata','05'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('E.E.T.N° 1 _Dr. Conrado Etchebarne - Villaguay','01'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('ETAgro Nº1-Hueda','01'));
        //$this->assertTrue($this->FondoTemporal->compara_numeroInstit('Escuela Técnica Agropecuaria (Ex EMETA N° 1) Chamical','01'));
        //$this->assertTrue($this->FondoTemporal->compara_numeroInstit('Instituto N° P-34 José Ingenieros Hucal','P-34'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('Misión Monotéc.N°72','72'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('I. Form. Prof.Nº6005','6005'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('I.P.E.M.Nº 291 - Gral Cabrera','291'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('ISP N° 4 Ángel Cárcano Anexo Las Toscas','4'));
        //$this->assertTrue($this->FondoTemporal->compara_numeroInstit('CFP Nº1Aguilares','1'));

        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA Nº 73','63'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA Nº 163','63'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA Nº 630','63'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA Nº 63','630'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('CFP N° 11 (Ex 30)','30'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('E.E.T. N° Marco Silvio Ghiglione - América','01'));
    }

    function testCompara_tipoInstit() { 
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('EET Nº 15 Maipú', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('E.E.T. Nº 15 Maipú', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('eet Nº 15 Maipú', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('e.e.t. Nº 15 Maipú', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('escuela Nº 15 Maipú', $this->tipoInstits), 8);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('centro fp Nº 15 Maipú', $this->tipoInstits), 18);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto N° P-34 José Ingenieros Hucal', $this->tipoInstits), 214);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Misión Monotécnica y de Extensión Cultural N° 4 Robles', $this->tipoInstits), 215);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Escuela de Educación Secundaria N° 1 General Enrique Mosconi La Matanza', $this->tipoInstits), 8); // ESCUELA
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto de Educación Superior de Comercio N° 114 Tupac Amaru II General San Martín', $this->tipoInstits), 217);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto de Educación Superior de Comercio N° 114 Tupac Amaru II General San Martín', $this->tipoInstits), 217);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Centro Educativo de Nivel Terciario N\' 24', $this->tipoInstits), 9);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto Politécnico N° 37 Juan XXIII', $this->tipoInstits), 219);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('EPET N° 15 Zapala', $this->tipoInstits), 220);
        // bug porque entra antes por "mision monotecnica"
        //$this->assertEqual($this->FondoTemporal->compara_tipoInstit('Misión Monotécnica y de Cultura Rural y Doméstica N° 15 San Salvador', $this->tipoInstits), 221);

        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Esc Ed T Nº 15 Maipú', $this->tipoInstits), 0);
    }

    function testCompara_institNombres() {
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET Nº 15 Maipú', 'EET Nº 015 Maipú', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET Nº 15 Maipú', 'eet Nº 15 Meipú', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET Nº 15 Maipú', 'iet Nº 15 Meipú', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('C.E.N.T. Nº 2 Clotilde Mercedes G. De Fernández', 'CENT Nº 2 Clotilde Mercedes G. De Fernández', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('C.E.N.T. Nº 2 Clotilde Mercedes G. De Fernández', 'CENT Nº 2 Clotilde g De Fernández', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('C.E.N.T. Nº 2 Clotilde Mercedes G. De Fernández - anexo', 'CENT Nº 2 Clotilde Mercedes G. De Fernández - anexo', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Escuela Polimodal N° 6 José Hernández', 'JOSÉ HERNÁNDEZ', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Escuela Polimodal N° 4 Ernesto Sábato', 'ERNESTO SÁBATO', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('E.E.T. N° Marco Silvio Ghiglione - ', 'MARCOS SILVIO GHIGLIONE', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Escuela de Educación Técnica N° 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('escuela N° 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('centro educativo de nivel terciario N° 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Instituto DE Educación superior de COMercio N° 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET N° 45 TEC Félix Bourren Meyer', 'FÉLIX BOURREN MEYER', $this->tipoInstits));
        
        //Escuela Técnica Nº 34 Ing. Enrique Martín Hermitte
        // en duda por "de" 2 veces $this->assertFalse($this->FondoTemporal->compara_institNombres('Escuela de Educación Técnica Teolinda Romero de Sotomayor - 25 de Mayo', '25 DE MAYO', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('EEM N° 220 Ing. Agr. Mariano J. Frezzi Río Segundo', 'INGENIERO AGRÓNOMO J. FREZZI', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Misión Monotécnica y de Extensión Cultural N° 4 Robles', '', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Misión Monotécnica y de Extensión Cultural N° 2 - Santo Domingo', '', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('EET Nº 15 Maipú', 'eet Nº 15 Meeipú', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Esc Nº 15 Maipú', 'EET Nº 15 Maipú', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Esc Ed T Nº 15 Maipú', 'EET Nº 15 Maipú', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('ET Nº 1 - Santa Lucía', 'ET Nº 1 - Anexo Santa Lucía', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('C.E.N.T. Nº 2 Clotilde Mercedes G. De Fernández', 'CENT Nº 2 Clotilde Mercedes G. De Fernández anexo', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('C.E.N.T. Nº 2 Clotilde Mercedes G. De Fernández - anexo', 'CENT Nº 2 Clotilde Mercedes G. De Fernández', $this->tipoInstits));
    }

    function testCompara_Localidad() {
        $fondos = $this->FondoTemporal->find("all");
        $this->Instit->recursive = 0;
        $instits = $this->Instit->find("all", array(
                                        'cointain'=> array('Localidad(name)')
        ));
        
        $this->assertTrue($this->FondoTemporal->compara_Localidad($fondos[0], $instits[0]));
        $this->assertTrue($this->FondoTemporal->compara_Localidad($fondos[8], $instits[0]));
        $this->assertTrue($this->FondoTemporal->compara_Localidad($fondos[5], $instits[2]));
        $this->assertTrue($this->FondoTemporal->compara_Localidad($fondos[6], $instits[2]));

        $this->assertFalse($this->FondoTemporal->compara_Localidad($fondos[7], $instits[0]));
        $this->assertFalse($this->FondoTemporal->compara_Localidad($fondos[6], $instits[0]));
    }

    function testValidarInstit() {
        $fondos = $this->FondoTemporal->find("all");
        $instits = $this->Instit->find("all");
        
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[0], $instits, $this->tipoInstits), 1);
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[1], $instits, $this->tipoInstits), 2);
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[2], $instits, $this->tipoInstits), 1);
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[3], $instits, $this->tipoInstits), 1);
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[4], $instits, $this->tipoInstits), 0); // coincide nro pero no nombre
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[5], $instits, $this->tipoInstits), 1);
        //$this->assertEqual($this->FondoTemporal->validarInstit($fondos[6], $instits, $this->tipoInstits), 1); // no chequea el N° P-34
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[7], $instits, $this->tipoInstits), 0);
    }
}
?>