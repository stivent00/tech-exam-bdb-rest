<?php
require_once('DataDB.php');

class Controller{

    public function getLocations(){
        // Consulta todas las ubicaciones
        $db = new DataDB;
        $select = "SELECT id_location, name_location, area_location, id_parent FROM location";
        return $db->selectQuery($select);
    }

    public function getLocation( $id ){
        // Valida Id
        $validacion = json_decode( $this->validaId( $id ), true );
        if( $validacion['error'] ){
            return '[{"status": 400, "mesage": "'.$validacion['msg'].'"}]';
        }else{
            // Consulta la ubicacion por id
            $db = new DataDB;
            $select = "SELECT id_location, name_location, area_location, id_parent FROM location WHERE id_location = " . $id;
            return $db->selectQuery($select);
        }
    }

    public function setLocations( $data ){
        // Valida data
        $validacion = json_decode( $this->validaDatos( $data ), true );
        if( $validacion['error'] ){
            return '[{"status": 400, "mesage": "'.$validacion['msg'].'"}]';
        }else{
            // Guarda el registro de la ubicación
            $db = new DataDB;
            if( is_null($data['id_parent']) )
                $insert = "INSERT INTO location (id_location, name_location, area_location, id_parent) VALUES (".$data['id'].",'".$data['name']."',".$data['area'].", NULL)";
            else
                $insert = "INSERT INTO location (id_location, name_location, area_location, id_parent) VALUES (".$data['id'].",'".$data['name']."',".$data['area'].", ".$data['id_parent'].")";

            return $db->insertDB($insert);
        } 
    }

    public function validaDatos( $data ){
        $error = false;
        $error_msg = "Error: ";        

        // Valida si el arreglo tiene el tamaño correcto
        if( count($data, 0 ) == 4 ){
            // Valida dato id
            if( array_key_exists('id', $data) ){
                if( !is_int($data['id']) ){
                    $error = true;
                    $error_msg .= "El valor del dato id es incorrecto. ";
                }
            }else{
                $error = true;
                $error_msg .= "No se encuentra el dato id. ";
            }
            // Valida dato name
            if( array_key_exists('name', $data) ){
                if( empty($data['name']) ){
                    $error = true;
                    $error_msg .= "El dato name no puede ser vacio. ";
                }
            }else{
                $error = true;
                $error_msg .= "No se encuentra el dato name. ";
            }
            // Valida dato area
            if( array_key_exists('area', $data) ){
                if( !is_int($data['area']) ){
                    $error = true;
                    $error_msg .= "El valor del dato area es incorrecto. ";
                }
            }else{
                $error = true;
                $error_msg .= "No se encuentra el dato area. ";
            }
            // Valida dato id_parent
            if( array_key_exists('id_parent', $data) ){
                if( !is_int($data['id_parent']) && !is_null($data['id_parent']) ){
                    $error = true;
                    $error_msg .= "El valor del dato id_parent es incorrecto. ";
                }
            }else{
                $error = true;
                $error_msg .= "No se encuentra el dato id_parent. ";
            }
        }else{
            $error = true;
            $error_msg .= "Numero de datos incorrecto. ";
        }

        return json_encode( array("error" => $error, "msg" => $error_msg) );
    }

    public function validaId( $id ){
        $error = false;
        $error_msg = "Error: ";
        // Valida dato id
        if( !is_numeric($id) ){
            $error = true;
            $error_msg .= "El valor del dato id es incorrecto. ";
        }
        return json_encode( array("error" => $error, "msg" => $error_msg) );
    }

}
?>