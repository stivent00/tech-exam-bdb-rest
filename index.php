<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];

require_once('controller/Controller.php');

if( isset($_GET['url']) ){
    $var = $_GET['url'];
    $id = intval( preg_replace('/[^0-9]+/', '', $var), 10 );

    if( $method == 'GET' ){
        switch( $var ){
            case "locations";
                $controller = new Controller;
                print_r( $controller->getLocations() );
            break;
            case "location/" . $id;
                $controller = new Controller;
                print_r( $controller->getLocation( $id ) );
            break;
            default;
                // Error Metodo no encontrado
                http_response_code(400);
            break;
        }
    }elseif( $method == 'POST' ){
        
        $postBody = file_get_contents("php://input");
        $conver = json_decode( $postBody, true );
        if( json_last_error() == 0 ){
            switch( $var ){
                case "setlocation";
                    $controller = new Controller;
                    print_r( $controller->setLocations( $conver ) );
                break;
                default;
                    // Error Metodo no encontrado
                    http_response_code(400);
                break;
            }            
        }else{
            http_response_code(400);
        }        
    }else{
        // Error Metodo no permitido
        http_response_code(405);
    }
}else{ 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RestAPI</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!-- Bootstrap recursos -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	</head>
	<body>
        <div class="container">
            <div class="row">
                <div class="col m-5">
                    <h1>Metadata</h1>                    
                    <div class="card mt-4">
                        <h5 class="card-header">Locations</h5>
                        <div class="card-body">
                            <div class="alert alert-secondary" role="alert">
                                <h5>POST</h5>
                                <p>/setlocation</p>
                            </div>
                            <div class="alert alert-secondary" role="alert">
                                <h5>GET</h5>
                                <p>/locations<br>/location/$id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap recursos -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	</body>
</html>


<?php
}
?>