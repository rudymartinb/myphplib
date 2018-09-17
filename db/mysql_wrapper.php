<?php


namespace mylib {

	class mysql_wrapper implements proveedor_datos_sql {
		private $db = null;
		private $error = "";
		private $errno = "";

		function abrir( credenciales $usuario, host $servidor ){
			if( $this->db !== null )
				return;

			$user = $usuario->get_user();
			$pwd  = $usuario->get_pwd();
			
			$host = $servidor->get_host();
			$catalogo = $servidor->get_catalogo();
			$port = $servidor->get_port();

			$this->db = new \mysqli( $host, $user, $pwd, $catalogo, $port );
		}
		function get_error() : string {
            return $this->error; 
		}
		

		function cerrar( ){
		    
			$this->db->close();
			$this->db = null;
		}
		
		function ejecutar( $query ){
		    
			$res = $this->db->query( $query, MYSQLI_STORE_RESULT );

			if( $this->db->errno != 0 ){
			    $this->errno = $this->db->errno;
			    $this->error = $this->db->error;
				// throw new \Exception( $this->db->error );
			}
			
			if( gettype( $res ) == "boolean" )
				return $res ;		

			$lista = [];
			while( true ){
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				if( $arr === null ) {
					return $lista;
				}
				$lista[] = $arr;
			}

		}
		
		function esIgual( $db2 ){
			return $this->db === $db2->db ;
		}
	}
	
	
}
?>