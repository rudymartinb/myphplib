<?php

namespace mylib {
	
	interface proveedor_sql {
		public function abrirDefault();
		public function abrir( $host, $user, $pwd, $catalogo, $port );
		public function cerrar( );
		public function ejecutar( $query );
	}	

	class mysql_wrapper implements proveedor_sql {
		private static $db = null;
		private static $conexiones = 0;
		
		function mysql_wrapper(){
		}
		
		function get_conexiones(){
			return self::$conexiones;
		}
		
		function abrirDefault( $catalogo = "distdev" ){
			$host = "127.0.0.1"; 
			$user = "root";
			$pwd = "sunpei42";
			$port = 3306;
			$this->abrir( $host, $user, $pwd, $catalogo, $port );		
		}
		
		function abrir( $host, $user, $pwd, $catalogo, $port ){
			if( self::$db !== null ){
				return;
			}
			try {
				self::$db = new \mysqli( $host, $user, $pwd, $catalogo, $port );	
			} catch( Exception $e ) {
				throw new \Exception( $e->getMessage() );
			}
		}

		/* conviene cerrar unicamente si es estrictamente necesario
		*/
		function cerrar( ){
			self::$db->close();
			self::$db = null;
		}
		
		function ejecutar( $query ){
			if( self::$db === null )
				throw new \Exception( "Conexion cerrada!" );
				
			try{
				$res = self::$db->query( $query, MYSQLI_STORE_RESULT );
			} catch( Exception $e ) {
				throw new \Exception( $e->message.' --> '. $e->getTraceAsString() );
			}

			if( self::$db->errno != 0 ){
				throw new \Exception( self::$db->error );
			}
			if( gettype( $res ) == "boolean" )
				return $res ;		

			return $res->fetch_all( MYSQLI_ASSOC );
		}
	}
}
?>