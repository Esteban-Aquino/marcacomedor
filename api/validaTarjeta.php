<?php

/**
 * Lista Metodos de Pago
 * Esteban Aquino 25-11-2019
 */
require_once '../config/operacionesDB.php';
require_once 'sharedFunctions.php';

$json_str = file_get_contents('php://input');
$json_obj = json_decode(utf8_converter_sting($json_str), true);

$cod_tarjeta = $json_obj["COD_TARJETA"];
$id_comensal = $json_obj["COD_EMPLEADO"];
$observacion = $json_obj["OBSERVACION"];

//echo $cod_tarjeta;
//PRINT_r($json_str);
if (nvl($cod_tarjeta, "N") === "N"  ) {
    $mens = "No se encuentra numero de tarjeta.";
}

if (nvl($mens,'N') === 'N') {
    $datos = operacionesDB::validaTarjeta($cod_tarjeta, $id_comensal, $observacion);
    $respuesta = $datos;
} else {
    $respuesta["MENSAJE"] = $mens;
}


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
print json_encode(utf8_converter($respuesta));
