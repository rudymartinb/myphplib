<?php

namespace mylib {
	
	/* lo optimo hubiera sido 
	 * q estas interfaces formen parte de la clase mysql_wrapper
	 * pero php no lo permite
	*/ 
	interface proveedor_datos_sql {
		public function abrir( credenciales_host $cred  );
		public function cerrar( );
		public function ejecutar( $query );
	}	
	
	/* esto es una mezcla de credenciales 
	 * e info de host de server
	 * la idea es externalizar la implementacion en particular
	 * ejemplo: que dichos datos sean extraido de un archivo ini
	 * o que la info devuelta sea dinamica en funcion del usuario que se loguea
	*/
	interface credenciales_host {
		public function get_host();
		public function get_user();
		public function get_pwd();
		public function get_catalogo();
		public function get_port();
	}



	class mysql_wrapper implements proveedor_datos_sql {
		/*
		 * la idea de la variable estática es evitar multiples conexiones
		 * pero puede ser un problema en caso de transacciones.
		*/
		private $db = null;
		private static $conexiones = 0;
		
		private $error;
		function __construct(  ){
		}

		function get_conexiones(){
			return self::$conexiones;
		}

		function abrir( credenciales_host $cred ){
			if( $this->db !== null )
				return;
			
			$host = $cred->get_host();
			$user = $cred->get_user();
			$pwd  = $cred->get_pwd();
			$catalogo = $cred->get_catalogo();
			$port = $cred->get_port();

			$this->db = new \mysqli( $host, $user, $pwd, $catalogo, $port );

		}
		
		
		function abierta() {
			if( $this->db === null )
				return false;
			return $this->db->connect_errno != 0;
		}

		/* conviene cerrar unicamente si es estrictamente necesario
		*/
		function cerrar( ){
			if( $this->abierta() ){ 
				$this->db->close();
			}
			$this->db = null;
		}
		
		function ejecutar( $query ){
			//~ if( $this->db === null )
				//~ throw new \Exception( "Conexion cerrada!" );

			$res = $this->db->query( $query, MYSQLI_STORE_RESULT );

			if( $this->db->errno != 0 ){
				throw new \Exception( $this->db->error );
			}
			
			if( gettype( $res ) == "boolean" )
				return $res ;		

			return $res->fetch_all( MYSQLI_ASSOC );
		}
		function esIgual( $db2 ){
			return $this->db === $db2->db ;
	}
	}
	
	
}
?>