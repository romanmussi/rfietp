<?php

$name = (empty($name)) ? 'descarga' : $name;
//header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".Inflector::slug($name)."-".date("d-m-Y").".xls");
//header("Pragma: no-cache");
//header("Expires: 0");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
    <head>
        <?php
        echo $html->charset();
        echo $html->meta('icon');
        ?>
        <title><?php echo $name?></title>
        <META NAME="GENERATOR" CONTENT="PQuery Report">
        <META NAME="CHANGED" CONTENT="0;0">

        <STYLE>
		<!-- 
		BODY,DIV,TABLE,THEAD,TBODY,TFOOT,TR,TH,TD,P { font-family:"Arial"; font-size:x-small }
		 -->
	</STYLE>

    </head>

    <BODY TEXT="#000000">      
        
        <?php echo $content_for_layout ?>
        <!-- ************************************************************************** -->
    </BODY>

</HTML>
