function inicializa() {
    $("#nrotarjeta").focus();
    
    
    /*$("#nrotarjeta").on('keypress', function (e) {
     if (e.which == 13) {
     alert('You pressed enter!');
     }
     });*/
}

var payload = {};

var udateTime = function () {
    let currentDate = new Date(),
            hours = currentDate.getHours(),
            minutes = currentDate.getMinutes(),
            seconds = currentDate.getSeconds(),
            weekDay = currentDate.getDay(),
            day = currentDate.getDate(),
            month = currentDate.getMonth(),
            year = currentDate.getFullYear();
    //console.log(currentDate.getDate() );
    const weekDays = [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sabado'
    ];

    document.getElementById('weekDay').textContent = weekDays[weekDay];
    document.getElementById('day').textContent = day;

    const months = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];

    document.getElementById('month').textContent = months[month];
    document.getElementById('year').textContent = year;

    document.getElementById('hours').textContent = hours;

    if (minutes < 10) {
        minutes = "0" + minutes
    }

    if (seconds < 10) {
        seconds = "0" + seconds
    }

    document.getElementById('minutes').textContent = minutes;
    document.getElementById('seconds').textContent = seconds;
};

udateTime();

setInterval(udateTime, 1000);

/*** GUARDAR TARJETA***/
function verificaTarjetaAjax() {

    payload['COD_TARJETA'] = $("#nrotarjeta").val();
    payload['COD_EMPLEADO'] = $("#cod_empleado").val();
    payload['OBSERVACION'] = $("#OBSERVACION").val();
    //console.log(JSON.stringify(payload));
    var pDatosFormulario = JSON.stringify(payload);
    var pUrl = "api/validaTarjeta";
    var pBeforeSend = "";
    var pSucces = "verificaTarjetaAjaxSuccess(json)";
    var pError = "ajax_error()";
    var pComplete = "";
    ajax(pDatosFormulario, pUrl, pBeforeSend, pSucces, pError, pComplete);
}

function verificaTarjetaAjaxSuccess(json) {
    var datos = "";
    //console.log(json);
    $datos = json;
    //console.log($datos);

    if ($datos.RESULTADO === "N") {
        swalErrorComida('', $datos.MENSAJE);
        $('#nrotarjeta').val("");
    } else if ($datos.RESULTADO === "S") {
        swalCorrectoComida('', $datos.MENSAJE);
        $('#nrotarjeta').val("");
    } else if ($datos.RESULTADO === "E") {
        swalErrorComida('', $datos.MENSAJE);
        $('#nrotarjeta').val("");
    } else if ($datos.RESULTADO === "M") {
        cargaEmpleado();
    }
    

    /*$('#PRECIO_UNITARIO_AGREGAR').val(datos.PRECIO);
     $('#CANTIDAD_AGREGAR').val(1);
     $('#CANTIDAD_AGREGAR').focus();*/
}

/***** /GUARDAR TARJETA******/

function cargaEmpleado() {
    $('#cargaEmpleado').append('<div id="modalCargaEmpleado"></div>');
    $.get("carga_empleado.html", function (htmlexterno) {
        $("#modalCargaEmpleado").html(htmlexterno);
        //console.log((('Modal: ' + $("#modalBienes").html());
        $('#divModal').modal('show');
        setTimeout(()=> $('#cod_empleado').focus(),500);
        
        $('#divModal').on('hidden.bs.modal', function (e) {
            $('#modalCargaEmpleado').remove();
            $('#nrotarjeta').val("");
            $('#nrotarjeta').focus();
        });
    });
}


function salir_empleado_modal() {
        $("#botonCancelarEmpleados").click();
    }

