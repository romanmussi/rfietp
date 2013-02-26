<!--[if IE 5]>

<h2 style="color: red">¡¡ ATENCIÓN !! La versión del Internet Explorer no es compatible con ésta web</h2>

<p style="border: red solid 1px; padding: 5px">
Estas usando una versión vieja del Internet Explorer y no te permitirá visualizar y utilizar normalmente ésta página.
El Departamento de Sistemas recomienda usar Firefox para lograr una navegación más rápida y segura.<br />
<a href="http://download.mozilla.org/?product=firefox-3.0.8&os=win&lang=es-ES">Descargar Firefox</a><br /><br />

Requerimientos mínimos para utilizar el <b>Sistema Gestión de Registro</b>:<br />
-: Internet Explorer 6 o superior<br />
-: Mozilla Firefox 2.0 o superior

</p>
<![endif]--> 

<h1>Bienvenido al RFIETP</h1>

<br />

<h2>Versión <?php echo Configure::read('regetpVersion');?></h2>

<p>Desde su puesta en funcionamiento en junio de 2009 el sistema RFIETP se encuentra en permanente actualización y mejoramiento, tanto del contenido de información de la base de datos como de la aplicación que permite su gestión. En esa línea de trabajo a partir del 26 de Febrero de 2013 se ha instalado la versión  <?php echo Configure::read('regetpVersion');?> del sistema. Sus principales novedades son:</p>
<ul>
	<li>A las instituciones con dependencia nacional se agregó a su nombre entre paréntesis el nombre de la dependencia</li>
</ul>

<br />

Un listado completo de las modificaciones realizadas en esta última versión, puede encontrarlas haciendo click
<? echo $html->link('aquí','/pages/detalle_versiones')?>.
</p>

<br/>
<hr/>
<br/>

<?php echo $this->element('contacto'); ?>
