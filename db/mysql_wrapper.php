<?php

namespace mylib;

class mysql_wrapper {
	private static $db = null;
	function mysql_wrapper(){
	}
	
	function abrirDefault( $catalogo = "distdev" ){
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$this->abrir( $host, $user, $pwd, $catalogo, $port );		
	}
	
	function abrir( $host, $user, $pwd, $catalogo, $port ){
		try{
			self::$db = new \mysqli( $host, $user, $pwd, $catalogo, $port );	
		} catch( Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	function cerrar( ){
		self::$db->close();
		self::$db = null;
	}
	
	function ejecutar( $query ){
		if( self::$db === null )
			throw new Exception( "Conexion cerrada!" );
			
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

?>
