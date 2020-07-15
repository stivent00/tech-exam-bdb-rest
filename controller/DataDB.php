<?php
class DataDB {

    private $server;    
    private $user; 
    private $password; 
    private $database; 
    private $port; 
    private $connection; 
    private $strConnection;

    //Creación del constructor
    function __construct(){
        // Cargar los valores de la conexión.
        $this->server = 'localhost';
        $this->user = 'restapi';
        $this->password = '#r3sS7t*_4P1-Pg$QL';
        $this->database = 'api';
        $this->port = '5432';
        $this->strConnection = 'host=' .$this->server . ' port=' . $this->port . ' dbname=' . $this->database . ' user=' . $this->user . ' password=' . $this->password;
        // Crea conexión a la DB
        $this->connection = pg_connect( $this->strConnection );
    }

    // Consulta registros a la BD
    public function selectQuery( $select ){       
        if( $this->connection === false ) {
            return '[{"status": 500, "mesage": "No se pudo conectar a la BD."}]';
        }else{            
            $data = pg_query( $this->connection, $select ) or die('Error: ' . pg_last_error());
            $response = array();
            while ($row = pg_fetch_assoc($data)) {
                $response[] = $row;
            }
            return json_encode($response);
        }
    }

    // Inserta registro a la BD
    public function insertDB( $insert ){
        if( $this->connection === false ) {
            return '[{"status": 500, "mesage": "No se pudo conectar a la BD."}]';
        }else{ 
            // Ejecuta el insert (se devolverá true o false):
            if( pg_query( $this->connection, $insert ) ){
                return '[{"status": 200, "mesage": "La ubicacion se ha registrado correctamente."}]';
            }else{
                return '[{"status": 500, "mesage": "No se pudo guardar la ubicacion."}]';
            }
        }
    }

}


?>