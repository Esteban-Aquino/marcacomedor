<?php

require 'db.php';
/* try {
  foreach(PDO::getAvailableDrivers() as $driver)
  echo $driver, '<br>';

  $mbd = new PDO(
  'oci:dbname = '.TNS,
  USERNAME,
  PASSWORD);
  foreach($mbd->query('SELECT nombre from personas where cod_persona = 14598') as $fila) {
  print_r($fila);
  }
  $mbd = null;

  } catch (PDOException $e) {
  print "¡Error!: " . $e->getMessage() . "<br/>";
  die();
  } */

 $tns = "
        (DESCRIPTION =
            (ADDRESS_LIST =
              (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.2.199)(PORT = 1521))
            )
            (CONNECT_DATA =
              (SERVICE_NAME = GUATA)
            )
          )";
try {
    echo "Drivers disponibles: <BR>";
    foreach (PDO::getAvailableDrivers() as $driver) {
        echo ' - ' . $driver, '<br>';
    }
    
    
    echo " *************************** <BR>";
    echo "Conectando Oracle... <BR>";
    
    
    //echo 'DATABASE: ', DATABASE,', USERNAME: ', USERNAME, ', PASSWORD: ', PASSWORD,'<BR>';
    echo "<BR><BR><BR>";


    /* $conn = new PDO('odbc:Driver={Microsoft ODBC for Oracle};
      Server=' . DATABASE, USERNAME, PASSWORD); */
    
    
    $conn = new PDO("oci:dbname=".$tns, 'INV', 'INVGUATA');
    
    
    $stmt = $conn->query("select * from personas WHERE ROWNUM = 1");
    
    $stmt->execute();

    
    
    
    
    
    IF ($conn === null) {
        echo("Error al conectar <BR>");
    } else {
        echo "Conectado!! <BR>";
    }
    echo "<BR><BR><BR>";

    echo "Consulta a personas de prueba: <BR>";

    while ($row = $stmt->fetch()) {
        print_r($row['COD_PERSONA'] . " " . $row['NOMBRE'] . " " . $row['APELLIDO'] . "<BR>");
    }

    echo "<BR><BR><BR>**** By Esteban Aquino **** <BR>";
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    echo "<BR><BR><BR>***** By Esteban Aquino ***** <BR>";
    die();
}

/*  try {
  $conn = oci_connect("inv", "masterinv","SOL");

  IF (!$conn){
  echo("Error al conectar");

  }else{
  echo "Conectado!!";
  }
  } catch (PDOException $e) {
  print "¡Error!: " . $e->getMessage() . "<br/>";
  die();
  } */
?>

