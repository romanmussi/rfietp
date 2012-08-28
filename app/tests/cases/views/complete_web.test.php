<?php
require_once('cake_web_test_case_with_fixtures.php');
require_once dirname(__FILE__) . DS . '..' . DS . 'extra_functions.php';

class CompleteWebTestCase extends CakeWebTestCaseWithFixtures {
    var $baseUrl = "regetp";
    var $fixtures = array();

    function __construct(){
        $this->fixtures = getAllFixtures();
    }


    function enterApplication() {
        $this->get('http://' . $_SERVER['HTTP_HOST'] . '/' . $this->baseUrl);
        //$this->assertText('Registro Federal de Instituciones de Educación Técnico Profesional (RFIETP)');
    }

    function getBlankLoginForm() {
        $this->get("http://localhost/regetp/users/login");
        $this->setField('data[User][username]', '');
        $this->setField('data[User][password]', '');
    }

    function testIncorrectLogin() {
        /*$this->getBlankLoginForm();
        $this->setField('data[User][username]', 'FOO');
        $this->setField('data[User][password]', 'BAR');

        $this->clickSubmit('Entrar');
        $this->assertText('Usuario o Contraseña Incorrectos');
        */
        $data = array(
              "data[User][username]" => "avilarconsulta",
              "data[User][password]" => "123"
        );

        $this->post("http://localhost/regetp/users/login", $data);

        $this->assertText('Usuario o Contraseña Incorrectos');
    }

    function testCorrectLogin() {
        $data = array(
              "data[User][username]" => "avilar",
              "data[User][password]" => "prueba"
        );

        $this->post("http://localhost/regetp/users/login", $data);

        $this->assertNoText('Usuario o Contraseña Incorrectos');
    }

    function testCreateInstit(){
        $instit =& ClassRegistry::init('Instit');

        $this->getBlankLoginForm();
        $this->setField('data[User][username]', 'avilareditor');
        $this->setField('data[User][password]', 'prueba');
        $this->clickSubmit('Entrar');
        $this->assertNoText('Usuario o Contraseña Incorrectos');

        // para que siempre guarde un instit y no falle el test
        $instit->recursive = -1;
        $existe = true;
        do {
            $cue = 14*100000 + rand(10000, 99999);
            $res = $instit->find('first', array('conditions' => array('Instit.cue' => $cue)));
            if (empty($res)) {
                $existe = false;
            }
        } while ($existe);

        $data = array(
            "data[Instit][activo]" => "1",
            "data[Instit][cue]" => $cue, // cambia el CUE cada vez que testea
            "data[Instit][anexo]" => "0",
            "data[Instit][esanexo]" => "0",
            "data[Instit][gestion_id]" => "1",
            "data[Instit][dependencia_id]" => "1",
            "data[Instit][nombre_dep]" => "Dep 3",
            "data[Instit][claseinstit_id]" => "3",
            "data[Instit][etp_estado_id]" => "2",
            "data[Instit][orientacion_id]" => "",
            "data[Instit][jurisdiccion_id]" => "14",
            "data[Instit][departamento_id]" => "173",
            "data[Instit][localidad_id]" => "457",
            "data[Instit][lugar]" => "Comuna 12",
            "data[Instit][tipoinstit_id]" => "96",
            "data[Instit][nombre]" => "Jose Saturnino Cardozo",
            "data[Instit][nroinstit]" => "23",
            "data[Instit][anio_creacion]" => "1990",
            "data[Instit][direccion]" => "Amuchin 2234",
            "data[Instit][cp]" => "234",
            "data[Instit][telefono]" => "234-234234",
            "data[Instit][telefono_alternativo]" => "234-224234",
            "data[Instit][mail]" => "astorcin@amu.com",
            "data[Instit][mail_alternativo]" => "jojo@amu.com",
            "data[Instit][web]" => "www.tacuara.com",
            "data[Instit][dir_nombre]" => "Justiniano Molina",
            "data[Instit][dir_tipodoc_id]" => "1",
            "data[Instit][dir_nrodoc]" => "23423423",
            "data[Instit][dir_telefono]" => "234233",
            "data[Instit][dir_mail]" => "justi@js.com",
            "data[Instit][vice_nombre]" => "Amor Ameal",
            "data[Instit][vice_tipodoc_id]" => "1",
            "data[Instit][vice_nrodoc]" => "12323123",
            "data[Instit][actualizacion]" => "2010",
            "data[Instit][observacion]" => "prueba testing!",
            "data[Instit][ciclo_alta]" => "2010"
        );

        $this->post("http://localhost/regetp/instits/add", $data);

        $this->assertText('Se ha guardado la Institución');
        $this->assertNoText('Usted no tiene permisos para acceder a esta página');
    }


    function testCreatePlanSecTec(){
        $this->getBlankLoginForm();
        $this->setField('data[User][username]', 'avilareditor');
        $this->setField('data[User][password]', 'prueba');
        $this->clickSubmit('Entrar');
        $this->assertNoText('Usuario o Contraseña Incorrectos');

        $data = array(
            "data[Plan][instit_id]" => 3506,
            "data[Plan][oferta_id]" => 3,
            "data[Plan][estructura_plan_id]" => 8,
            "data[Plan][norma]" => "NOMENCLADOR DEA Y FP",
            "data[Plan][nombre]" => "Plan TESTING",
            "data[Plan][perfil]" => "Perfil TESTING",
            "data[Plan][tituloName]" => "Técnico en Producción Agropecuaria con Especialización en Enología",
            "data[Plan][titulo_id]" => 55,
            "data[Plan][duracion_hs]" => "234",
            "data[Plan][duracion_anios]" => "3",
            "data[Plan][observacion]" => "*** prueba ***",
            "data[Plan][ciclo_alta]" => "2010"
        );

        $this->post("http://localhost/regetp/planes/add/3506", $data);

        $this->assertText('Se ha creado un nuevo Plan');
    }

}

?>