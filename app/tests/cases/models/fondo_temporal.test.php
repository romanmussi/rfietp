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
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('BLA N� 63'), 'bla n�63');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('E.E.T.N� 5'), 'eet n�5');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('E.E.T.N� 5-902'), 'eet n�5-902');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('BLA N�63-002'), 'bla n�63-002');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('BLA N� 63-002'), 'bla n�63-002');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('Misi�n Monot�c.N�72'), 'mision monotec n�72');
        $this->assertEqual($this->FondoTemporal->optimizar_cadena('ETAgro N�1-Hued'), 'et agro n�1 -hued');
        //$this->assertEqual($this->FondoTemporal->optimizar_cadena('CFP N�1Aguilares'), 'cfp n�1 aguilares');
    }

    function testCompara_numeroInstit() {
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N� 63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N� 63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N\' 63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N�63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N�63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N|63','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('ET- Agro - Snopek','63'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N� 6','06'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('BLA N� 06','6'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('Centro de Formaci�n Profesional N� 402-Pablo Podest�- Tres de Febrero','402'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('E.E.T.N� 5 - Mar del Plata','05'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('E.E.T.N� 1 _Dr. Conrado Etchebarne - Villaguay','01'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('ETAgro N�1-Hueda','01'));
        //$this->assertTrue($this->FondoTemporal->compara_numeroInstit('Escuela T�cnica Agropecuaria (Ex EMETA N� 1) Chamical','01'));
        //$this->assertTrue($this->FondoTemporal->compara_numeroInstit('Instituto N� P-34 Jos� Ingenieros Hucal','P-34'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('Misi�n Monot�c.N�72','72'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('I. Form. Prof.N�6005','6005'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('I.P.E.M.N� 291 - Gral Cabrera','291'));
        $this->assertTrue($this->FondoTemporal->compara_numeroInstit('ISP N� 4 �ngel C�rcano Anexo Las Toscas','4'));
        //$this->assertTrue($this->FondoTemporal->compara_numeroInstit('CFP N�1Aguilares','1'));

        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA N� 73','63'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA N� 163','63'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA N� 630','63'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('BLA N� 63','630'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('CFP N� 11 (Ex 30)','30'));
        $this->assertFalse($this->FondoTemporal->compara_numeroInstit('E.E.T. N� Marco Silvio Ghiglione - Am�rica','01'));
    }

    function testCompara_tipoInstit() { 
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('EET N� 15 Maip�', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('E.E.T. N� 15 Maip�', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('eet N� 15 Maip�', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('e.e.t. N� 15 Maip�', $this->tipoInstits), 33);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('escuela N� 15 Maip�', $this->tipoInstits), 8);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('centro fp N� 15 Maip�', $this->tipoInstits), 18);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto N� P-34 Jos� Ingenieros Hucal', $this->tipoInstits), 214);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Misi�n Monot�cnica y de Extensi�n Cultural N� 4 Robles', $this->tipoInstits), 215);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Escuela de Educaci�n Secundaria N� 1 General Enrique Mosconi La Matanza', $this->tipoInstits), 8); // ESCUELA
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto de Educaci�n Superior de Comercio N� 114 Tupac Amaru II General San Mart�n', $this->tipoInstits), 217);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto de Educaci�n Superior de Comercio N� 114 Tupac Amaru II General San Mart�n', $this->tipoInstits), 217);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Centro Educativo de Nivel Terciario N\' 24', $this->tipoInstits), 9);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Instituto Polit�cnico N� 37 Juan XXIII', $this->tipoInstits), 219);
        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('EPET N� 15 Zapala', $this->tipoInstits), 220);
        // bug porque entra antes por "mision monotecnica"
        //$this->assertEqual($this->FondoTemporal->compara_tipoInstit('Misi�n Monot�cnica y de Cultura Rural y Dom�stica N� 15 San Salvador', $this->tipoInstits), 221);

        $this->assertEqual($this->FondoTemporal->compara_tipoInstit('Esc Ed T N� 15 Maip�', $this->tipoInstits), 0);
    }

    function testCompara_institNombres() {
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET N� 15 Maip�', 'EET N� 015 Maip�', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET N� 15 Maip�', 'eet N� 15 Meip�', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET N� 15 Maip�', 'iet N� 15 Meip�', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('C.E.N.T. N� 2 Clotilde Mercedes G. De Fern�ndez', 'CENT N� 2 Clotilde Mercedes G. De Fern�ndez', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('C.E.N.T. N� 2 Clotilde Mercedes G. De Fern�ndez', 'CENT N� 2 Clotilde g De Fern�ndez', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('C.E.N.T. N� 2 Clotilde Mercedes G. De Fern�ndez - anexo', 'CENT N� 2 Clotilde Mercedes G. De Fern�ndez - anexo', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Escuela Polimodal N� 6 Jos� Hern�ndez', 'JOS� HERN�NDEZ', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Escuela Polimodal N� 4 Ernesto S�bato', 'ERNESTO S�BATO', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('E.E.T. N� Marco Silvio Ghiglione - ', 'MARCOS SILVIO GHIGLIONE', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Escuela de Educaci�n T�cnica N� 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('escuela N� 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('centro educativo de nivel terciario N� 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('Instituto DE Educaci�n superior de COMercio N� 21 Juan Bautista Alberdi - ', 'JUAN BAUTISTA ALBERDI', $this->tipoInstits));
        $this->assertTrue($this->FondoTemporal->compara_institNombres('EET N� 45 TEC F�lix Bourren Meyer', 'F�LIX BOURREN MEYER', $this->tipoInstits));
        
        //Escuela T�cnica N� 34 Ing. Enrique Mart�n Hermitte
        // en duda por "de" 2 veces $this->assertFalse($this->FondoTemporal->compara_institNombres('Escuela de Educaci�n T�cnica Teolinda Romero de Sotomayor - 25 de Mayo', '25 DE MAYO', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('EEM N� 220 Ing. Agr. Mariano J. Frezzi R�o Segundo', 'INGENIERO AGR�NOMO J. FREZZI', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Misi�n Monot�cnica y de Extensi�n Cultural N� 4 Robles', '', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Misi�n Monot�cnica y de Extensi�n Cultural N� 2 - Santo Domingo', '', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('EET N� 15 Maip�', 'eet N� 15 Meeip�', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Esc N� 15 Maip�', 'EET N� 15 Maip�', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('Esc Ed T N� 15 Maip�', 'EET N� 15 Maip�', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('ET N� 1 - Santa Luc�a', 'ET N� 1 - Anexo Santa Luc�a', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('C.E.N.T. N� 2 Clotilde Mercedes G. De Fern�ndez', 'CENT N� 2 Clotilde Mercedes G. De Fern�ndez anexo', $this->tipoInstits));
        $this->assertFalse($this->FondoTemporal->compara_institNombres('C.E.N.T. N� 2 Clotilde Mercedes G. De Fern�ndez - anexo', 'CENT N� 2 Clotilde Mercedes G. De Fern�ndez', $this->tipoInstits));
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
        //$this->assertEqual($this->FondoTemporal->validarInstit($fondos[6], $instits, $this->tipoInstits), 1); // no chequea el N� P-34
        $this->assertEqual($this->FondoTemporal->validarInstit($fondos[7], $instits, $this->tipoInstits), 0);
    }
}
?>