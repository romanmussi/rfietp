<script type="text/javascript">
    /**
     * me dice si ya fue apretado el link Ver Pendientes,
     * en tal caso, no me vuelve a hacer un Request, simplemente oculto el div
     * y listo!
     */
    var apretado = false;

    var options = {
        target:        '#tickets',   // target element(s) to be updated with server response
        url: '<? echo $html->url('/tickets/provincias_pendientes')?>',
        beforeSubmit: showList
    };

    function showList(){
         jQuery('#tickets').toggle();
    }
</script>

<div id="boxTickets" class="acl acl-editores acl-desarrolladores">
	<h1 id="boxTickets" class="menu_head">Pendientes de Actualización</h1>
	<ul class="menu_body">
            <form id="pendientes" method="post">
            </form>
            <div id="tickets" style="display: none;">
                <div style="background-color: rgb(204, 221, 235);">
                    <li>
                        <a href="#">Cargando...</a></li>
                    <li>
                </div>
            </div>
        </ul>
</div>	