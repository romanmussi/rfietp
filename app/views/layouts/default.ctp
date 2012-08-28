<?php
/* SVN FILE: $Id: default.ctp 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // // HTTP/1.1
header("Pragma: no-cache");
header("Expires: Mon, 17 Dec 2007 00:00:00 GMT"); // Date in the past

/* @var $html HtmlHelper */
$html;
/* @var $javascript JavascriptHelper */
$javascript;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $html->charset(); ?>
        <title>
            <?php __('Sistema Gestión de Registro - ');
            echo Configure::read('regetpVersion')." - "; ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $html->meta('icon');
        echo $html->css('regetp','stylesheet', array('media'=>'screen'));
        echo $html->css('printer','stylesheet', array('media'=>'print'));
        
        $cssRole = WWW_ROOT.'css'.DS.'role'.DS.$session->read('Auth.User.role').'.css';
        if (file_exists($cssRole)) {
            echo $html->css('role/'.$session->read('Auth.User.role'),'stylesheet', array('media'=>'screen'));
        }

        echo $javascript->link(array(
        'jquery-1.4.2.min',
        'jquery.form',
        'jquery.tools.min',
        'views/layout/default',
        'jquery-ui-1.8.5.custom.min',
        ));

        $jsPoner = 'views/'.Inflector::underscore($this->name).'/'.$this->action;
        $jsView = WWW_ROOT.'js'.DS.$jsPoner;
        if (file_exists($jsView.'.js')) {
             echo $javascript->link($jsPoner);
        }


        echo $scripts_for_layout;

        ?>
        <script type="text/javascript">

            jQuery(document).ready(function () {
                <?php
                if (!$session->check('Auth.User') || $session->read('User.group_alias') == 'invitados') {
                ?>
                        jQuery('.menu_body').show();
                <?php
                }
                ?>
            });
        </script>
        

        
        <!--[if IE 7]>
        <style type="text/css">
            .horizontal-shadetabs a {
                display: block;
                height: 28px;
            }
        </style>
        <![endif]-->

        <!--[if IE 6]>
        <?php echo $html->css('ie6fix');?>
        <![endif]-->

        <!--        Permisos ACL segun el grupo del usuario         -->
        <style type="text/css">
            .acl-<?php echo $session->read('User.group_alias')?>{
                display: block !important;
            }
        </style>
    </head>


    <body class="<?php if (Configure::read('debug')): ?>debug<?php endif ?>">
        <?
        /*
            if (strpos($_SERVER['HTTP_HOST'], '168.83.20.') !== false) {
        ?>
            <script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
        <?
            }
          */
         
        if ($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1') {

            include_once(APP_DIR . "/config/frases.php");
                $keyoftheday = ((date('j') * date('n')) + date('j') + date('n')) % (count($frasesValle)-1);
        ?>

        <div style="background-color: red; height: 20px; text-align: center">MODO LOCALHOST</div>
        <div style="background-color: #DBEBF6; border:1px solid white; font-size:9pt; height: 20px; text-align: center">Frase Valle del día
                <?=$html->image('quote.png', array(
                                'style'=>'vertical-align: top;',
                                'alt'=> 'Frases Valle del día',
                                'border'=>"0",
                                ))?>
            <?=$frasesValle[$keyoftheday]?>
        </div>
        <? }?>


        <div id="container">

            <?php $headerClass = (Configure::read('es_dia_patrio'))?"patrio":"";?>
            <div id="header" class="<?php echo $headerClass; ?>" >
                <h1>
                    <?php echo $html->link(__('Registro Federal de Instituciones de Educación Técnico Profesional (RFIETP)', true), '/pages/home', array('class'=>'mainlink')); ?>
                </h1>
                <?php if ($session->check('Auth.User')) { ?>
                <div id="header_right">
                        <?php echo $html->link('<img src="'.$html->url("/img/editprofile.png").'" border="0" align="absmiddle" />','/users/self_user_edit/'.$session->read('Auth.User.id'), array('class'=>'userlinks'), false, false); ?> <?php echo $html->link('Mis datos','/users/self_user_edit/'.$session->read('Auth.User.id'), array('class'=>'userlinks'), false, false); ?> ·
                        <?php echo $html->link('<img src="'.$html->url("/img/changepassword.gif").'" border="0" align="absmiddle" />','/users/cambiar_password/'.$session->read('Auth.User.id'), array('class'=>'userlinks'), false, false); ?> <?php echo $html->link('Cambiar contraseña','/users/cambiar_password/'.$session->read('Auth.User.id'), array('class'=>'userlinks'), false, false); ?> ·
                        <?php echo $html->link('<img src="'.$html->url("/img/exit.gif").'" border="0" align="absmiddle" />','/users/logout', array('class'=>'userlinks'), false, false); ?> <?php echo $html->link('Salir','/users/logout', array('class'=>'userlinks', 'onclick'=>'javascript: borrarCookies();'), false, false); ?>
                </div>
                <?     } ?>
            </div>


            <div id="content">

                <div id="menu">
                <?
                    echo $this->renderElement('menu/boxSaludo');
                    echo $this->renderElement('menu/boxDesarrollo');
                    echo $this->renderElement('menu/boxInstituciones');
                    echo $this->renderElement('menu/boxJurisdicciones');
                    echo $this->renderElement('menu/boxTitulos');
                    echo $this->renderElement('menu/boxCuadros');
                    echo $this->renderElement('menu/boxInformacion');
                    echo $this->renderElement('menu/boxDepurador');
                    echo $this->renderElement('menu/boxTickets');
                    echo $this->renderElement('menu/boxFondo');
                    echo $this->renderElement('menu/boxAdmin');
                    echo $this->renderElement('menu/boxLogin');
                    echo $this->renderElement('menu/boxSoporteTecnico');
                ?>
                </div>

                <div id="cuerpo">
                    <div id="cuerpo_top">
                        <div id="cuerpo_top_left">
                            <?  echo $this->renderElement('rutaUrl', array("ruta" => $rutaUrl_for_layout)); ?>
                        </div>
                    </div>
                    <div id="main-content">
                        <?php $session->flash(); ?>
                        <?php $session->flash('auth'); ?>
                        <?php echo $content_for_layout; ?>
                    </div>
                </div>

            </div> <!-- FIN div #content -->


        </div> <!-- FIN div #container -->

        <div id="footer">
            <?php echo $html->image('ministerioeduc_logo.png', array(
                                'style'=>'vertical-align:middle;margin-left:5px; float:left;',
                                'alt'=> __("Ministerio de Educación de la Nación", true),
                                'border'=>"0",
                                )
                  );
            ?>
            <p style="float:left;color:#003d5c;font-size:8pt;padding-left:110px; padding-top:10px; vertical-align: middle;font-weight: bold" >Instituto Nacional de Educación Tecnológica</p>
            <?php echo $html->link(
                        $html->image('logoinet1.gif', array(
                                'style'=>'vertical-align:middle;width:70px;margin-right:10px',
                                'alt'=> __("Inet", true),
                                'border'=>"0"
                                )),
                        'http://www.inet.edu.ar',
                        array(
                            'target'=>'_blank'),
                        null,
                        false
                );
            ?>
        </div>

        <?php echo $html->link(
                $html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0", 'style'=>'float:right;margin-right:130px')),
                'http://www.cakephp.org/',
                array(
                    'target'=>'_blank',
                    'id'=>'logo-cake-php'),
                null,
                false
        ); ?>

        <?php echo $cakeDebug; ?>
    </body>

</html>
