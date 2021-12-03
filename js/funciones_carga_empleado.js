$(document).ready(function () {
        inicializarEmpleado();
        //editable();
    });
    function inicializarEmpleado() {
        $('#cod_empleado').on('keydown', function (event) { // funcion callback , anonima
            //console.log(event.which);
            if (event.which === 120) {
                listarEmpleados();
            } else if (event.which === 13) {
                if (empty($("#cod_empleado").val())) {
                    swalErrorComida('', 'Debe seleccionar una persona');
                    $("#cod_empleado").val("");
                    $("#NOM_EMPLEADO").val("");
                    $("#cod_empleado").focus();
                } else {
                    validarEmpleadosAjax();
                }
                
            }
            ;
        });
        $('[data-toggle="tooltip"]').tooltip();
        
        siguienteCampo('#cod_empleado', '#botonGuardar', true); 

    }
    /****EMPLEADOS*****/
    function listarEmpleados() {
        $('#buscado').append('<div id="modalEmpleados"></div>');
        $.get("buscar_empleado.html", function (htmlexterno) {
            $("#modalEmpleados").html(htmlexterno);
            $("#buscar_texto").on('change', function () {
                //console.log("Call - ListarEmpleados");
                $('#pagina').val(1);
                listarEmpleadosAjax("");
            });
            //console.log((('Modal: ' + $("#modalBienes").html());
            $('#divModalEmpleado').modal('show');
            $('#divModalEmpleado').on('hidden.bs.modal', function (e) {
                $('#modalEmpleados').remove();
                $("#cod_empleado").focus();
            });
        });
    }

    function listarEmpleadosAjax() {
        var pDatosFormulario = "";
        pDatosFormulario = $("#form-buscar").serialize();
        //console.log("ListarEmpleados");
        //console.log(pDatosFormulario);
        var pUrl = "api/getempleados";
        var pBeforeSend = "";
        var pSucces = "listarEmpleadosAjaxSuccess(json)";
        var pError = "ajax_error()";
        var pComplete = "";
        ajax(pDatosFormulario, pUrl, pBeforeSend, pSucces, pError, pComplete);
    }

    function listarEmpleadosAjaxSuccess(json) {
        var datos = "";
        //console.log(json);
        $datos = json["datos"];
        $.each($datos, function (key, value) {
            datos += "<tr onclick='seleccionar_empleado($(this))'>";
            datos += "<td class='manito'>" + value.CODIGO + "</td>";
            datos += "<td class='manito'>" + value.NOMBRE + "</td>";
            datos += "</tr>";
        });
        if (datos === '') {
            datos += "<tr><td colspan='4'>No existen mas registros ...</td></tr>";
        }
        $('#tbody_listar').html(datos);
    }

    function seleccionar_empleado($this) {
        //console.log($this.find('td'));
        var cod_empleado = $this.find('td').eq(0).text();
        var NOMBRE = $this.find('td').eq(1).text();
        $("#cod_empleado").val(cod_empleado);
        $("#NOM_EMPLEADO").val(NOMBRE);

        $("#cod_empleado").focus();
        salir_busqueda_modal();
    }

    function salir_busqueda_modal() {
        $("#botonCancelar").click();
    }
    
    /*******************/
    function validarEmpleadosAjax() {
        var pDatosFormulario = "";
        pDatosFormulario = $("#carga_empleado").serialize();
        //console.log("ListarEmpleados");
        //console.log(pDatosFormulario);
        var pUrl = "api/getempleados";
        var pBeforeSend = "";
        var pSucces = "validarEmpleadosAjaxSuccess(json)";
        var pError = "ajax_error()";
        var pComplete = "";
        ajax(pDatosFormulario, pUrl, pBeforeSend, pSucces, pError, pComplete);
    }

    function validarEmpleadosAjaxSuccess(json) {
        var $datos = "";
        $datos = json["datos"];
        //console.log("validarEmpleadosAjaxSuccess");
        if (!empty($datos)) {
           $("#cod_empleado").val($datos[0].CODIGO);
           $("#NOM_EMPLEADO").val($datos[0].NOMBRE);
           $("#OBSERVACION").focus();
        } else {
           swalError('', 'No se encuentra empleado seleccionado'); 
           $("#cod_empleado").val("");
           $("#NOM_EMPLEADO").val("");
        }
        
        
    }
    
    function guardar_empleado() {
        validarCarga();
    }
    
    function validarCarga() {
        if (empty($("#cod_empleado").val())) {
            swalErrorComida('', 'Debe seleccionar una persona');
            $("#cod_empleado").val("");
            $("#NOM_EMPLEADO").val("");
            $("#cod_empleado").focus();
        } else {
            verificaTarjetaAjax();
            salir_empleado_modal();
        }
    }
    /*** /EMPLEADOS ***/
    
    