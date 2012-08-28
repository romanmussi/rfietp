var etapas = new Array();

function EtapaAdd() {
    var i = etapas.length;
    
    etapa = { id: jQuery("#estructura_plan_anio_id").val(),
              etapa_id: jQuery("#etapa_id").val(),
              etapa_nombre: urlencode(jQuery('#etapa_id :selected').text()),
              edad_teorica: jQuery("#edad_teorica").val(),
              alias: urlencode(jQuery("#alias").val()),
              nro_anio: jQuery("#nro_anio").val(),
              anio_escolaridad: jQuery("#anio_escolaridad").val() };

     if (!EtapaExists(etapa)) {
        // guarda la etapa
        if (jQuery("#anio_id").val()) {
            // edit
            etapas[jQuery("#anio_id").val()] = etapa;
        }
        else {
            // add
            etapas[i] = etapa;
        }

        etapas.sort(sortfcn);

        RefreshEtapasTree();
     }
     else {
        alert('El año ya existe');
     }

    jQuery("#add").val('Agregar año');

    ResetForm();

    // traba etapa
    jQuery('#etapa_id').attr('disabled', true);
}

function EtapaAddObject(etapa) {
    var i = etapas.length;

    etapa = { id: etapa.id,
              etapa_id: etapa.etapa_id,
              etapa_nombre: etapa.etapa_nombre,
              edad_teorica: etapa.edad_teorica,
              nro_anio: etapa.nro_anio,
              alias: etapa.alias,
              anio_escolaridad: etapa.anio_escolaridad };

    if (!EtapaExists(etapa)) {
        // guarda la etapa
        etapas[i] = etapa;

        etapas.sort(sortfcn);

        RefreshEtapasTree();
    }
}

function EtapaDel(id) {
    var etapas_aux = new Array();
    var i = 0;
    jQuery.each(etapas, function(key, value) {
        if (key != id) {
            etapas_aux[i] = value;
            i++;
        }
    });

    etapas = etapas_aux;

    RefreshEtapasTree();
}

function EtapaEdit(id) {
    jQuery("#estructura_plan_anio_id").val(etapas[id]['id']);
    jQuery("#edad_teorica").val(etapas[id]['edad_teorica']);
    jQuery("#nro_anio").val(etapas[id]['nro_anio']);
    jQuery("#anio_escolaridad").val(etapas[id]['anio_escolaridad']);
    jQuery("#alias").val(urldecode(etapas[id]['alias']));

    jQuery("#anio_id").val(id);

    jQuery("#add").val('Editar año');
}

function EtapaExists(etapa) {
    for (var j=0; j < etapas.length; j++) {
        if ((etapas[j]['edad_teorica'] == etapa['edad_teorica'] ||
            etapas[j]['nro_anio'] == etapa['nro_anio']) && etapas[j]['id'] != etapa['id']) {
                return 1;
        }
    }

    return 0;
}

function RefreshEtapasTree() {
    // refresca el arbol de etapas
    jQuery("#etapas-tree").html("");
    jQuery.each(etapas, function(key, value) {
        jQuery("#etapas-tree").append("<li>"+urldecode(value['etapa_nombre'])+" "+value['nro_anio']+" [<a style='cursor:pointer;' onclick='javascript: EtapaEdit("+key+")'>editar</a>]</li>");
    });
    // eliminado:
    // [<a style='cursor:pointer;' onclick='javascript: EtapaDel("+key+")'>-</a>]
}

function ResetForm() {
    // resetea el form
    jQuery("#estructura_plan_anio_id").val('');
    jQuery("#edad_teorica").val('');
    jQuery("#nro_anio").val('');
    jQuery("#anio_escolaridad").val('');
    jQuery("#anio_id").val('');
    jQuery("#alias").val('');
}

function sortfcn(a,b){
     if(parseInt(a['edad_teorica'])<parseInt(b['edad_teorica'])){
        return -1;
     }
     else if(parseInt(a['edad_teorica'])>parseInt(b['edad_teorica'])){
        return 1;
     }
     else{
        return 0;
     }
}

function EtapasASubmit() {
    // debe tener por lo menos un año
    if (etapas.length == 0) {
        alert('La estructura debe tener al menos un año');
        return false;
    }
    // pasa vector etapas para submitear
    jQuery("#etapas").val(array2dToJson(etapas, 'object'));

    // rehabilita el select para mandar value por submit
    jQuery('#etapa_id').attr('disabled', false);

    return true;
}

function urlencode(str) {
    str = escape(str);
    str = str.replace('+', '%2B');
    str = str.replace('%20', '+');
    str = str.replace('*', '%2A');
    str = str.replace('/', '%2F');
    str = str.replace('@', '%40');
    return str;
}

function urldecode(str) {
    str = str.replace('+', ' ');
    str = unescape(str);
    return str;
}