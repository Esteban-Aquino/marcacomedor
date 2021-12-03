<?php

/**
 * Todas las interacciones con la base de datos se coloca aqui
 * Esteban Aquino 30/09/2019
 */
require 'oraconnect.php';
require 'util.php';

class operacionesDB {

    function __construct() {
        
    }

    public static function buscaParametro($cod_modulo, $cod_parametro) {
        try {
            $result = [];
            $sql = "begin :res := bs_busca_parametro(:cod_modulo, :cod_parametro); end;";

            $comando = oraconnect::getInstance()->getDb()->prepare($sql);
            $comando->bindParam(':res', $result, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 400);
            $comando->bindParam(':cod_modulo', $cod_modulo, PDO::PARAM_STR);
            $comando->bindParam(':cod_parametro', $cod_parametro, PDO::PARAM_STR);
            $comando->execute();

            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

 
    public static function validaTarjeta($cod_tarjeta, $id_comensal, $observacion) {
        try {

            $vfecha = date("d/m/Y H:i:s");
            $result = "";
            $mensaje = "";
            //PRINT $vfecha;

            //echo "asdasd";

            $vcod_empresa = "1";
            $sql = "begin :res := rhf_verifica_tarjeta(:pcod_empresa,
                                                       :pcod_tarjeta,
                                                       :pfecha,
                                                       :pid_comensal,
                                                       :pobservacion,
                                                       :pmensaje); end;";
            //print_r($sql);
            // Preparar sentencia
            //print_r($persona);
            //print $persona['NOMBRE'];
            $comando = oraconnect::getInstance()->getDb()->prepare($sql);
            $comando->bindParam(':res', $result, /*PDO::PARAM_STR |*/ PDO::PARAM_INPUT_OUTPUT, 400);
            $comando->bindParam(':pcod_empresa', $vcod_empresa, PDO::PARAM_STR);
            $comando->bindParam(':pcod_tarjeta', $cod_tarjeta, PDO::PARAM_STR);
            $comando->bindParam(':pfecha', $vfecha, PDO::PARAM_STR);
            $comando->bindParam(':pid_comensal', $id_comensal, PDO::PARAM_STR);
            $comando->bindParam(':pobservacion', $observacion, PDO::PARAM_STR);
            $comando->bindParam(':pmensaje', $mensaje, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 400);


            $comando->execute();

            $respuesta['RESULTADO'] = $result;
            $respuesta['MENSAJE'] = $mensaje;

            //print_r($respuesta);

            return $respuesta;
        } catch (Exception $e) {
            print_r($e->getMessage());
            //return false;
            return $e->getMessage();
        } catch (PDOException $e) {
            print_r($e->getMessage());
            //return false;
            return $e->getMessage();
        }
    }

    /**
     * Valida Trae datos de cliente
     *
     * @param Documento y codigo de cliente
     * @return Datos de cliente
     */
    public static function ListarComensales($busqueda, $pag, $id_comensal) {
        //print($busqueda." ".$pag);
        $cant = 10;
        try {
            $conn = null;
            $sql = "select DSA.CODIGO, DSA.NOMBRE
                    from (select asd.*, rownum r
                            from (

                            SELECT E.CODIGO, E.NOMBRE
                                    FROM RHV_COMENSALES_COMEDOR E
                                   WHERE (((E.CODIGO like
                                         upper('%' || trim(:busqueda) || '%') OR
                                         E.NOMBRE like upper('%' || trim(:busqueda1) || '%')) and
                                         :CODIGO is null) or
                                         :CODIGO2 = E.CODIGO)


                                     and rownum <= ({$pag} * {$cant})) asd) dsa
                   where r >= ({$pag} + ({$pag} * {$cant}) - ({$cant} + {$pag}) + 1)";
                               
            $comando = oraconnect::getInstance()->getDb()->prepare($sql);
            $comando->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
            $comando->bindParam(':busqueda1', $busqueda, PDO::PARAM_STR);
            $comando->bindParam(':CODIGO', $id_comensal, PDO::PARAM_STR);
            $comando->bindParam(':CODIGO2', $id_comensal, PDO::PARAM_STR);
            $comando->execute();                 

            $result = $comando->fetchAll(PDO::FETCH_ASSOC);

            return utf8_converter($result);
        } catch (PDOException $e) {
            return print_r($e->getMessage());
        }
    }

}
