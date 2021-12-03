<?php

    /**
    * Trae datos de cliente 
    * Esteban Aquino 10-05-2021
    */
    require_once '../config/operacionesDB.php';
    require_once 'sharedFunctions.php';
    # Obtener headers
        
        $id_comensal = NVL($_POST["cod_empleado"], "");
        $busqueda = NVL($_POST["buscar_texto"], "");
        $pag = NVL($_POST["pagina"], 1);

        //print ($cod_empleado);
        $datos = operacionesDB::ListarComensales($busqueda, $pag, $id_comensal);
        
        $respuesta["datos"] = $datos;
        $respuesta["mensaje"] = '';

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    print json_encode($respuesta);