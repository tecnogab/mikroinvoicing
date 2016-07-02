<?php  

require_once "../conn/conexion.php"; 

class Clientes extends Conexion{     
			
		
	function getIdClient($dni){
		
		$phpConn = new Conexion();
		$conn = $phpConn->connectDB();
		//Consulta SQL
		$sql = "SELECT id_cli FROM t_clientes WHERE dni_cli = '$dni'";
		
		if(!$result = mysqli_query($conn, $sql)) 
			die();			
		
		$id_cliente;
		if ($row = mysqli_fetch_array($result))
			$id_cliente = $row['id_cli'];				
			
		
		$phpConn->disconnectDB($conn); //desconectamos la base de datos		
		
		//Creamos el JSON
		$json_string = json_encode($id_cliente);
		echo $json_string;
	}
	
	function getAllClients(){
		
		$phpConn = new Conexion();
		$conn = $phpConn->connectDB();
		//Consulta SQL
		$sql = "SELECT * FROM t_clientes";
		
		if(!$result = mysqli_query($conn, $sql)) 
			die();			
		
		$rawdata = array();
		$rawdata = mysqli_fetch_array($result);
        //guardamos en un array multidimensional todos los datos de la consulta
        //$i=0;
        //while($row = mysqli_fetch_array($result)){   
			//guardamos en rawdata todos los vectores/filas que nos devuelve la consulta
        //    $rawdata[$i] = $row;
        //    $i++;
        //}	
					
		$phpConn->disconnectDB($conn); //desconectamos la base de datos		
		
		//Creamos el JSON
		$json_string = json_encode($rawdata);
		echo $json_string;
	}


	//inserta en la base de datos un nuevo registro en la tabla usuarios
    function insertClient($dni, $nombre, $apellido, $fecha_up){
        
		$phpConn = new Conexion();
		$conn = $phpConn->connectDB();
        
		//Escribimos la sentencia sql necesaria respetando los tipos de datos
    	$sql = "INSERT INTO t_clientes (dni_cli, nombre_cli, apellido_cli, fecha_up_cli) values ('".$dni."', '".$nombre."','".$apellido."','".$fecha_up."')";
        
		//hacemos la consulta y la comprobamos 
        $consulta = mysqli_query($conn, $sql);
        if(!$consulta){
            echo "No se ha podido insertar el cliente en la base de datos<br><br>".mysqli_error($conn);
        }

        printf (mysqli_insert_id($conn));
        $phpConn->disconnectDB($conn); //desconectamos la base de datos
        //devolvemos el resultado de la consulta (true o false)
        return $consulta;
    }
	
	function borrarCliente($dni){
		$phpConn = new Conexion();
		$conn = $phpConn->connectDB();        		
		$stmt = mysqli_prepare($conn, "DELETE FROM t_clientes WHERE dni_cli = ?");
		mysqli_stmt_bind_param($stmt, 's', $dni);								
		mysqli_stmt_execute($stmt);														//ejecuta sentencias preparadas		
		printf("%d Filas borradas.\n", mysqli_stmt_affected_rows($stmt));		
		mysqli_stmt_close($stmt);														//cierra sentencia y conexión		
		$phpConn->disconnectDB($conn); 													//desconectamos la base de datos        
	}
}