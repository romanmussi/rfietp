<div id="boxAyuda" style="display:block;clear:both">
    <!--
        <div id="boxAyuda" class="menu_head_open help_head">
            <?php echo $html->image('help.png', array('alt' => 'Ayuda','style'=>'float:left;display:inline; margin: 0px 10px;'))?>
            <span>Ayuda</span>
        </div>
    -->
        <ul class="menu_body help_body">
                <br/>
                <P LANG="es-ES" CLASS="western" STYLE="margin-bottom: 0cm"><SPAN LANG="es-ES">Puede
                buscar por CUE</SPAN><SPAN LANG="es-ES">
                (con &oacute; sin n&uacute;mero de anexo) &oacute; por parte del CUE.
                </SPAN>
                </P>
                <P LANG="es-ES" CLASS="western" STYLE="margin-bottom: 0cm"><SPAN LANG="es-ES">Ej</SPAN><SPAN LANG="es-ES">emplos:
                </SPAN>
                </P>
                <TABLE style="background-color: transparent;">
                        <COL >
                        <COL >
                        <TR VALIGN=TOP>
                                <TD >
                                        <B>Si
                                        ingresa</B>
                                </TD>
                                <TD >
                                        <B>Busca
                                        por</B>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        282
                                <TD>
                                        <SPAN LANG="es-ES">P</SPAN><SPAN LANG="es-ES">arte
                                        del CUE</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        3000282
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">CUE
                                        completo sin considerar n&uacute;mero de anexo</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        300028200
                                </TD>
                                <TD>
                                        CUE
                                        con n&uacute;mero de anexo
                                </TD>
                        </TR>
                </TABLE>
                <P LANG="es-ES" CLASS="western" STYLE="margin-bottom: 0cm"><SPAN LANG="es-ES">Tambi&eacute;n
                puede buscar por tipo de establecimiento, n&uacute;mero y nombre
                propio de la instituci&oacute;n</SPAN><SPAN LANG="es-ES">.
                El buscador ignora may&uacute;sculas / min&uacute;sculas y letras
                acentuadas para mejorar los resultados.</SPAN></P>
                <P LANG="es-ES" CLASS="western" STYLE="margin-bottom: 0cm"><SPAN LANG="es-ES">Ej</SPAN><SPAN LANG="es-ES">emplos:</SPAN></P>
                <TABLE style="background-color: transparent;">
                        <COL >
                        <COL >
                        <TR VALIGN=TOP>
                                <TD >
                                        <B>Si
                                        ingresa</B>
                                </TD>
                                <TD >
                                        <B>Busca
                                        por</B>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        escuela
                                        t&eacute;cnica
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">T</SPAN><SPAN LANG="es-ES">ipo
                                        de instituci&oacute;n</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        E.E.T.
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">T</SPAN><SPAN LANG="es-ES">ipo
                                        de instituci&oacute;n en formato abreviado</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        EET
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">T</SPAN><SPAN LANG="es-ES">ipo
                                        de instituci&oacute;n en formato abreviado sin puntos</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        tecnica
                                        18
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">T</SPAN><SPAN LANG="es-ES">ipo
                                        y n&uacute;mero de instituci&oacute;n</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        savio
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">P</SPAN><SPAN LANG="es-ES">arte
                                        del nombre de la instituci&oacute;n</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        T&eacute;cnica
                                        Savio
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">T</SPAN><SPAN LANG="es-ES">ipo
                                        de instituci&oacute;n y parte del nombre</SPAN>
                                </TD>
                        </TR>
                        <TR VALIGN=TOP>
                                <TD>
                                        escuela
                                        tecnica general savio
                                </TD>
                                <TD>
                                        <SPAN LANG="es-ES">T</SPAN><SPAN LANG="es-ES">ipo
                                        de instituci&oacute;n y parte del nombre</SPAN>
                                </TD>
                        </TR>
                </TABLE>
                <P LANG="es-ES" CLASS="western" STYLE="margin-bottom: 0cm"><SPAN LANG="es-ES">Puede
                utilizar las combinaciones que prefiera.</SPAN><SPAN LANG="es-ES">
                Pruebe comenzando con criterios m&iacute;nimos y vaya refinando la
                b&uacute;squeda si obtiene demasiados resultados.</SPAN></P>
                <P LANG="es-ES" CLASS="western" STYLE="margin-bottom: 0cm"><SPAN LANG="es-ES">Si
                necesita definir </SPAN><SPAN LANG="es-ES">m&aacute;s
                criterios (departamento, localidad, tipo de oferta del
                establecimiento, etc.) realice una </SPAN><SPAN LANG="es-ES">
                <?php
                            echo $html->link('Búsqueda avanzada','advanced_search_form',array(
                                             'div'=>false));
                ?>
                        </SPAN><SPAN LANG="es-ES">.</SPAN></P>

        </ul>
    </div>