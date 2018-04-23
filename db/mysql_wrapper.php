<?php

namespace mylib {
	
	interface proveedor_datos_sql {
		// public function abrirDefault( $cat );
		public function abrir( $host, $user, $pwd, $catalogo, $port );
		public function cerrar( );
		public function ejecutar( $query );
	}	


	class mysql_wrapper implements proveedor_datos_sql {
		/*
		 * la idea de la variable estática es evitar multiples conexiones
		 * pero puede ser un problema en caso de transacciones.
		*/
		private $db = null;
		private static $conexiones = 0;
		
		function __construct(  ){
			// $this->abrir( $host, $user, $pwd, $catalogo, $port );
		}
		
		function get_conexiones(){
			return self::$conexiones;
		}

		function abrir( $host, $user, $pwd, $catalogo, $port ){
			if( $this->db !== null ){
				return;
			}			
			if( $catalogo == null )
				$catalogo = "distdev";
			$host = "127.0.0.1"; 
			$user = "root";
			$pwd = "sunpei42";
			$port = 3306;

			$this->db = new \mysqli( $host, $user, $pwd, $catalogo, $port );

			/* lamentablemente uno de los pocos casos en que usar @ no es un error
			 * si en lugar de usar arroba pongo un try/catch, deteminaos errores como inexistencia de la DB 
			 * haran que el programa se interrumpa
			*/
			// $this->db->connect;
			
			// $this->abrir( $host, $user, $pwd, $catalogo, $port );		
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
			if( $this->db === null )
				throw new \Exception( "Conexion cerrada!" );

			// var_dump( $this->db );				
			try{
				$res = $this->db->query( $query, MYSQLI_STORE_RESULT );
			} catch( Exception $e ) {
				throw new \Exception( $e->message.' --> '. $e->getTraceAsString() );
			}

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